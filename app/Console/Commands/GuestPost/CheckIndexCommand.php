<?php

namespace App\Console\Commands\GuestPost;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\GuestPost;

class CheckIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gp:check-index-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This task will check index guest post schedule';

    protected $gp;
    public function __construct(GuestPost $gp)
    {
        parent::__construct();
        $this->gp = $gp;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {    
        
    }
}
