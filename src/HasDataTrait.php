<?php

namespace Viviniko\Content;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Config;

trait HasDataTrait
{
    private $data;

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * Boot the HasDataTrait trait for a model.
     *
     * @return void
     */
    public static function bootHasDataTrait()
    {
        static::saved(function ($model) {
            if (!empty($this->getData())) {
                $model->data()->save([
                    'data' => $this->getData()
                ]);
            }
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
}