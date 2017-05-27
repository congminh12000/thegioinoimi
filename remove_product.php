<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('Connections/cnn_hoaly.php');
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

$arrResp = [
    'isError' => true,
    'message' => 'Error',
    'data' => []
];

if ($_GET) {
    $productId = (int) $_GET['productId'];
    $typeMenubar2Id = (int) $_GET['typeMenubar2Id'];

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
    
    //get type
    $strQuery = "SELECT * FROM type_menubar2 WHERE tm2_status = 1 AND tm2_deleted = 0 AND ID_type_menubar2 = {$typeMenubar2Id}";
    $query = mysql_query($strQuery);
    $typeMenubar2 = mysql_fetch_assoc($query);
    $ID_type_menubar2 = (int) $typeMenubar2['ID_type_menubar2'];

    $sessionProdId = $_SESSION['cart'][$userId]['arrProd'][$productId][$ID_type_menubar2];
    
    $sl = $sessionProdId['sl'];
    
    //unset prod
    unset($_SESSION['cart'][$userId]['arrProd'][$productId][$ID_type_menubar2]);
    
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
