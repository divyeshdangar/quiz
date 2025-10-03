<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskList extends Model
{
    use SoftDeletes;

    const TYPE_QUE = 'que';

    protected $fillable = [
        'title',
        'type',
        'total_time',
        'is_timebase',
        'image',
    ];

    protected $casts = [
        'total_time' => 'integer',
        'is_timebase' => 'boolean',
    ];

    public function options()
    {
        return $this->hasMany(TaskListOptions::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
