<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['order_id', 'file_path'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
