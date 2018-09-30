<?php
namespace App\Models;

class CartModel extends BaseModel {

    public function getBasketData() {
        $result = [];

        if (!empty($_COOKIE[USER['id'].'-cart'])) {
            $cookieString = $_COOKIE[USER['id'].'-cart'];

            $result =  array_map(function ($strData) {
                list($product, $promotion) = explode('&', $strData);

                $product = explode('=', $product);
                $promotion = explode('=', $promotion);

                return [
                    'id' => $product[0],
                    'count' => $product[1],
                    'promotion' => $promotion[1]
                ];
            }, explode('|', $cookieString));
        }

        return $result;
    }
}