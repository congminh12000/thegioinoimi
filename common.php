<?php

session_start();
header('Cache-control: private'); // IE 6 FIX

$lang = $_SESSION['lang'];

switch ($lang) {
    case 'en':
        
        $lang_file = 'lang.en.php';
        break;

    case 'vn':
        
        $lang_file = 'lang.vn.php';
        break;

    case 'tw':
        
        $lang_file = 'lang.tw.php';
        break;

    default:
        
        $lang_file = 'lang.vn.php';
        break;
}

include_once 'languages/' . $lang_file;
?>