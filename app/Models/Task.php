<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use SoftDeletes;

    protected $searchable = [
        'code',
        'title',
        'description'
    ];

    const TYPE_MCQ    = 'mcq';
    const TYPE_FORM   = 'form';
    const TYPE_POLL   = 'poll';
    const TYPE_REVIEW = 'review';

    protected $fillable = [
        'user_id',
        'type',
        'code',
        'title',
        'description',
        'total_time',
        'task_category_id',
        'is_timebase',
        'is_individual',
        'image',
    ];

    public function scopeSearching($q)
    {
        if (request('search')) {
            foreach ($this->searchable as $key => $value) {
                $q->orwhere($value, 'LIKE', '%' . request('search') . '%');
            }
        }
        return $q;
    }

    protected $casts = [
        'total_time' => 'integer',
        'is_timebase' => 'boolean',
        'is_individual' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TaskCategory::class, 'task_category_id');
    }

    public function lists()
    {
        return $this->hasMany(TaskList::class);
    }
}
