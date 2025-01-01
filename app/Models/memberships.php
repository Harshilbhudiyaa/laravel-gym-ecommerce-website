<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class memberships extends Model
{
    use HasFactory;
    protected $table = 'memberships';
    protected $fillable = [
        'user_id',
        'membership_plan_id',
        'start_date',
        'end_date',
    ];

    

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(Register::class, 'user_id');
    }

    public function membershipPlan()
    {
        return $this->belongsTo(MembershipPlan::class);
    }
}
