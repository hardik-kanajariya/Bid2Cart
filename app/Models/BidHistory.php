<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidHistory extends Model
{
    use HasFactory;
    protected $table = 'bid_history';
    protected $primaryKey = 'id';

    public function userData()
    {
        return $this->hasMany(User::class, 'userid', 'user_id');
    }

    public function productData(){
        return $this->hasMany(Product::class, 'prd_id', 'product_id');
    }
}
