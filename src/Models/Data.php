<?php

namespace Viviniko\Content\Models;

use Illuminate\Support\Facades\Config;
use Viviniko\Support\Database\Eloquent\Model;

class Data extends Model
{
    protected $tableConfigKey = 'content.data_table';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'id', 'data',
    ];

    public function item()
    {
        return $this->belongsTo(Config::get('content.item'), 'id');
    }
}
