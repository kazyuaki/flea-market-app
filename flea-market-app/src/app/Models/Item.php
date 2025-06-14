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
    //これは「この商品をいいねしているユーザー一覧」を取るためのリレーション。
    public function favorites() {
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id')->withTimestamps();
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function isFavoritedBy(User $user)
    {
        if(!$user) return false;
        return $this->favoritedBy->contains($user);
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
