<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class ImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users {--admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '导入老师的数据';

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
        $option = $this->option('admin');
        if ($option) {
            $users = [
                [
                    'name' => 'admin',
                    'nickname' => 'admin',
                    'gender' => 1,
                    'password' => bcrypt('admin'),
                    'email' => app(\Faker\Generator::class)->freeEmail,
                    'picture' => 'images/picture.jpg',
                    'college_id' => null,
                ]
            ];
            foreach ($users as $user) {
                $userInfo = User::create($user);
                $role = Role::where(['name' => 'super_admin'])->first()->id ?: 1;
                $userInfo->roles()->attach($role);
                unset($userInfo, $role, $userRoleInfo);
            }
        } else {
            /**
             * $value[0]; 工号   $value[1]; 姓名
             * $value[2]; 性别   $value[3]; 所属类型
             * $value[4]; 所在单位  $value[5]; 职位
             */
            event(new \App\Events\ImportUsers($this->getFilePath()));
        }
    }

    public function getFilePath()
    {
        return storage_path('data') . '/users.xlsx';
    }
}
