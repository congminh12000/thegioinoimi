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
    'message' => 'Error'
];

if ($_GET) {
    $typeMenubar2Id = (int) $_GET['typeMenubar2Id'];

    if (!$typeMenubar2Id) {
        echo json_encode($arrResp);
        die;
    }

    $strQuery = "SELECT * FROM type_menubar2 WHERE tm2_status = 1 AND tm2_deleted = 0 AND ID_menubar2 = {$typeMenubar2Id}";
    $query = mysql_query($strQuery);

    if (!mysql_num_rows($query)) {
        $arrResp['message'] = 'Không tìm thấy loại nào !';
        echo json_encode($arrResp);
        die;
    }

    while ($row = mysql_fetch_assoc($query)) {
        $arrType[] = $row;
    }

    $arrResp = [
        'isError' => false,
        'data' => [
            'arrType' => $arrType
        ]
    ];

}

echo json_encode($arrResp);
die;