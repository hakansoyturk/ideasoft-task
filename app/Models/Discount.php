<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = "discounts";
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function discountLines(){
        return $this->hasMany(DiscountLine::class, "fk_discount_id", "id");
    }
}
