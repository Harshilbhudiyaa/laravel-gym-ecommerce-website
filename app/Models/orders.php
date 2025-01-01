<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    use HasFactory;
    public $table = 'orders';
    protected $fillable = [
        'name','email', 'address', 'city', 'state', 'zip', 'total_amount', 'status'
    ];
  

}
