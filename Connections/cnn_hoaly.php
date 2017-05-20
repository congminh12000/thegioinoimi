<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cnn_hoaly = "localhost";
$database_cnn_hoaly = "tgnoimi_db";
$username_cnn_hoaly = "tgnoimi_db";
$password_cnn_hoaly = "TMvnEkCu3";
$cnn_hoaly = mysql_pconnect($hostname_cnn_hoaly, $username_cnn_hoaly, $password_cnn_hoaly) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
