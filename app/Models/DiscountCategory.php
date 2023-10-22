<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCategory extends Model
{
    protected $table = "discount_categories";
    protected $guarded = [];
    protected $primaryKey = 'id';
}
