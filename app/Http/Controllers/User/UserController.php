<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    // direct user home page
    public function userHome() {
        $categories = Category::select('id','name')->get();

        $products = Product::select('products.id','products.name','products.price','products.description','products.category_id','products.image','categories.name as category_name')
                            ->leftJoin('categories','products.category_id','categories.id')
                            ->when(request('categoryId'), function($query) {
                                $query->where('products.category_id', request('categoryId'));
                            })
                            ->when(request('searchKey'), function($query) {
                                $query->where('products.name', 'like', '%'.request('searchKey').'%');
                            })
                            ->when(request('minPrice') != null && request('maxPrice') != null , function($query) {
                                $query->whereBetween('products.price', [request('minPrice'), request('maxPrice')]);
                            })
                            ->when(request('minPrice') != null && request('maxPrice') == null , function($query) {
                                $query->where('products.price', '>=', request('minPrice'));
                            })
                            ->when(request('minPrice') == null && request('maxPrice') != null , function($query) {
                                $query->where('products.price', '<=', request('maxPrice'));
                            })
                            ->when(request('sortingType'), function($query) {
                                $sortingRule = explode(',', request('sortingType'));
                                $query->orderBy('products.'. $sortingRule[0], $sortingRule[1]);
                            })
                            ->orderBy('name')
                            ->get();

        return view('user.product.list', compact('categories', 'products'));
    }

    // direct product details page
    public function productDetails($id) {
        $product = Product::select('products.id as product_id','products.name as product_name','products.stock','products.price','products.description','products.image','categories.id as category_id','categories.name as category_name')
                            ->leftJoin('categories','products.category_id','categories.id')
                            ->where('products.id',$id)
                            ->first();

        $comments = Comment::select('comments.id','comments.comment','comments.user_id','comments.created_at','users.name','users.nickname','users.profile')
                            ->leftJoin('users','comments.user_id','users.id')
                            ->where('comments.product_id', $id)
                            ->orderBy('comments.created_at', 'desc')
                            ->get();

        $stars = number_format(Rating::where('product_id',$id)->avg('count'));

        $userRating = Rating::where('product_id',$id)->where('user_id',Auth::user()->id)->value('count');

        return view('user.product.details', compact('product', 'comments', 'stars', 'userRating'));
    }

    // comment
    public function commentCreate(Request $request) {
        Comment::create([
            'product_id' => $request->productId,
            'user_id' => Auth::user()->id,
            'comment' => $request->comment
        ]);

        Alert::success('Success Title', 'Comment Created Successfully!');
        return back();
    }

    // delete comment
    public function commentDelete($id) {
        Comment::where('id',$id)->delete();
        return back();
    }

    // rating
    public function rating(Request $request) {
        Rating::updateOrCreate([
            'user_id' => Auth::user()->id,
            'product_id' => $request->productId
        ],
        [
            'product_id' => $request->productId,
            'user_id' => Auth::user()->id,
            'count' => $request->productRating
        ]);

        return back();
    }

    // direct cart page
    public function cartPage() {
        $carts = Cart::select('carts.id','carts.qty','carts.product_id','products.name','products.price','products.image')
                    ->leftJoin('products','carts.product_id','products.id')
                    ->where('carts.user_id',Auth::user()->id)
                    ->get();

        $subTotal = 0;
        foreach ($carts as $item) {
            $subTotal += $item->price * $item->qty;
        }

        return view('user.cart.cart', compact('carts', 'subTotal'));
    }

    // add to cart (post)
    public function addToCart(Request $request) {
        Cart::create([
            'user_id' => $request->userId,
            'product_id' => $request->productId,
            'qty' => $request->count
        ]);

        Alert::success('Success Title', 'Added To Cart Successfully!');
        return back();
    }

    // add to cart (get)
    // public function addToCartGetMethod($id) {
    //     Cart::create([
    //         'user_id' => Auth::user()->id,
    //         'product_id' => $id,
    //         'qty' => 1
    //     ]);

    //     Alert::success('Success Title', 'Added To Cart Successfully!');
    //     return back();
    // }

    // delete cart
    public function delete(Request $request) {
        $cartId = $request['cartId'];
        Cart::where('id',$cartId)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'cart deleted successfully'
        ], 200);
    }

    // temp order store
    public function temp(Request $request) {
        $orderTemp = [];

        foreach ($request->all() as $item) {
            array_push($orderTemp, [
                'product_id' => $item['product_id'],
                'user_id' => $item['user_id'],
                'count' => $item['count'],
                'status' => $item['status'],
                'order_code' => $item['order_code'],
                'total_amt' => $item['total_amt']
            ]);
        }

        Session::put('orderTemp', $orderTemp);

        return response()->json([
            'status' => 'success',
            'message' => 'temp data stored successfully'
        ], 200);
    }

    // payment page
    public function paymentPage() {
        $orderTemp = Session::get('orderTemp');
        $payments = Payment::select('id','account_name','account_number','type')
                            ->orderBy('type','asc')
                            ->get();

        return view('user.order.payment', compact('orderTemp', 'payments'));
    }

    // create order
    public function create(Request $request) {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|max:12',
            'address' => 'required|max:100',
            'paymentType' => 'required',
            'payslipImage' => 'required|file|mimes:jpg,jpeg,png,svg,webp,gif',
        ]);

        $data = [
            'user_name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_method' => $request->paymentType,
            'order_code' => $request->orderCode,
            'total_amt' => $request->totalAmount,
        ];

        if($request->hasFile('payslipImage')) {
            $imgName = uniqid() . $request->file('payslipImage')->getClientOriginalName();
            $request->file('payslipImage')->move( public_path() . '/payslipImage/' , $imgName );
            $data['payslip_image'] = $imgName;
        }

        PaymentHistory::create($data);

        $orderTemp = Session::get('orderTemp');
        foreach ($orderTemp as $item) {
            Order::create([
                'product_id' => $item['product_id'],
                'user_id' => $item['user_id'],
                'count' => $item['count'],
                'order_code' => $item['order_code'],
                'status' => $item['status'],
            ]);

            Cart::where('user_id',$item['user_id'])->where('product_id',$item['product_id'])->delete();

        }

        Alert::success('Thanks for shopping with us', 'Your order placed successfully');
        return to_route('userOrderList');

    }

    // order list page
    public function list() {
        $orderList = Order::where('user_id',Auth::user()->id)
                            ->groupBy('order_code')
                            ->orderBy('created_at','desc')
                            ->get();

        return view('user.order.list', compact('orderList'));
    }

    // contact
    public function contactPage() {
        return view('user.contact.contactPage');
    }

    // create contact
    public function contactCreate(Request $request) {
      $this->checkContactValidation($request);

      Contact::create([
        'user_id' => Auth::user()->id,
        'title' => $request->title,
        'message' => $request->message
      ]);

    Alert::success('Success Title', 'Report Sent Successfully!');
    return back();

    }

    // check contact validation
    private function checkContactValidation($request) {
        $request->validate([
            'title' => "required|max:30",
            'message' => "required|max:200",
        ]);
    }
}
