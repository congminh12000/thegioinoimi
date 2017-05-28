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
    $typeMenubar2Id = (int) $_GET['typeMenubar2Id'];
    $qty = ((int) $_GET['qty']) > 0 ? $_GET['qty'] : 1;

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

    //sl 1 sp
    $sessionProdId = $_SESSION['cart'][$userId]['arrProd'][$productId][$typeMenubar2Id];

    if (empty($sessionProdId)) {
        //sl tong
        $_SESSION['cart'][$userId]['nums'] += 1;
    }

    //sl 1 sp
    $_SESSION['cart'][$userId]['arrProd'][$productId][$typeMenubar2Id]['sl'] += $qty;

    $nums = $_SESSION['cart'][$userId]['nums'];
//echo '<pre>';print_r($_SESSION);die;
    $arrResp = [
        'isError' => false,
        'message' => 'Success',
        'data' => [
            'nums' => $nums
        ]
    ];
}

echo json_encode($arrResp);
