<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trainer extends Model
{
    use HasFactory;
    public $table = 'trainer';
    protected $fillable = [
        'name', 
        'image'
    ];
}
