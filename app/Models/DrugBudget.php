<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugBudget extends Model
{
    protected $guarded = ['id'];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }
}
