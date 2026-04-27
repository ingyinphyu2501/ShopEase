<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatbotController extends Controller
{
    //
    public function chat(Request $request) {
        $product = Order::select('products.name',Order::raw('SUM(orders.count) as total_count'))
                            ->leftJoin('products','products.id','orders.product_id')
                            ->where('orders.status',1)
                            ->groupBy('orders.product_id')
                            ->orderBy('total_count','desc')
                            ->first();

        $bestseller = $product->name;
        $message = strtolower($request['message']);
        $reply = 'Sorry, I did not understand. Try asking about popular products, promotions, shipping, or returns.';

        if (str_contains($message, 'popular') || str_contains($message, 'best seller')) {
            $reply = 'Our most popular product right now is ' . $bestseller . '.';
        } elseif (str_contains($message, 'promotion') || str_contains($message, 'discount') || str_contains($message, 'deal')) {
            $reply = 'Sorry to say that we do not have any promotion yet. We will announce if there is a promotion.';
        } elseif (str_contains($message, 'shipping')) {
            $reply = 'We offer free shipping on all orders over 300000 mmk. Your order will arrive 3-4 days after purchasing.';
        } elseif (str_contains($message, 'return') || str_contains($message, 'refund')) {
            $reply = 'We will not be able to exchange the item and give refund unless the purchased item has an error or somethind else.';
        } elseif (str_contains($message, 'hi') || str_contains($message, 'hello')) {
            $reply = 'Hello! How can we help you today?';
        }

        return response()->json([
            'status' => 'success',
            'response' => $reply
        ], 200);


    }
}
