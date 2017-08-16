<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        //任务创建成功
        'App\Events\TaskSaved' => [
            //发送email
            'App\Listeners\SendEmailsListener',
        ],
        //任务审核通过
        'App\Events\AuditedTask' => [
            //为每个学院创建任务进程
            'App\Listeners\CreateTaskProgressListener',
            //发送通知
            'App\Listeners\SendNotificationListener'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
