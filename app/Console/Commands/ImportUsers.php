<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users {--truncate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '导入用户数据 --truncate 清空以前的数据并导入新数据';

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
        $option = $this->option('truncate');
        if ($option){
            if ($this->confirm('你确定要清空以前的数据并重新执行导入操作?')) {
                \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                User::all()->each(function ($user){
                    $user->roles()->detach();
                });
                User::truncate();
                \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }
        }
        event(new \App\Events\ImportUsers($this->getFilePath()));

    }

    public function getFilePath()
    {
        return storage_path('data') . '/users.xlsx';
    }
}
