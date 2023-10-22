<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function items(){
        return $this->hasMany(Item::class, "fk_order_id", "id");

    }
}
