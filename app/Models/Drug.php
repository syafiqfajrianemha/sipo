<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $guarded = ['id'];

    public function budgets()
    {
        return $this->belongsToMany(Budget::class, 'drug_budgets')->withPivot('stock')->withTimestamps();
    }
}
