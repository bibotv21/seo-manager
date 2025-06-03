<?php

namespace App\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Proxy extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'proxies';
    protected $fillable = [
        'ip',
        'port',
        'username',
        'password',
        'is_usable',
        'provider'
    ];


    public static function checkProxiesIsUsable()
    {
        $client = new Client();
        $result = [];
        $promises = [];
        $proxies = self::all();


        foreach ($proxies as $val) {
            $promises[] = function () use ($client, $val, &$result) {
                return $client->getAsync('https://www.google.com/search?q=' . config('myconfig.common.query_string_checking'), [
                    'proxy' => [
                        'https' => $val->getURL()
                    ]
                ])->then(
                    function ($response) use ($val, &$result) {
                        $val->is_usable = 1;
                        $val->number_request = 0;
                        $val->save();
                        $result[] = $val;
                    },
                    function (\Exception $exception) use ($val, $client) {
                        $val->is_usable = 0;
                        $val->save();
                        Log::error('Checking IPs is usable has the error: %s', ['exception' => $exception->getMessage()]);
                    }
                );
            };
        }

        $pool = new Pool($client, $promises, [
            'concurrency' => 5,
            'rejected' => function ($reason, $index) {
                Log::error('Checking IPs is usable has the error: %s', ['exception' => $reason]);
            },
        ]);
        $pool->promise()->wait();

        return $result;
    }

    public static function getProxies()
    {
        return self::where('is_usable', 1)->where('number_request', '<', config('my_config.proxy.max_requests'))->get();
    }

    public function getURL()
    {
        if (empty($this->ip)) {
            return '';
        } else {
            return 'http://' . ($this->user_name ? $this->user_name . ':' . $this->password . '@' : '') . $this->ip . ':' . $this->port;
        }
    }
}
