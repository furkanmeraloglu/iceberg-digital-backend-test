<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Appointment extends Model
{
    use HasFactory;

    protected $iceberg_post_code = 'cm27pj';
    protected $casts = [
        'departure_time' => 'date:hh:mm',
        'arrival_time' => 'date:hh:mm',
        'date' => 'date',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function contacts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Contact::class);
    }
    public function getHomePostCodeAttribute(): string
    {
        return $this->iceberg_post_code;
    }
}
