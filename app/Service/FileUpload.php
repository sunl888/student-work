<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2017/8/22
 * Time: 18:54
 */

namespace App\Service;


use Dingo\Api\Http\Request;
use Dingo\Api\Exception\StoreResourceFailedException;
use Storage;

trait FileUpload
{
    public function uploadFile(Request $request) {
        if (!$request->hasFile('file')) {
            return response()->json(['message'=> '无法获取上传文件','status'=> 500], 500);
        }
        $file = $request->file('file');

        if ($file->isValid()) {
            // 获取文件相关信息
            $originalName = $file->getClientOriginalName(); // 文件原名
            $ext = $file->getClientOriginalExtension();   // 扩展名
            $realPath = $file->getRealPath();  //临时文件的绝对路径
            $type = $file->getClientMimeType();   // image/jpeg

            // 上传文件
            $filename = date('Ymd/His');
            // 使用我们新建的uploads本地存储空间（目录）
            $path = $file->store($filename, 'uploads');
            return response()->json([
                'status_code' => 200,
                'message' => 'success',
                'photo' => $path,
                'name' => $originalName,
            ]);
        } else {
            return response()->json([], 500, '文件未通过验证');
        }
    }
}