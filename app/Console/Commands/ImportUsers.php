<?php

namespace App\Console\Commands;

use App\Models\College;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

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
                    'name' => 'xsc',
                    'nickname' => 'xsc',
                    'gender' => 0,
                    'password' => bcrypt('xsc'),
                    'email' => app(\Faker\Generator::class)->freeEmail,
                    'picture' => 'images/picture.jpg',
                    'college_id' => null,
                ], [
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
            Excel::load($this->getFilePath(), function ($reader) {
                $results = $reader->getSheet(1)->toArray();
                array_shift($results);// 将表头移除
                foreach ($results as $key => $value) {
                    $user['name'] = (int)$value[0]; //工号
                    $user['nickname'] = $value[1];// 姓名
                    $user['gender'] = $value[2] == '男' ? 0 : 1;// 性别
                    $user['password'] = bcrypt(trim($value[0]));// 密码
                    $user['email'] = app(\Faker\Generator::class)->freeEmail;// email
                    $user['picture'] = app(\Faker\Generator::class)->imageUrl(640, 480);// 头像
                    $user['college_id'] = College::where('title', $value[4])->first()->id;// 学院id
                    $userInfo = User::create($user);
                    if (strpos($value[3], '书记') != false || strpos($value[5], '书记') != false) {
                        $role = Role::where(['name' => 'college'])->first()->id;
                    } else {
                        $role = Role::where(['name' => 'teacher'])->first()->id ?: 1;
                    }
                    $userInfo->roles()->attach($role);
                    unset($userInfo, $role, $userRoleInfo);
                }
            });
        }
    }

    public function getFilePath()
    {
        return storage_path('data') . '/users.xlsx';
    }
}
