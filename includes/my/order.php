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

    public function listStatus($positionStatus = '') {
        $arrStatus = [
            'pending' => 'Chờ xử lý',
            'confirm' => 'Xác nhận',
            'shipping' => 'Giao hàng',
            'complete' => 'Hoàn tất'
        ];

        if ($positionStatus) {
            
            $number = array_search($positionStatus, array_keys($arrStatus)) + 1;
            $arrStatus = array_slice($arrStatus, $number);
        }

        return $arrStatus;
    }

    public function getStatus($status) {
        $arrStatus = $this->listStatus();

        return isset($arrStatus[$status]) ? $arrStatus[$status] : '';
    }

    public function labelColorStatus($status) {

        if (empty($status)) {
            return '';
        }

        $_status = $this->getStatus($status);

        switch ($status) {
            case 'pending':

                $label = '<span class="label label-warning">' . $_status . '</span>';
                break;
            case 'confirm':

                $label = '<span class="label label-primary">' . $_status . '</span>';
                break;
            case 'shipping':

                $label = '<span class="label label-info">' . $_status . '</span>';
                break;
            case 'complete':

                $label = '<span class="label label-success">' . $_status . '</span>';
                break;
        }

        return $label;
    }

}
