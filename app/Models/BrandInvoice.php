<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandInvoice extends Model
{
    use HasFactory;
    protected $table = 'brand_invoice';
    protected $primaryKey = 'id';
}
