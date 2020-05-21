<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = ['user_id', 'dish_id', 'weight', 'created_at'];
    public function dish() {
        return $this->belongsTo(Dish::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
