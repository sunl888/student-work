<?php

namespace App\Listeners;

use App\Events;
use App\Models\Role;
use App\Models\User;
use App\Repositories\CollegeRepository;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\Queue\ShouldQueue;

class ImportUsers implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  ImportUsers $event
     * @return void
     */
    public function handle(Events\ImportUsers $event)
    {
        //$role = app(Role::class);
        Excel::load($event->xls_path, function ($reader)/* use ($role) */{
            //获取excel的第1张表
            $reader = $reader->getSheet(0);
            //获取表中的数据
            $data = $reader->toArray();

            $data = $this->validated($data);
            $this->import_users($data/*, $role*/);
        });
    }

    //Excel文件导入功能

    /**
     * @param $data
     */
    public function import_users($data/*, Role $role*/)
    {
        $role = app(Role::class);
        $teacher_id = $role->where(['name' => Role::TEACHER])->first()->id ?: 3;
        $xueyuan_id = $role->where(['name' => Role::COLLEGE])->first()->id ?: 2;
        $admin_id = $role->where(['name' => Role::SUPER_ADMIN])->first()->id ?: 1;
        foreach ($data as $key => $value) {
            $user['name'] = trim($value[1]); //工号
            $user['nickname'] = trim($value[2]);// 姓名
            $user['gender'] = random_int(0, 1);// 性别
            $user['password'] = bcrypt(trim('hnnu' . $value[1]));// 密码
            $user['email'] = 'test@admin.com';//app(\Faker\Generator::class)->freeEmail;// email
            $user['picture'] = 'images/picture.jpg';// 头像
            $user['phone'] = $value[4];// 电话
            if (is_null($value[5])) {
                // 一般用户
                $role = $teacher_id;
            } else if ($value[5] === '二级学院') {
                $role = $xueyuan_id;
            } else if ($value[5] === '管理员') {
                $role = $admin_id;
            }
            $college = app(CollegeRepository::class)->where(['title' => $value[0]])->first();
            if (!!$college) {
                $user['college_id'] = $college->id;
            } else {
                $user['college_id'] = 1;
            }
            $userInfo = User::create($user);
            $userInfo->roles()->attach($role);
            unset($userInfo, $role, $userRoleInfo);
        }
    }

    public function validated(array $data)
    {
        $news = [];
        foreach ($data as $item) {
            if (is_null($item)) {
                continue;
            }
            if (!is_numeric($item[1])) {
                continue;
            }
            // 是否已经存在
            $hasUser = !!(User::where('name', $item[1])->first());
            if ($hasUser == true) {
                continue;
            }
            $news[] = $item;
        }
        return $news;
    }
}
