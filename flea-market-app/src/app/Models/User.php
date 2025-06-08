<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'post_code',
        'address',
        'building_name',
        'is_profile_set',
        'email_verified_at', // 忘れずに！
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_profile_set' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function purchasedItems() 
    {
        return $this->belongsToMany(Item::class, 'orders', 'user_id' , 'item_id')
                    ->withTimestamps();
    }

    public function favorites()
    {
        return $this->belongsToMany(Item::class, 'favorites')->withTimestamps();
    }

}
