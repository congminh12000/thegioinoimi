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

    if (!$productId) {
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
    
    $sl = $sessionProdId['sl'];
    
    //unset prod
    unset($_SESSION['cart'][$userId]['arrProd'][$productId]);
    
    //update nums
    if($_SESSION['cart'][$userId] > 1){
        $_SESSION['cart'][$userId]['nums'] -= 1;
    }else{
        unset($_SESSION['cart'][$userId]['nums']);
    }
  
    $arrResp = [
        'isError' => false,
        'message' => 'Success',
        'data' => [
            'sl' => $sl
        ]
    ];
}

echo json_encode($arrResp);
