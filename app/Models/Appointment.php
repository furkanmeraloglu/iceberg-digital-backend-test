<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Appointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'contact_id',
        'postcode',
        'home_postcode',
        'distance',
        'planned_at',
        'duration',
        'should_depart_at',
        'should_arrive_at'
    ];
    protected $guarded = [
        'id'
    ];
    protected $casts = [
        'planned_at' => 'date:Y-m-d H:i:s',
        'should_arrive_at' => 'date:H:i',
        'should_depart_at' => 'date:H:i'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function contact(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
