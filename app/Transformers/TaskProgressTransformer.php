<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 16:14
 */

namespace App\Transformers;

use App\Models\TaskProgress;
use App\Models\User;
use App\Repositories\AssessRepository;
use App\Repositories\CollegeRepository;
use League\Fractal\TransformerAbstract;

class TaskProgressTransformer extends TransformerAbstract
{
    public function transform(TaskProgress $taskProgress)
    {
        return [
            'id' => $taskProgress->id,
            'college_id' => $taskProgress->college_id,//学院id
            'college' => app(CollegeRepository::class)->find($taskProgress->college_id)['title'],
            'leading_official' =>$this->getLeadOfficial($taskProgress),//责任人
            'assess_id' => $taskProgress->assess_id,//考核等级
            'assess' =>app(AssessRepository::class)->find($taskProgress->assess_id)['title'],
            'created_at' => $taskProgress->created_at->toDateTimeString(),
            'status' => !empty($taskProgress->status)?'已完成':'未完成',//完成状态
            'end_time' => $taskProgress->status,//完成时间
            'quality' =>$taskProgress->quality,//完成质量
            'remark' =>$taskProgress->remark,//备注
            'delay' =>$taskProgress->remind,//推迟理由
            'remind' =>$taskProgress->remind,//推迟记录
        ];
    }

    public function getLeadOfficial($taskProgress){
        $user = app(User::class)->find($taskProgress->user_id);
        if($user){
            return $user->hasRole('teacher')?$user->name:'全体人员';
        }
        return null;
    }
}