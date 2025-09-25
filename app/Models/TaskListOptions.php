<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskListOptions extends Model
{
    use SoftDeletes;

    const TYPE_OPTION   = 'option';
    const TYPE_TEXT     = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_POLL     = 'poll';
    
    protected $fillable = [
        'title',
        'type',
        'image',
        'is_right',
    ];

    protected $casts = [
        'is_right' => 'boolean',
    ];
}
