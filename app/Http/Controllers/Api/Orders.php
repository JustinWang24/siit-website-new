<?php

namespace App\Http\Controllers\Api;

use App\Models\Order\Order;
use App\Models\Utils\JsonBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Orders extends Controller
{

    public function search_ajax(Request $request){
        $result = [];
        $orders = Order::where('serial_number','like','%'.$request->get('q').'%')
            ->orderBy('id','desc')
            ->take(config('system.PAGE_SIZE'))
            ->get();

        foreach ($orders as $order) {
            $result[] = [
                'value'=>$order->serial_number,
                'id'=>$order->uuid
            ];
        }

        return count($result)>0 ? JsonBuilder::Success($result) : JsonBuilder::Error();
    }
}
