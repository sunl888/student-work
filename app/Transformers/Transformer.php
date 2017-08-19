<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 16:14
 */

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class Transformer extends TransformerAbstract
{
    public function getLeadOfficial($taskProgress){
        $user = app(User::class)->find($taskProgress->user_id);
        if($user){
            return $user->hasRole('teacher')?$user->name:'全体人员';
        }
        return null;
    }
}