<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$arrResp = [
    'isError' => true,
    'message' => 'Error'
];

if ($_GET) {
    $lang = trim($_GET['lang']);

    session_start();

    switch ($lang) {
        case 'vn':
            
            $_SESSION['lang'] = 'vn';
            break;
        case 'en':
            
            $_SESSION['lang'] = 'en';
            break;
        case 'tw':
            
            $_SESSION['lang'] = 'tw';
            break;
        default:
            
            $_SESSION['lang'] = 'vn';
            break;
    }

    $arrResp = [
        'isError' => false
    ];
}

echo json_encode($arrResp);
die;
