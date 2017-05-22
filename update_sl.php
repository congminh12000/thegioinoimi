<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$arrResp = [
    'isError' => true,
    'message' => 'Error',
    'data' => []
];

if ($_GET) {
    $productId = (int) $_GET['productId'];
    $sl = (int) $_GET['sl'];

    if (!$productId || $sl <= 0) {
        $arrResp['message'] = 'Lỗi !';
        echo json_encode($arrResp);
        die;
    }

    session_start();
    $user = $_SESSION['user'];
//unset($_SESSION['cart']);die;
    if (empty($user)) {
        $arrResp['message'] = 'Lỗi !';
        echo json_encode($arrResp);
        die;
    }

    $userId = (int) $user['ID_account'];

    $sessionProdId = $_SESSION['cart'][$userId]['arrProd'][$productId];

    if (empty($sessionProdId)) {
        $arrResp['message'] = 'Lỗi !';
        echo json_encode($arrResp);
        die;
    }
    
    //old sl
    $oldSl = $sessionProdId['sl'];
  
    //update new sl
    $_SESSION['cart'][$userId]['arrProd'][$productId]['sl'] = $sl;
  
    $arrResp = [
        'isError' => false,
        'message' => 'Success',
        'data' => [
            'oldSl' => $oldSl
        ]
    ];
}

echo json_encode($arrResp);
