<?php

namespace App\Listeners;

use App\Events\TaskSaved;
use App\Models\College;
use App\Models\TaskProgress;
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
        if ($event instanceof TaskSaved) {
            $collegeIds = College::all(['id']);
            if ($collegeIds->isNotEmpty() && $event->task != null) {
                $data = array();
                foreach ($collegeIds as $collegeId) {
                    $data[] = [
                        'task_id' => $event->task->id,
                        'college_id' => $collegeId->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
                TaskProgress::insert($data);
            }
        }
    }
}
