<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    public $fillable = ['title', 'calories', 'proteins', 'fats', 'carbohydrates', 'photo', 'user_id', 'is_approved'];
    public $hidden = ['dish_id', 'user_id'];

    public function meals() {
        return $this->hasMany(Meal::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }


    public function scopeL($query) {
        return $query;
    }
    public function scopeApproved($query) {
        return $query->where('is_approved', true);
    }
}
