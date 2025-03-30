<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'pterodactyl_user_id',
        'credit',
        'role_id',
        'referred_by',
        'affiliate_code',
        'enable',
'two_factor_enabled'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function isAdmin()
{
    return $this->role === 'admin';
}
public function enable()
{
    return $this->enable === 1;
}
public function PterodactylId()
{
    return $this->pterodactyl_user_id;
}
public function couponUsages()
{
    return $this->hasMany(CouponUsage::class);
}
public static function boot()
{
    parent::boot();

    static::creating(function ($user) {
        $user->affiliate_code = uniqid();
    });
}
public function role()
{
    return $this->belongsTo(Role::class);
}

public function hasAccess($route)
{

    if (in_array('*', $this->role->permissions)) {
        return true;
    }
    return in_array($route, $this->role->permissions);
}    
}
