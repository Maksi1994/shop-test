<?php
namespace App\Models;

class CartModel extends BaseModel {

    public function getBasketData() {
        $cookieString = $_COOKIE[USER['id'].'-cart'];

        return array_map(function ($strData) {
            $sliced = explode('=', $strData);

            return [
                'product_id' => $sliced[0],
                'count' => $sliced[1]
            ];
        }, explode('|', $cookieString));
    }

    public function removeFromBasket() {

    }
}