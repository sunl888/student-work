<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 16:14
 */

namespace App\Transformers;

use App\Models\TaskProgress;
use App\Repositories\AssessRepository;
use App\Repositories\CollegeRepository;

class TaskProgressTransformer extends Transformer
{
    public function transform(TaskProgress $taskProgress)
    {
        return [
            'id' => $taskProgress->id,
            'college_id' => $taskProgress->college_id,//学院id
            'college' => ($college = app(CollegeRepository::class)->find($taskProgress->college_id))?$college['title']:null,
            'leading_official' => $this->getLeadOfficial($taskProgress),//责任人
            'assess_id' => $taskProgress->assess_id,//考核等级
            'assess' => is_null($taskProgress->assess_id)?null:app(AssessRepository::class)->find($taskProgress->assess_id)['title'],
            'created_at' => $taskProgress->created_at->toDateTimeString(),
            'status' => !empty($taskProgress->status) ? '已完成' : '未完成',//完成状态
            'end_time' => $taskProgress->status,//完成时间
            'quality' => $taskProgress->quality,//完成质量
            'remark' => $taskProgress->remark,//备注
            'delay' => $taskProgress->delay,//推迟理由
            'remind' => $taskProgress->remind,//推迟记录
        ];
    }

}