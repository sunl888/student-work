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
use League\Fractal\TransformerAbstract;

class Transformer extends TransformerAbstract
{
    public function getLeadOfficial($taskProgress)
    {
        if ($taskProgress->user_id) {
            if ($taskProgress->user_id == TaskProgress::$personnelSign) {
                return '全体人员';
            } else {
                return app(User::class)->find($taskProgress->user_id)['name'];
            }
        }
        return null;
    }
}