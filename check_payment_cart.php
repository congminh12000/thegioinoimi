<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$arrResp = [
    'isError' => true,
    'message' => 'Error'
];

if ($_GET) {
    session_start();
    $cart = $_SESSION['cart'];
   
    $isPayment = true;
    $nums = (int) current(array_column($cart, 'nums'));

    if (!$nums) {
        $isPayment = false;
    }
    
    $arrResp = [
        'isError' => false,
        'data' => [
            'isPayment' => $isPayment
        ]
    ];
}

echo json_encode($arrResp);
die;
