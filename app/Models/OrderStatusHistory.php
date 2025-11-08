<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    protected $fillable = ['order_id', 'status', 'changed_at', 'note'];


    // Mỗi bản ghi trạng thái thuộc về 1 đơn hàng cụ thể
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
