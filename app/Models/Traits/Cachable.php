<?php

namespace App\Models\Traits;

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

    abstract protected function clearCache();

    public function delete(array $options = [])
    {
        if (!parent::delete($options)) {
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
}
