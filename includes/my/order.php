<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Order {

    public function __construct() {
        return $this;
    }

    public function listStatus() {
        $arrStatus = [
            'pending' => 'Chờ xử lý'
        ];

        return $arrStatus;
    }

    public function getStatus($status) {
        $arrStatus = $this->listStatus();

        return isset($arrStatus[$status]) ? $arrStatus[$status] : '';
    }

}
