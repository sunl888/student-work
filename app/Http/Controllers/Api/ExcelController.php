<?php

namespace App\Http\Controllers\Api;

use App\Events\ImportUsers;
use App\Http\Controllers\Controller;

class ExcelController extends Controller
{
    public function upload_users(\Illuminate\Http\Request $request)
    {
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file;
            $extension = $file->getClientOriginalExtension(); //上传文件的后缀.
            $tabl_name = date('YmdHis') . mt_rand(100, 999);
            $newName = $tabl_name . '.' . $extension;
            $file->move(storage_path() . '/uploads', $newName);
            $cretae_path = storage_path() . '/uploads/' . $newName;

            event(new ImportUsers($cretae_path));

            return response()->json([
                'message' => 'success',
                'status_code' => 200
            ]);
        }
    }
}
