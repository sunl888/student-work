<?php

namespace App\Models\Traits;

trait Listable
{
    //protected static $allowSortFields = [];
    /**
     * @return array
     */
    public static function getAllowSortFields()
    {
        return static::$allowSortFields;
    }

    //protected static $allowSearchFields = [];

    /**
     * @return array
     */
    public static function getAllowSearchFields()
    {
        return static::$allowSearchFields;
    }

    public static function getAllowSortFieldsMeta()
    {
        return ['allow_sort_fields' => static::$allowSortFields];
    }

    public static function getAllowSearchFieldsMeta()
    {
        return ['allow_search_fields' => static::$allowSearchFields];
    }

    /**
     * 例子: ?orders[0][field]=id&orders[0][dir]=asc&orders[1][field]=user_name&orders[1][dir]=desc
     * 或者 orders=id-asc,user_name-desc 不推荐
     *
     * @param  $query
     * @param  null $order
     * @return mixed
     */
    public function scopeWithSort($query, $orders = null)
    {
        $orders = is_null($orders) ? request('orders', null) : $orders;
        if (!empty($orders)) {
            if (is_string($orders)) {
                $orders = explode(',', $orders);
                foreach ($orders as &$v) {
                    //这第三个参数没毛病
                    if (strpos($v, '-', 1)) {
                        $temp = explode('-', $v, 2);
                        $v = ['field' => $temp[0], 'dir' => $temp[1]];
                    } else {
                        $v = ['field' => $v, 'dir' => 'asc'];
                    }
                }
                unset($v);
            }

            foreach ($orders as $order) {
                if (in_array($order['field'], static::$allowSortFields)) {
                    $query->orderBy($order['field'], isset($order['dir']) ? $order['dir'] : 'asc');
                }
            }
        }
        return $query;
    }

    /**
     * 例子：?keywords=ty&
     * @param $query
     * @param null $keywords
     * @param null $searchScope 查询的字段范围
     * @return mixed
     */
    public function scopeWithSimpleSearch($query, $keywords = null, $searchScope = [])
    {
        $keywords = is_null($keywords) ? request('keywords', null) : $keywords;
        $searchScope = empty($searchScope) ? request('search_scope', []) : $searchScope;

        if (empty($searchScope) || $searchScope === 'all') {
            $searchScope = static::$allowSearchFields;
        } else {
            if (is_string($searchScope)) $searchScope = [$searchScope];
            $searchScope = array_intersect(static::$allowSearchFields, $searchScope);
        }

        if (!empty($keywords) && !empty($searchScope)) {
            $query->where(
                function ($query) use ($keywords, $searchScope) {
                    foreach ($searchScope as $field) {
                        $query->orWhere($field, 'like', '%' . $keywords . '%');
                    }
                }
            );
        }
        return $query;
    }

    public function scopeWithGroup($query, $groups = null)
    {
        $groups = is_null($groups) ? request('groups', null) : $groups;
        if (!empty($groups)) {
            if (is_string($groups)) {
                // ?groups=task_work_id,departments_id
                $groups = explode(',', $groups);
                foreach ($groups as $group) {
                    if (in_array($group, static::$allowGroupFields)) {
                        $query->groupBy($group);
                    }
                }
            }
        }
    }
}
