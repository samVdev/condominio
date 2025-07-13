<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Board extends Model
{
    use HasFactory;

    protected $table = 'boards';

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'meeting_date',
        'started_at',
        'ended_at',
        'is_active',
        'description_end',
        'end',
        'link'
    ];

    protected $casts = [
        'meeting_date' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'is_active' => 'boolean',
        'end' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function asistentes()
    {
        return $this->belongsToMany(User::class, 'board_participants');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('meeting_date', '>', now());
    }

    public function scopePast($query)
    {
        return $query->where('meeting_date', '<', now());
    }

    public function surveys()
    {
        return $this->hasMany(\App\Models\Survey::class);
    }

    public function getTime()
    {
        if ($this->started_at && $this->ended_at) {
            $seconds = $this->ended_at->diffInSeconds($this->started_at);
    
            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds % 3600) / 60);
            $remainingSeconds = $seconds % 60;
    
            $parts = [];
            if ($hours > 0) {
                $parts[] = $hours . ' h';
            }
            if ($minutes > 0) {
                $parts[] = $minutes . ' min';
            }
            if ($remainingSeconds > 0) {
                $parts[] = $remainingSeconds . ' sec';
            }
    
            return implode(' ', $parts) ?: '0 sec';
        }
        return null;
    }
    
}
