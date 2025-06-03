<?php

namespace App\Console\Commands\TextLink;

use Illuminate\Console\Command;
use App\Models\TextLink;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckTL extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tl:check-tl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    protected $tl;
    public function __construct(TextLink $tl)
    {
        parent::__construct();
        $this->tl = $tl;
    }

    public function handle()
    {   
        Log::info('*************Start check textlinks at: ' . Carbon::now()->format('d-m-Y H:i:s'));
        $this->tl->check_textlinks($this->tl->get()->groupBy('target_domain'));
        Log::info('*************End check textlinks at: ' . Carbon::now()->format('d-m-Y H:i:s'));
    }
}
