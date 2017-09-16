<?php

namespace App\Models\Traits;

/**
 * 清除缓存
 * Trait Cachable
 * @package App\Models\Traits
 */
trait Cachable
{
    public function save(array $options = [])
    {
        if (!parent::save($options)) {
            return false;
        }
        $this->clearCache();
        return true;
    }

    public function update(array $datas = [], array $conditions = [])
    {
        if (!parent::where($conditions)->update($datas)) {
            return false;
        }
        $this->clearCache();
        return true;
    }

    public function delete(array $options = [])
    {
        if (!parent::where($options)->delete()) {
            return false;
        }
        $this->clearCache();
        return true;
    }

    public function restore()
    {
        if (!parent::restore()) {
            return false;
        }
        $this->clearCache();
        return true;
    }

    abstract protected function clearCache();
}
