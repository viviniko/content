<?php
namespace Viviniko\Content\Models;

use Illuminate\Support\Facades\Config;
use Viviniko\Support\Database\Eloquent\Model;

class Field extends Model
{
    protected $tableConfigKey = 'content.fields_table';

    protected $fillable = ['model_id', 'name', 'display_name', 'description', 'is_required', 'is_display', 'input_type', 'input_data'];

    protected $casts = [
        'is_required' => 'boolean',
        'is_display' => 'boolean',
    ];

    public function model()
    {
        return $this->belongsTo(Config::get('content.model'), 'model_id');
    }
}