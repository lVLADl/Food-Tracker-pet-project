<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    public $fillable = ['title', 'calories', 'proteins', 'fats', 'carbohydrates', 'photo', 'user_id', 'is_approved'];
    public function scopeL($query) {
        return $query;
    }
    public function scopeApproved($query) {
        return $query->where('is_approved', true);
    }
}
