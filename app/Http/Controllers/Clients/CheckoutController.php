<?php

namespace App\Http\Controllers\Clients;
use App\Http\Controllers\Controller;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    function index()
    {
        $user = Auth::user();
        $addresses = ShippingAddress::where('user_id', $user->id)->get();
        $defaultAddress = $addresses->where('default', 1)->first();

        if(is_null($addresses) || is_null($defaultAddress) )
        {
            toastr()->error('Vui lòng thêm địa chỉ giao hàng !');
            return redirect()->route('account');
        }

        return view('user.pages.checkout', compact('addresses', 'defaultAddress'));
    }




}
