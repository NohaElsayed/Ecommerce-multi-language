<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\ImageUploadTrait;

class User extends Authenticatable
{
    use HasRoles, ImageUploadTrait;

    protected $fillable = ['name', 'email', 'phone', 'password', 'avatar', 'status'];
    protected $hidden = ['password', 'remember_token'];

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
