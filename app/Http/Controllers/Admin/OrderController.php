<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    // order list page
    public function list() {
        $orderList = Order::select('orders.id','orders.created_at','orders.order_code','orders.status','orders.count','users.name','products.stock')
                            ->leftJoin('users','orders.user_id','users.id')
                            ->leftJoin('products','orders.product_id','products.id')
                            ->when(request('searchKey'), function($query) {
                                $query->where('users.name','like','%'.request('searchKey').'%');
                            })
                            ->groupBy('orders.order_code')
                            ->orderBy('orders.created_at','desc')
                            ->get();

        return view('admin.order.list', compact('orderList'));
    }

    // order list count
    public function listCount() {
        $saleInformation = Order::select('products.image','products.name','products.price',Order::raw('SUM(orders.count) as total_count'))
                                ->leftJoin('products','orders.product_id','products.id')
                                ->where('status',1)
                                ->groupBy('orders.product_id','products.image','products.name','products.price')
                                ->orderBy('total_count','desc')
                                ->get();

        return view('admin.order.listCount', compact('saleInformation'));
    }

    // display all order requests
    public function orderRequest() {
        $orderRequest = Order::select('orders.id','orders.created_at','orders.order_code','users.name')
                            ->leftJoin('users','orders.user_id','users.id')
                            ->leftJoin('products','orders.product_id','products.id')
                            ->when(request('searchKey'), function($query) {
                                $query->where('users.name','like','%'.request('searchKey').'%');
                            })
                            ->where('orders.status',1)
                            ->orderBy('orders.created_at','desc')
                            ->get();

        return view('admin.order.orderRequest', compact('orderRequest'));
    }

    // order details page
    public function details($orderCode) {
        $order = Order::select('orders.id as order_id','orders.count','orders.status','orders.order_code','orders.created_at','users.name as user_name','users.nickname','users.phone','users.address','products.id as product_id','products.image','products.name as product_name','products.stock','products.price')
                        ->leftJoin('users','orders.user_id','users.id')
                        ->leftJoin('products','orders.product_id','products.id')
                        ->where('orders.order_code',$orderCode)
                        ->get();

        $paymentHistory = PaymentHistory::select('payment_histories.phone','payment_histories.address','payment_histories.payslip_image','payment_histories.total_amt','payment_histories.created_at','payments.type')
                                        ->leftJoin('payments','payment_histories.payment_method','payments.id')
                                        ->where('order_code',$orderCode)
                                        ->first();
        $status = true;
        foreach ($order as $item) {
            if( $item->count <= $item->stock ) {
                $status = true;
            }else {
                $status = false;
                break;
            }
        }

        return view('admin.order.details', compact('order','paymentHistory','status'));
    }

    // reject order
    public function reject(Request $request) {
        Order::where('order_code', $request['orderCode'])->update([
            'status' => 2
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'order rejected successfully'
        ], 200);
    }

    // confirm order
    public function confirm(Request $request) {
        Order::where('order_code', $request[0]['orderCode'])->update([
            'status' => 1
        ]);

        foreach ($request->all() as $item) {
            Product::where('id', $item['productId'])->decrement('stock', $item['count']);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'order confirmed successfully'
        ], 200);
    }

    // status change
    public function statusChange(Request $request) {
        Order::where('order_code', $request['orderCode'])->update([
            'status' => $request['status']
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'status changed successfully'
        ], 200);
    }
}
