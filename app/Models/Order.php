<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'agent_id',
        'user_id',
        'status',
        'count',
        'price',
        'floor_price',
        'net_price',
        'total_price'
    ];
}
