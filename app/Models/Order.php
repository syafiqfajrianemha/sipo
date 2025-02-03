<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function drugDistributions()
    {
        return $this->hasManyThrough(
            DrugDistribution::class,
            OrderItem::class,
            'order_id',
            'order_item_id',
            'id',
            'id'
        );
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
