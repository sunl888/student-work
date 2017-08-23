<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2017/8/22
 * Time: 18:54
 */

namespace App\Service;

use Dingo\Api\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait FileUpload
{
    public function uploadFile(Request $request)
    {
        $hasFile = $request->hasFile('file');
        if (!$hasFile || !($file = $request->file('file'))->isValid()) {
            throw new HttpException(500, '图片上传出错');
        }
        $path = date('Y/m/d');
        // 指定磁盘为uploads
        $url = $file->store($path,'uploads');
        return response()->json([
            'path' =>'uploads/'.$url,
            'asset_path' => asset('uploads/'.$url)
        ]);
    }
}