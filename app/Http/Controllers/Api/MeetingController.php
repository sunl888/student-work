<?php

namespace App\Http\Controllers\Api;

use App\Events\CreatedMeeting;
use App\Http\Requests\CreateMeetingRequest;
use App\Models\Absentee;
use App\Models\College;
use App\Models\Meeting;
use App\Models\User;
use App\Repositories\CollegeRepository;
use App\Repositories\SemestersRepository;
use App\Transformers\MeetingTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use League\Fractal\Resource\NullResource;

class MeetingController extends BaseController
{
    public function store(CreateMeetingRequest $request)
    {
        $data = $request->all();
        $data['start_time'] = \Carbon\Carbon::createFromTimestamp(strtotime($data['start_time']));
        $meeting = Meeting::create($data);
        // 判断哪些人缺勤，分别为他们创建缺勤记录
        if (isset($data['absent_cause'])) {
            array_walk($data['absent_cause'], function (&$value, $key, $joinUsing) {
                $value[$joinUsing['key']] = $joinUsing['val'];
            }, array('key' => 'meeting_id', 'val' => $meeting->id));
            // 将每个用户的缺勤记录存入数据库
            array_walk($data['absent_cause'], function (&$val) {
                Absentee::create($val);
            });
        }
        event(new CreatedMeeting($meeting->users, $meeting));
        return $this->response()->noContent();
    }

    public function lists(Request $request)
    {
        return $this->response()->paginator(Meeting::applyFilter($request)->paginate($this->perPage()), new MeetingTransformer())
            ->setMeta([Meeting::getAllowSearchFieldsMeta() + Meeting::getAllowSortFieldsMeta()]);
    }

    public function show(Meeting $meeting)
    {
        return $this->response()->item($meeting, new MeetingTransformer());
    }

    /**
     * 'start_time','college_id'
     * @param Request $request
     * @return mixed
     */
    /*public function attendance(Request $request)
    {
        $data = [];
        $queqin = Absentee::all();
        $current_Semester = app(SemestersRepository::class)->where(['checked' => 1])->first();
        $da = $request->only('start_time', 'end_time', 'college_id', 'export');
        foreach ($queqin as $item) {
            $college = User::findOrFail($item->user_id)->college;
            // 用户没有院系跳过
            if (is_null($college)) {
                continue;
            }
            // filter
            if (isset($da['college_id'])) {
                if ($college->id != $da['college_id']) {
                    continue;
                }
            }
            // start_time lt 小于
            if (isset($da['start_time'])) {
                if (!Carbon::parse($item->meeting->start_time)->between(Carbon::parse($da['start_time']), isset($da['end_time']) ? Carbon::parse($da['end_time']) : Carbon::now())) {
                    continue;
                }
            } else {
                if (!Carbon::parse($item->meeting->start_time)->between(Carbon::parse($current_Semester->start_time), Carbon::parse($current_Semester->end_time))) {
                    continue;
                }
            }

            if (!isset($data[$college->id]['meetings'][$item->meeting->id])) {
                $data[$college->id]['meetings'][$item->meeting->id] = $item->meeting;
            }

            if (!isset($data[$college->id]['score'])) {
                $data[$college->id]['score'] = Meeting::BASE_SCORE;
            }

            if (!isset($data[$college->id]['college'])) {
                $data[$college->id]['college'] = $college;
            }
            // todo 负数
            if ($data[$college->id]['score'] > 0)
                $data[$college->id]['score'] += $item->assess->score;
            else
                $data[$college->id]['score'] = 0;
        }
        // 导出数据
        if (isset($da['export'])) {
            $this->export2table($request, $data);
        }
        return $this->response()->array($data);
    }*/

