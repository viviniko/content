<?php

namespace Viviniko\Content\Models;

use Illuminate\Support\Facades\Config;
use Viviniko\Content\HasDataTrait;
use Viviniko\Rewrite\RewriteTrait;
use Viviniko\Support\Database\Eloquent\Model;

class Item extends Model
{
    use RewriteTrait, HasDataTrait;

    protected $tableConfigKey = 'content.items_table';

    protected $fillable = [
        'category_id', 'title', 'description', 'position', 'image', 'slug', 'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Config::get('content.category'), 'category_id');
    }
}
