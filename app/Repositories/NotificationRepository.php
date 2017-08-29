<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

use App\Models\Notification;
use App\Models\User;

class NotificationRepository extends Repository
{

    public function __construct()
    {
        $this->model = app(Notification::class);
    }

    public function notifications(User $user, $limit, $isReaded = false)
    {
        $builder = $this->model->where('notifiable_id', $user->id);
        if ($isReaded) {
            $builder = $builder->whereNull('read_at');
        }
        return $builder->paginate($limit);
    }

}