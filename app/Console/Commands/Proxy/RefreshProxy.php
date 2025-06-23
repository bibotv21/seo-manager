<?php

namespace App\Console\Commands\Proxy;

use Illuminate\Console\Command;
use App\Models\Proxy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RefreshProxy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxy:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    protected $proxy;
    public function __construct(Proxy $proxy)
    {
        parent::__construct();
        $this->proxy = $proxy;
    }

    public function handle()
    {
        Log::info('***********Start processing refresh proxies at: ' . Carbon::now()->format('d-m-Y H:i:s') . '***********' );
        $this->proxy->checkProxiesIsUsable();
        Log::info('***********End processing refresh proxies at: ' . Carbon::now()->format('d-m-Y H:i:s') . '***********' );
    }
}
