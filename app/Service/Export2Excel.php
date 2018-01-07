<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/9/28
 * Time: 19:20
 */

namespace App\Service;


use Maatwebsite\Excel\Excel;

trait Export2Excel
{
    /**
     * @param array $rows 行标题
     * @param array $data 数据
     * @param string $tableName 导出的表格文件名
     * @throws \Maatwebsite\Excel\Exceptions\LaravelExcelException
     */
    public function export(array $rows, array $data, $tableName = 'default')
    {
        $cellData[] = $rows;
        foreach ($data as $item) {
            $cellData[] = $item;
        }
        //iconv('UTF-8', 'GBK', $tableName)
        app(Excel::class)->create($tableName, function ($excel) use ($cellData, $tableName) {
            $excel->sheet($tableName, function ($sheet) use ($cellData) {
                $sheet->rows($cellData);
            });
        })->export('xlsx');
    }

    public function import($tableName = 'default')
    {
        $filePath = 'storage/exports/' . iconv('UTF-8', 'GBK', $tableName) . '.xlsx';
        app(Excel::class)->load($filePath, function ($reader) {
            $data = $reader->all();
            dd($data);
        });
    }

}