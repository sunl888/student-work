<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function upload_users(\Illuminate\Http\Request $request)
    {
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file;
            $realPath = $file->getRealPath();
            $extension = $file->getClientOriginalExtension(); //上传文件的后缀.
            $tabl_name = date('YmdHis') . mt_rand(100, 999);
            $newName = $tabl_name . '.' . $extension;//$entension;
            $file->move(storage_path() . '/uploads', $newName);
            $cretae_path = storage_path() . '/uploads/' . $newName;

            Excel::load($cretae_path, function ($reader) use ($tabl_name) {
                //获取excel的第n张表
                $reader = $reader->getSheet(0);
                //获取表中的数据
                $data = $reader->toArray();
                return $this->import_users($data);
            });
        }
    }

    //Excel文件导入功能
    public function import_users($data)
    {
        array_shift($data);// 将表头移除
        try {
            foreach ($data as $key => $value) {
                $user['name'] = (int)$value[0]; //工号
                $user['nickname'] = $value[1];// 姓名
                $user['gender'] = $value[2] == '男' ? 0 : 1;// 性别
                $user['password'] = bcrypt(trim('hnnu' . $value[0]));// 密码
                $user['email'] = app(\Faker\Generator::class)->freeEmail;// email
                $user['picture'] = 'images/picture.jpg';//app(\Faker\Generator::class)->imageUrl(640, 480);// 头像
                $user['college_id'] = College::where('title', $value[9])->first()->id;// 学院id//app(CollegeRepository::class)->findByName($value[3])->id;// 学院id
                $userInfo = User::create($user);
                if (strpos($value[3], '书记') != false || strpos($value[5], '书记') != false) {
                    $role = Role::where(['name' => 'college'])->first()->id;
                } else {
                    $role = Role::where(['name' => 'teacher'])->first()->id ?: 1;
                }
                $userInfo->roles()->attach($role);
                unset($userInfo, $role, $userRoleInfo);
            }
        } catch (QueryException $e) {
            throw new \Exception('即将导入的教师已经存在于数据库中: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'success',
            'status_code' => 200
        ]);
    }
}
