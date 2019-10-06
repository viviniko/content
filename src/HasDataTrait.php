<?php

namespace Viviniko\Content;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Config;

trait HasDataTrait
{
    private $data;

    public function withData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        if ($this->withData($data)->exists()) {
            static::persistModelData($this);
        }
    }

    public function mergeData($data)
    {
        $data = array_merge((array)$this->data, data_get($this->data()->first(['data']), 'data', []), $data);
        $this->setData($data);
    }

    /**
     * Boot the HasDataTrait trait for a model.
     *
     * @return void
     */
    public static function bootHasDataTrait()
    {
        static::created(function ($model) {
            static::persistModelData($model);
        });

        static::deleted(function ($model) {
            try {
                $model->data()->delete();
            } catch (QueryException $e) {
                // ignored
            }
        });
    }

    public function data()
    {
        return $this->hasOne(Config::get('content.data'), 'id');
    }

    protected static function persistModelData($model)
    {
        $model->data()->updateOrCreate(['id' => $model->getKey()], [
            'data' => $model->getData()
        ]);
    }
}