    public function attendance(Request $request)
    {
        $da = $request->only('start_time', 'end_time', 'college_id', 'export');
        $meetings = Meeting::all();
        $current_Semester = app(SemestersRepository::class)->where(['checked' => 1])->first();
        $college = app(CollegeRepository::class)->all()->toArray();
        foreach ($college as $item) {
            $data[$item['id']] = $item;
            $data[$item['id']]['college_total_score'] = 0;
        }
        foreach ($meetings as $meeting) {
            if (isset($da['start_time'])) {
                if (!Carbon::parse($meeting->start_time)->between(Carbon::parse($da['start_time']), isset($da['end_time']) ? Carbon::parse($da['end_time']) : Carbon::now())) {
                    continue;
                }
            } else {
                if (!Carbon::parse($meeting->start_time)->between(Carbon::parse($current_Semester->start_time), Carbon::parse($current_Semester->end_time))) {
                    continue;
                }
            }
            // 这个会议的缺勤名单
            $absentees = $meeting->absentees;
            unset($meeting->absentees);
            // is 全体人员
            if ($meeting->users == Meeting::ALL_USER) {
                foreach ($data as $index => $v) {
                    $data[$index]['meetings'][$meeting->id] = $meeting->toArray();
                    $data[$index]['meetings'][$meeting->id]['meeting_total_score'] = Meeting::BASE_SCORE;
                }
            } else {
                $users = explode(',', $meeting->users);
                foreach ($users as $user) {
                    $collegeOfUser = User::findOrFail($user)->college;
                    // 用户没有院系跳过
                    if (is_null($collegeOfUser)) {
                        continue;
                    }
                    // 学院不存在
                    if (!isset($data[$collegeOfUser->id])) {
                        continue;
                    }
                    // 该学院没有此会议则添加进去
                    if (!isset($data[$collegeOfUser->id]['meetings'][$meeting->id])) {
                        $data[$collegeOfUser->id]['meetings'][$meeting->id] = $meeting->toArray();
                    }
                    // 每个会议的默认分数
                    if (!isset($data[$collegeOfUser->id]['meetings'][$meeting->id]['meeting_total_score'])) {
                        $data[$collegeOfUser->id]['meetings'][$meeting->id]['meeting_total_score'] = Meeting::BASE_SCORE;
                    }
                }
            }
            // 缺勤
            foreach ($absentees as $absentee) {
                $collegeOfUser = User::findOrFail($absentee->user_id)->college;
                // 用户没有院系跳过
                if (is_null($collegeOfUser)) {
                    continue;
                }
                // 学院不存在
                if (!isset($data[$collegeOfUser->id])) {
                    continue;
                }
                // 分数相关
                // todo $absentee->assess->score 必须是负数
                $data[$collegeOfUser->id]['meetings'][$meeting->id]['meeting_total_score'] += $absentee->assess->score;
                if ($data[$collegeOfUser->id]['meetings'][$meeting->id]['meeting_total_score'] < 0) {
                    $data[$collegeOfUser->id]['meetings'][$meeting->id]['meeting_total_score'] = 0;
                }
            }//缺勤结束
        }
        foreach ($data as $index => $v) {
            if (!isset($v['meetings'])) {
                $data[$index]['meetings'] = null;
            } else {
                foreach ($v['meetings'] as $meeting) {
                    $data[$index]['college_total_score'] += $meeting['meeting_total_score'];
                }
            }
        }
        // 按request学院筛选
        if (isset($da['college_id'])) {
            $data = $data[$da['college_id']];
        }
        // 导出数据
        if (isset($da['export'])) {
            $this->export2table($request, $data);
        }
        return $this->response()->array($data);
    }

    public function export2table(Request $request, array $datas)
    {
        $rows = ['学院ID', '学院名称', '会议总得分', '截止时间'];
        foreach ($datas as $item) {
            $data[] = [
                $item->college->id,
                $item->college->title,
                $item->score,
                $item->start_time = $request->has('start_time') ? $request->get('start_time') : Carbon::now(),
            ];

        }
        $tableName = $request->has('start_time') ? $request->get('start_time') . ' - 会议考核汇总表' : '会议考核汇总表';
        $this->export($rows, $data, $tableName);
    }

    /**
     * @param array $rows 行标题
     * @param array $data 数据
     * @param string $tableName 导出的表格文件名
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
}
