<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateSemestersRequest;
use App\Http\Requests\UpdateSemestersRequest;
use App\Models\Semester;
use App\Repositories\SemestersRepository;
use App\Transformers\SemestersTransformer;

class SemestersController extends BaseController
{
    public function lists()
    {
        $all = app(SemestersRepository::class)->all();
        $values = [];
        foreach ($all as $item) {
            // 没有父级id
            if (!$item->parent_id) {
                //没有创建学年
                if (!isset($values[$item->id])) {
                    $values[$item->id] = $item->toArray();
                } else {
                    // 创建了学年
                    $tmp = $values[$item->id]['childs'];
                    $values[$item->id] = $item->toArray();
                    $values[$item->id]['childs'] = $tmp;
                }
            } else {
                // 有父级id但是在values里不存在
                if (!isset($values[$item->parent_id])) {
                    if (($val = $all->find($item->parent_id)) != null) {
                        $values[$item->parent_id] = $val->toArray();
                        $values[$item->parent_id]['childs'][] = $item->toArray();
                    }
                } else {
                    $values[$item->parent_id]['childs'][] = $item->toArray();
                }
            }
            unset($item);
        }
        return $this->response->array(array_values($values));
    }

    public function store(CreateSemestersRequest $request)
    {
        app(SemestersRepository::class)->create($request->all());
        return $this->response->noContent();
    }

    public function update(UpdateSemestersRequest $request, $semester)
    {
        app(SemestersRepository::class)->update($request->all(), ['id' => $semester]);
        return $this->response->noContent();
    }

    public function delete($semester)
    {
        app(SemestersRepository::class)->delete($semester);
        return $this->response->noContent();
    }

    public function currentSemester()
    {
        $semester = Semester::where('checked', 1)->first();
        return $this->response->item($semester, new SemestersTransformer());
    }

    public function setCurrentSemester($semester)
    {
        $data['checked'] = 1;
        app(SemestersRepository::class)->update($data, ['id' => $semester]);
        return $this->response->noContent();
    }


}
