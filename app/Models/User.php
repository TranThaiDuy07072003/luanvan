<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'phone_number',
        'avatar',
        'address',
        'role_id',
        'activation_token',
        'google_id',


    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    // Đảm bảo có cột này trong DB
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];






    // 1. Mỗi user thuộc về một vai trò (Role)
    public function role()
    {
        return $this->belongsTo(Role::class);   // nhánh 2 chân
    }



    // 2. Mỗi user có thể viết nhiều đánh giá (Review)
    public function reviews()
    {
        return $this->hasMany(Review::class);   // nhánh chân gà
    }



    // 3. Mỗi user có nhiều địa chỉ giao hàng (ShippingAddress)
    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class);   // nhánh chân gà
    }



    // 4. Mỗi user có nhiều đơn hàng (Order)
    public function orders()
    {
        return $this->hasMany(Order::class);   // nhánh chân gà
    }



    // 5. Mỗi user có nhiều sản phẩm trong giỏ hàng (CartItem)
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);   // nhánh chân gà
    }




    // ---- Các hàm kiểm tra trạng thái tài khoản ----
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isBanned()
    {
        return $this->status === 'banned';
    }

    public function isDeleted()
    {
        return $this->status === 'deleted';
    }
}
