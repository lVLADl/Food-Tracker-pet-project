<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{

    public function scopeL($query) {
        return $query;
    }
    public function scopeApproved($query, bool $isApproved = true) {
        return $query->where('is_approved', (int) $isApproved);
    }
}
