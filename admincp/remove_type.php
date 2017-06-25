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

if ($_GET) {
    $id = (int) $_GET['id'];

    if (!$id) {
        echo json_encode($arrResp);
        die;
    }

    $strQuery = "SELECT * FROM type_menubar2 WHERE parent_id = {$id}";
    $query = mysql_query($strQuery);

    if (mysql_num_rows($query)) {
        $arrResp['message'] = 'Loại này không thể xóa vì đang sử dụng !';
        echo json_encode($arrResp);
        die;
    }

    $strQuery = "UPDATE type_menubar2 SET tm2_deleted = 1 WHERE ID_type_menubar2 = {$id}";
    $query = mysql_query($strQuery);

    $arrResp = [
        'isError' => false,
    ];
}

echo json_encode($arrResp);
die;
