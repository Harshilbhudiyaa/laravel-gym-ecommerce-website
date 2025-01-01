<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class register extends Model
{
    use HasFactory;
    use Notifiable;
    protected $table = 'register';

    // Specify which fields can be mass-assigned
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'dob', 'gender', 'address', 'status', 'profile',
    ];

    // Hide sensitive data
    protected $hidden = [
        'password',
    ];

    // Define the relationship with memberships
    public function memberships()
    {
        return $this->hasMany(Memberships::class, 'user_id');
    }

    // Cast date fields
    protected $casts = [
        'dob' => 'date',
    ];
}
