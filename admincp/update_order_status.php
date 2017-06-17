<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../Connections/cnn_hoaly.php');
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

$arrResp = [
    'isError' => true,
    'message' => 'Error'
];

if ($_POST) {
    $orderId = (int) $_POST['orderId'];
    $status = trim($_POST['status']);

    if (!$orderId || empty($status)) {
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

    $strQuery = "UPDATE orders SET status = '{$status}' WHERE ID_order = {$orderId}";

    $isUpdate = mysql_query($strQuery);

    if ($isUpdate) {

        $arrResp = [
            'isError' => false
        ];
    }
}

echo json_encode($arrResp);
die;
