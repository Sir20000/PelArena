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
          'two_factor_secret',
    'two_factor_recovery_codes',
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
public function isEnabled(): bool
{
    // Change from $this->is_enabled to $this->enable
return is_null($this->enable) ? true : (bool) $this->enable;}

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
    // Si l'utilisateur n'a aucun rôle associé, on bloque l'accès directement
    if (!$this->role) {
        return false;
    }

    // Si le rôle possède la permission globale '*', on autorise
    if (in_array('*', $this->role->permissions)) {
        return true;
    }

    // Sinon, on vérifie si la route demandée est dans les permissions du rôle
    return in_array($route, $this->role->permissions);
}
}
