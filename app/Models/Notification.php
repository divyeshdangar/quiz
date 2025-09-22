<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message_tag',
        'extra_id',
        'user_id',
        'user_id2'
    ];

    protected $searchable = [
        'message_tag'
    ];

    public function scopeSearching($q)
    {
        if (request('search')) {
            foreach ($this->searchable as $key => $value) {
                $q->orwhere($value, 'LIKE', '%'.request('search').'%');
            }
        }
        return $q;
    }

    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'user_id2');
    }

    public function extra($type)
    {
        switch ($type) {
            case 'msg.new_webpage_created':
                return Webpage::where('id', $this->extra_id)->first();
                break;
            
            default:
                # code...
                break;
        }
    }
}
