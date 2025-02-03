<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugDistribution extends Model
{
    protected $guarded = ['id'];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
