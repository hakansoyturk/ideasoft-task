<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountLine extends Model
{
    protected $table = "discount_lines";
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function discountCategory(){
        return $this->hasOne(DiscountCategory::class, 'id', 'fk_discount_category_id');
    }
}
