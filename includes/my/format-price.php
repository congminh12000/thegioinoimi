<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class FormatPrice {

    protected $_symbol = 'đ';

    public function __construct() {
        return $this;
    }

    public function format($number) {
        $number = (int) $number;

        $price = number_format($number, 0, '.', ',') . ' ' . $this->_symbol;

        return $price;
    }

}
