<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

use App\Models\WorkType;
use Cache;

class WorkTypeRepository extends Repository
{
    public function __construct()
    {
        $this->model = app(WorkType::class);
    }

    public function all($columns = array('*'))
    {
        return Cache::remember('work_types', config('app.cache_ttl'), function() {
            return $this->model->all();
        });
    }
}