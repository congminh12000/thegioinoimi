<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../Connections/cnn_hoaly.php');
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

require_once('../includes/my/order.php');

$arrResp = [
    'isError' => true,
    'message' => 'Error'
];

if ($_GET) {
    $orderId = (int) $_GET['orderId'];

    if (!$orderId) {
        echo json_encode($arrResp);
        die;
    }

    $strQuery = "SELECT * FROM orders WHERE status != 'complete' AND deleted = 0 AND ID_order = {$orderId}";

    $query = mysql_query($strQuery);

    if (!mysql_num_rows($query)) {
        $arrResp['message'] = 'Không tìm thấy đơn hàng !';
        echo json_encode($arrResp);
        die;
    }

    $order = mysql_fetch_assoc($query);
    
    $classOrder = new Order();
    
    $arrOrderStatus = $classOrder->listStatus($order['status']);

    $arrResp = [
        'isError' => false,
        'data' => [
            'arrOrderStatus' => $arrOrderStatus,
            'order' => $order
        ]
    ];
}

echo json_encode($arrResp);
die;
