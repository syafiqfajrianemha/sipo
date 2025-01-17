<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $guarded = ['id'];

    public function drugs()
    {
        return $this->belongsToMany(Drug::class, 'drug_budgets')->withPivot('stock')->withTimestamps();
    }
}
