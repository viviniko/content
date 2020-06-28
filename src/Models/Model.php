<?php
namespace Viviniko\Content\Models;

use Illuminate\Support\Facades\Config;
use Viviniko\Support\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    protected $tableConfigKey = 'content.models_table';

    protected $fillable = ['name', 'description', 'is_system'];

    protected $casts = [
        'is_system' => 'boolean',
    ];

    public function fields()
    {
        return $this->hasMany(Config::get('content.field'), 'model_id');
    }
}