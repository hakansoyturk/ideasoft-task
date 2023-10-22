<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = "items";
    protected $guarded = [];
    protected $primaryKey = 'id';

    public function order(){
        return $this->belongsTo(Order::class,'fk_order_id','id');
    }
}
