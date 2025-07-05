<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaxBid extends Model
{
    use HasFactory;
    protected $table = 'max_bid';
    protected $primaryKey = 'id';
}
