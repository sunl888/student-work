<?php

namespace App\Http\Controllers\Api;

use App\Events\CreatedMeeting;
use App\Http\Requests\CreateMeetingRequest;
use App\Models\Absentee;
use App\Models\Meeting;
use App\Models\User;
use App\Repositories\CollegeRepository;
use App\Repositories\SemestersRepository;
use App\Transformers\MeetingByCollegeTransformer;
use App\Transformers\MeetingTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Excel;

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
     * 会议考核
     *
     * 'start_time','college_id'
     * @param Request $request
     * @return mixed
     */
    public function attendance(Request $request)
    {
        $inputs = $request->all();
        $meetings = Meeting::all();
        $current_Semester = app(SemestersRepository::class)->where(['checked' => 1])->first();
        $college = app(CollegeRepository::class)->all()->toArray();
        $request->merge(['end_time' => $request->has('end_time') ? $request->get('end_time') : Carbon::parse($current_Semester->end_time)]);
        foreach ($college as $item) {
            $data[$item['id']] = $item;
            $data[$item['id']]['college_total_score'] = 0;
        }
        foreach ($meetings as $meeting) {
            if (isset($inputs['start_time'])) {
                if (!Carbon::parse($meeting->start_time)->between(Carbon::parse($inputs['start_time']), isset($inputs['end_time']) ? Carbon::parse($inputs['end_time']) : Carbon::now())) {
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
                if (isset($data[$collegeOfUser->id]['meetings'])) {
                    $data[$collegeOfUser->id]['meetings'][$meeting->id]['meeting_total_score'] += $absentee->assess->score;
                    if ($data[$collegeOfUser->id]['meetings'][$meeting->id]['meeting_total_score'] < 0) {
                        $data[$collegeOfUser->id]['meetings'][$meeting->id]['meeting_total_score'] = 0;
                    }
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
        if (isset($inputs['college_id'])) {
            $data = [$data[$inputs['college_id']]];
        }
        // 导出数据
        if (array_key_exists('export', $inputs)) {
            $this->export2table($request, $data);
        }
        return $this->response()->array($data);
    }

    public function export2table(Request $request, array $datas)
    {
        $rows = ['学院ID', '学院名称', '会议总得分', '截止时间'];
        foreach ($datas as $item => $val) {
            $data[] = [
                $val['id'],
                $val['title'],
                $val['college_total_score'],
                $request->has('end_time') ? $request->get('end_time') : '',
            ];
        }
        $tableName = Carbon::now()->toDateString() . ' - 会议考核汇总表';
        $this->export($rows, $data, $tableName);
    }

    /**
     * @param array $rows 行标题
     * @param array $data 数据
     * @param string $tableName 导出的表格文件名
     * @throws \Maatwebsite\Excel\Exceptions\LaravelExcelException
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

    public function getmeetingsByCollegeUser(Request $request)
    {
        if (\Auth::user()->isCollege()) {
            $inputs = $request->all();
            $meetings = Meeting::all();
            $current_Semester = app(SemestersRepository::class)->where(['checked' => 1])->first();
            $college = app(CollegeRepository::class)->all()->toArray();
            $request->merge(['end_time' => $request->has('end_time') ? $request->get('end_time') : Carbon::parse($current_Semester->end_time)]);
            foreach ($college as $item) {
                $data[$item['id']] = $item;
                $data[$item['id']]['college_total_score'] = 0;
            }
            foreach ($meetings as $meeting) {
                if (isset($inputs['start_time'])) {
                    if (!Carbon::parse($meeting->start_time)->between(Carbon::parse($inputs['start_time']), isset($inputs['end_time']) ? Carbon::parse($inputs['end_time']) : Carbon::now())) {
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
                    // 该学院必须有会议才会有分数
                    if (isset($data[$collegeOfUser->id]['meetings'])) {
                        $data[$collegeOfUser->id]['meetings'][$meeting->id]['meeting_total_score'] += $absentee->assess->score;
                        if ($data[$collegeOfUser->id]['meetings'][$meeting->id]['meeting_total_score'] < 0) {
                            $data[$collegeOfUser->id]['meetings'][$meeting->id]['meeting_total_score'] = 0;
                        }
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
            // 学院
            $data = [$data[\Auth::user()->college->id]];
            // 导出数据
            if (array_key_exists('export', $inputs)) {
                $this->export2table($request, $data);
            }
            $res = collect();
            if (array_key_exists('meetings', $data = array_first($data)) && !is_null($data['meetings'])) {
                foreach ($data['meetings'] as $item) {
                    $res->push(collect($item));
                }
            }
            $pages = $res->forPage(request('page') ?: 1, $this->perPage());
            $page = new LengthAwarePaginator($pages, count($res), $this->perPage());
            return $this->response()->array($page);
        }
    }
}
