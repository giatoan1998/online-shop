<?php

use App\Mail\OrderEmail;
use App\Models\Category;
use App\Models\Order;
use App\Models\ProductImage;

    function getCategories() {
        return Category::orderBy('name', 'ASC')
        ->with('sub_category')
        ->orderBy('id', 'DESC')
        ->where('status', 1)
        ->where('showHome', 'Yes')
        ->get();
    }

    function getProductImage($productId) {

        return ProductImage::where('product_id', $productId)->first();
    }

    function orderEmail ($orderId) {
        $order = Order::where('id', $orderId)->first();

        dd($order);
    }

?>
