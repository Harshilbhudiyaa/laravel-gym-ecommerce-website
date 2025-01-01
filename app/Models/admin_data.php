<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admin_data extends Model
{
    public $table = 'admin_data';
    use HasFactory;

    protected $fillable = ['name', 'email', 'profile', 'password'];
}
