<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AskedQuestion extends Model
{
    use HasFactory;
    protected $table = 'asked_question';
    protected $primaryKey = 'id';
}
