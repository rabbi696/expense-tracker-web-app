<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function expenses(): BelongsToMany
    {
        return $this->belongsToMany(Expense::class, 'expense_category');
    }
}
