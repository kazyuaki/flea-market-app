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

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function getConditionLabelAttribute()
    {
        switch ($this->condition) {
            case 1:
                return '良好';
            case 2:
                return '目立った傷や汚れなし';
            case 3:
                return 'やや傷や汚れあり';
            case 4:
                return '状態が悪い';
            default:
                return '不明';
        }
    }
}
