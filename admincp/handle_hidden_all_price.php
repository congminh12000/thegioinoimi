<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('../Connections/cnn_hoaly.php');
//mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

$arrResp = [
    'isError' => true
];

if ($_GET) {
    $isCheck = $_GET['isCheck'];
    
    $strQuery = 'UPDATE product SET is_hidden_price = ' . $isCheck;
    
    $mysqli = new mysqli($hostname_cnn_hoaly, $username_cnn_hoaly, $password_cnn_hoaly, $database_cnn_hoaly);
    $mysqli->autocommit(false);
    $mysqli->query($strQuery);
    $mysqli->commit();
    
//    $query = mysql_query($strQuery);

    $arrResp = [
        'isError' => false
    ];
}

echo json_encode($arrResp);
die;
