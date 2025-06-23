<?php

namespace App\Models;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GuestPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'guest_posts';

    protected $fillable = [
        'domain_id',
        'target_domain',
        'impl_date',
        'status',
        'amount',
        'source_link',
        'post_link',
        'ctv_id'
    ];

    public function website()
    {
        return $this->belongsTo(Website::class, 'domain_id');
    }

    public function ctv()
    {
        return $this->belongsTo(CTV::class, 'ctv_id');
    }

    public function createGP($request)
    {
        return $this->cud_action('create', $request);
    }

    public function updateGP($request)
    {
        return $this->cud_action('update', $request);
    }

    public function deleteGP($request)
    {
        return $this->cud_action('delete', self::find($request));
    }

    public static function gpAttrs()
    {
        return [
            'target_domain',
            'impl_date',
            'status',
            'amount',
            'source_link',
            'post_link',
            'website_name',
            'ctv_name',
            'actions'
        ];
    }

    public static function csvFields(){
        return [
            'trang_dat',
            'link_bai_viet',
            'link_dat',
            'gia',
            'domain',
            'ngay_dat',
            'ctv'
        ];
    }

    public function gp_data_result($at_arr)
    {

        foreach ($at_arr as $at) {
            switch ($at) {
                case 'impl_date':
                    $tl[$at] = Carbon::parse($this->$at)->format('d-m-Y');
                    break;
                case 'actions':
                    $tl[$at] = [route('gp.input-edit.layout', $this->id), route('gp.delete', $this->id)];
                    break;
                case 'website_name':
                    $tl[$at] = $this->website->name;
                    break;
                case 'ctv_name':
                    $tl[$at] = $this->ctv->account_id;
                    break;
                default:
                    $tl[$at] = $this->$at;
                    break;
            }
        }

        return $tl;
    }

    public static function get_gps_data($gp, $attrs_custom = null)
    {
        return $attrs_custom ?  $gp->gp_data_result($attrs_custom) : $gp->gp_data_result(self::gpAttrs());
    }

    public static function getAllGP()
    {
        return self::with('website', 'ctv')->get()->map(function ($gp) {
            return self::get_gps_data($gp);
        });
    }

    public static function prepare_data($request)
    {
        $data = $request->except('_token', 'gp_id');
        $data['impl_date'] = Carbon::createFromFormat('Y-m-d', $data['impl_date']);
        $data['target_domain'] = strtolower($data['target_domain']);
        $datap['post_link'] = strtolower($data['post_link']);
        return $data;
    }

    public function cud_action($action, $request)
    {
        DB::beginTransaction();
        try {
            if ($action !== 'delete') {
                $data = $this->prepare_data($request);
            }
            switch ($action) {
                case 'create':
                    self::create($data);
                    break;
                case 'update':
                    $data['updated_at'] = Carbon::now();
                    self::find($request->gp_id)->update($data);
                    break;
                case 'delete':
                    $request->delete();
                    break;
                default:
                    # abcd-xya
                    break;
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return false;
        }
    }

    public static function check_index_gp_action($gps, $attr)
    {
        // have not checked whether there are enough proxies or not?        
        $promises = [];
        $client = new Client();
        $dom = new \DOMDocument();
        $proxies = Proxy::getProxies();
        $done_index = [];
        $result = [];

        if ((count($proxies) * config('my_config.proxy.max_requests')) < count($gps)) {
            return false;
        }

        $index_rand = array_rand($proxies->toArray());
        $tmp_proxy = $proxies[$index_rand];
        libxml_use_internal_errors(true);

        foreach ($gps as $key_gp => $gp) {
            $promises[] = function () use ($client, $dom, $gp, $tmp_proxy, $attr, $key_gp, &$result, &$done_index) {
                return $client->getAsync("https://www.google.com/search?q=site:{$gp->post_link}", [
                    'proxy' => [
                        'https' => $tmp_proxy->getURL()
                    ],
                    'connect_timeout' => 3,
                    'verify' => false
                ])->then(
                    function ($response) use ($dom, $gp, $tmp_proxy, $attr, $key_gp, &$result, &$done_index) {
                        $tmp_proxy->number_request++;
                        $tmp_proxy->save();

                        $html = $response->getBody()->getContents();
                        $dom->loadHTML($html);
                        $xpath = new \DOMXPath($dom);
                        $condition = "//div[contains(@class, 'Gx5Zad')]//div[contains(@class, 'kCrYT')]//a[contains(@href, '" . $gp->post_link . "')]";
                        $match = $xpath->query($condition)->item(0);

                        empty($match) ? $gp->status = false : $gp->status = true;
                        $gp->save();
                        $result[] = $gp->get_gps_data($gp, $attr);
                        $done_index[] = $key_gp;
                    },
                    function (\Exception $e) use ($gp, $tmp_proxy) {
                        $tmp_proxy->is_usable = 0;
                        $tmp_proxy->save();
                    }
                );
            };
        }



        $pool = new Pool($client, $promises, [
            'concurrency' => 15,
            'rejected' => function ($reason, $i) {
                Log::error('rejected %s', ['exception' => $reason]);
                throw new \Exception('break out pool');
            }

        ]);

        try {
            $pool->promise()->wait();
        } catch (\Throwable $th) {
            return  [
                'result' => $result,
                'done_index' => $done_index
            ];
        }


        return  [
            'result' => $result,
            'done_index' => $done_index
        ];
    }

    public static function check_index_gp($gps, $attr = null)
    {
        $checking_data['result'] = [];

        while (count($gps) > 0) {            
            $tmp_result = self::check_index_gp_action($gps, $attr);
            $gps = array_diff_key($gps, array_flip($tmp_result['done_index']));
            $checking_data['result'] = array_merge($checking_data['result'], $tmp_result['result']);
        }

        return $checking_data['result'];
    }

    public static function removeGPAttrs($arr_rm)
    {
        $tmp_atts = self::gpAttrs();
        Arr::forget($tmp_atts, $arr_rm);
        return array_values($tmp_atts);
    }

    public static function mappingDataFromCSV($data)
    {
        return [
            'target_domain' => $data['trang_dat'],
            'impl_date' => $data['ngay_dat'],
            'source_link' => $data['link_bai_viet'],
            'post_link' => $data['link_dat'],
            'amount' => $data['gia'],
            'website_name' => $data['domain'],
            'ctv_name' => $data['ctv']
        ];
    }
}
