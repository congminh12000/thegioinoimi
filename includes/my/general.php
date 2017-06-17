<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class General {

    public static function listCategoryMiNoi() {
        $arrList = [
            '1' => 'Dầy',
            '2' => 'Cong',
            '3' => 'Dài'
        ];

        return $arrList;
    }

    public static function listOrderStatus() {
        $arrStatus = [
            'pending' => 'Chờ xử lý',
            'confirm' => 'Xác nhận',
            'shipping' => 'Giao hàng',
            'complete' => 'Hoàn tất'
        ];

        return $arrStatus;
    }

    public static function getOrderStatus($status) {
        $arrStatus = self::listOrderStatus();

        return $arrStatus[$status];
    }

}
