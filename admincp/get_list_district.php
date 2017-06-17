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
    $cityId = (int) $_GET['cityId'];

    if (!$cityId) {
        echo json_encode($arrResp);
        die;
    }

    $strQuery = "SELECT * FROM district WHERE status = 1 AND city_id = {$cityId}";
    
    $query = mysql_query($strQuery);

    if (!mysql_num_rows($query)) {
        $arrResp['message'] = 'Không tìm thấy !';
        echo json_encode($arrResp);
        die;
    }

    while ($row = mysql_fetch_assoc($query)) {
        $arrType[] = $row;
    }

    $arrResp = [
        'isError' => false,
        'data' => [
            'arrDistrict' => $arrType
        ]
    ];
}

echo json_encode($arrResp);
die;
