<?php

namespace App\Listeners;

use App\Events\AuditedTask;
use App\Repositories\CollegeRepository;
use App\Repositories\TaskProgressRepository;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateTaskProgressListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $event
     */
    public function handle($event)
    {
        // 每创建一个任务就为每个学院建立一个任务进程记录
        if ($event instanceof AuditedTask) {
            $collegeIds = app(CollegeRepository::class)->all(['id']);
            if ($collegeIds->isNotEmpty() && $event->task) {
                $data = array();
                foreach ($collegeIds as $collegeId) {
                    $data[] = [
                        'task_id' => $event->task->id,
                        'college_id' => $collegeId->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
                app(TaskProgressRepository::class)->createTaskProgress($data, $event->task->id);
                //TaskProgress::insert($data);
            }
        }
    }
}
