<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetDatabaseTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //DB::table('store_all_tag_record')->truncate();
        
       // DB::table('store_all_tag_record')->where('created_at', '<=', Carbon::now()->subDay())->delete();
    }
}
