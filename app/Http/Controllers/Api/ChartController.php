<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Repositories\CollegeRepository;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    //图表
    /*public function export2chart(Request $request)
    {
        $datas = $this->lists($request)->getData();
        $labels = [];
        $unfinisheds = [];
        $finisheds = [];
        unset($datas->meta);
        foreach ($datas as $data) {
            $data = get_object_vars($data);
            $labels[] = $data['college_name'];
            $unfinisheds[] = $data['unfinisheds'];
            $finisheds[] = $data['finisheds'];
        }
        $chart = Charts::multi('bar', 'material')
            // Setup the chart settings
            ->title("图表")
            // A dimension of 0 means it will take 100% of the space
            ->dimensions(0, 400)// Width x Height
            // This defines a preset of colors already done:)
            ->template("material")
            // You could always set them manually
            // ->colors(['#2196F3', '#F44336', '#FFC107'])
            // Setup the diferent datasets (this is a multi chart)
            ->dataset('已完成', $finisheds)
            ->dataset('未完成', $unfinisheds)
            // Setup what the values mean
            ->labels($labels);
    }*/

    public function lists(Request $request)
    {
        $data = [];
        $tasks = Task::applyFilter($request)->publish()->get()->load('task_progresses');
        $data['meta']['count'] = count($tasks);
        foreach ($tasks as $task) {
            foreach ($task->task_progresses as $task_progress) {
                if (!isset($data[$task_progress->college_id])) {
                    $data[$task_progress->college_id]['college_id'] = $task_progress->college_id;
                    $data[$task_progress->college_id]['college_name'] = app(CollegeRepository::class)->find($task_progress->college_id)->title;
                    $data[$task_progress->college_id]['unfinisheds'] = is_null($task_progress->status) ? 1 : 0;
                    $data[$task_progress->college_id]['finisheds'] = !is_null($task_progress->status) ? 1 : 0;
                    // 评分
                    $data[$task_progress->college_id]['score'] = !is_null($task_progress->status) ? $task_progress->assess->score : 0;
                    //$data[$task_progress->college_id]['score'] += !is_null($task_progress->delay) ? $task_progress->delay->score: 0;
                } else {
                    $data[$task_progress->college_id]['unfinisheds'] += is_null($task_progress->status) ? 1 : 0;
                    $data[$task_progress->college_id]['finisheds'] += !is_null($task_progress->status) ? 1 : 0;
                    $data[$task_progress->college_id]['score'] += !is_null($task_progress->status) ? $task_progress->assess->score : 0;
                    //$data[$task_progress->college_id]['score'] += !is_null($task_progress->delay) ? $task_progress->delay->score: 0;
                }
            }
        }
        return response()->json($data);
    }
}
