<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
            'user_id',
            'category_id',
            'name',
            'price',
            'detail',
            'img',
            'condition',
    ];

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

}
