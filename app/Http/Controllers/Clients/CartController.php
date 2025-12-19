<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// use function Pest\Laravel\session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->merge(['quantity' => (int) $request->quantity]);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->quantity > $product->stock) {
            return response()->json(['message' => 'Số lượng vượt quá tồn kho'], 400);
        }

        //  nếu đăng nhập rồi thì lưu vào database
        if (Auth::check()) {
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $request->product_id)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $request->quantity;
                $cartItem->save();
            } else {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                ]);
            }


            $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');

        } else {
            //  nếu chưa đăng nhập thì lưu sp ở session
            $cart = session()->get('cart', []);

            if (isset($cart[$request->product_id])) {
                $cart[$request->product_id]['quantity'] += $request->quantity;
            } else {
                $cart[$request->product_id] = [
                    'product_id' => $request->product_id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $request->quantity,
                    'stock' => $product->stock,
                    'image' => $product->images->first()->image ?? 'uploads/products/default-product.png',
                ];
            }

            session()->put('cart', $cart);


            $cartCount = array_sum(array_column($cart, 'quantity'));
        }

        return response()->json([
            'message' => true,
            'cart_count' => $cartCount,
        ]);
    }

    public function loadMiniCart()
    {
        $cartItems = [];

        if (auth()->check()) {
            $cartItems = CartItem::with('product')->where('user_id', auth()->id())->get();
        } else {
            $cartItems = session('cart', []);
        }

        return response()->json([
            'status' => true,
            'html' => view('user.components.includes.mini_cart', compact('cartItems'))->render(),
        ]);
    }

    public function removeFormMiniCart(Request $request)
    {
        $request->validate(['product_id' => 'required']);

        if (Auth::check()) {

            CartItem::where('user_id', Auth::id())->where('product_id', $request->product_id)->delete();

            $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');

        } else {

            // If not logged in, save to session
            $cart = session()->get('cart', []);
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);

            // tính tổng mảng
            $cartCount = array_sum(array_column($cart, 'quantity'));
        }

        return response()->json([
            'status' => true,
            'cart_count' => $cartCount,
        ]);
    }

    // view-cart
    public function viewCart()
    {
        if (Auth::check()) {
            // Neu nguoi dung dang nhap thi minh se lay gio hang tu database
            $cartItems = CartItem::where('user_id', Auth::id())->with('product')->get()->map(function ($item) {
                return [
                    'product_id' => $item->product->id,
                    'name' => $item->product->name,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'stock' => $item->product->stock,
                    'image' => $item->product->images->first()->image ?? 'uploads/products/default-product.png',
                ];
            })->toArray();

        } else {
            // Nguoc lai thi lay gio hang tu session
            $cartItems = session()->get('cart', []);

        }

        return view('user.pages.cart', compact('cartItems'));
    }





    //Xu ly cap nhat so luong san pham trong trang gio hang
    public function updateCart(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity;

        // 1. Cập nhật dữ liệu vào DB/Session (Code cũ của bạn, giữ nguyên logic)
        if (Auth::check()) {
            $cartItem = CartItem::where('user_id', Auth::id())->where('product_id', $productId)->first();
            if(!$cartItem) return response()->json(['error' => 'Sản phẩm không tồn tại'], 404);

            $product = Product::find($productId);
            if($quantity > $product->stock) return response()->json(['error' => 'Quá số lượng tồn kho'], 400);

            $cartItem->quantity = $quantity;
            $cartItem->save();
        } else {
            $cart = session()->get('cart', []);
            if(!isset($cart[$productId])) return response()->json(['error' => 'Sản phẩm không tồn tại'], 404);

            $product = Product::find($productId);
            if($quantity > $product->stock) return response()->json(['error' => 'Quá số lượng tồn kho'], 400);

            $cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        // 2. TÍNH TOÁN LẠI MỌI THỨ (Server tính, JS không cần tính)
        $subtotal = $quantity * $product->price; // Thành tiền của món đó
        $total = $this->calculateCartTotal();    // Tổng tiền hàng
        $grandTotal = $total + 15000;            // Tổng cộng (kèm ship)

        // Tính lại tổng số lượng icon giỏ hàng
        if (Auth::check()) {
            $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cart = session()->get('cart', []);
            $cartCount = array_sum(array_column($cart, 'quantity'));
        }

        return response()->json([
            'status' => true,
            'quantity' => $quantity,
            // Trả về chuỗi đã format sẵn
            'subtotal' => number_format($subtotal, 0, ',', '.'),
            'total' => number_format($total, 0, ',', '.'),
            'grandTotal' => number_format($grandTotal, 0, ',', '.'),
            'cart_count' => $cartCount, // Trả về số lượng để update icon
        ]);
    }


    //Xu ly XOA san pham trong trang gio hang
    // Xử lý XÓA sản phẩm ở Giỏ Lớn
    public function removeCartItem(Request $request)
    {
        $productId = $request->product_id;

        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->where('product_id', $productId)->delete();
        } else {
            $cart = session()->get('cart', []);
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        // Tính toán lại
        $total = $this->calculateCartTotal();
        $grandTotal = $total + 15000;

        // Tính lại số lượng icon
        if (Auth::check()) {
            $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cart = session()->get('cart', []);
            $cartCount = array_sum(array_column($cart, 'quantity'));
        }

        return response()->json([
            'status' => true,
            'total' => number_format($total, 0, ',', '.'),
            'grandTotal' => number_format($grandTotal, 0, ',', '.'),
            'cart_count' => $cartCount, // Trả về để JS update icon
        ]);
    }





    function calculateCartTotal()
    {
        if (Auth::check()) {
            return CartItem::where('user_id', Auth::id())->with('product')->get()->sum(fn($item) => $item->quantity * $item->product->price);

        } else {
            $cart = session()->get('cart', []);
            return collect($cart)->sum(fn($item) => $item['quantity'] * $item['price'] );

        }
    }









}
