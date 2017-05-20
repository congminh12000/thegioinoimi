<?php require_once('Connections/cnn_hoaly.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {

    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }

        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

        switch ($theType) {
            case "text":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "long":
            case "int":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
                break;
            case "date":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }

}

mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
$query_rs_menubar_product = "SELECT ID_menubar2, menubar2name FROM menubar2 WHERE ID_menubar1 = 3 ORDER BY menubar2orderlist ASC";
$rs_menubar_product = mysql_query($query_rs_menubar_product, $cnn_hoaly) or die(mysql_error());
$row_rs_menubar_product = mysql_fetch_assoc($rs_menubar_product);
$totalRows_rs_menubar_product = mysql_num_rows($rs_menubar_product);
?>

<?php do { ?>
    <li><a href="product.php?cat=<?php echo $row_rs_menubar_product['ID_menubar2']; ?>"><?php echo $row_rs_menubar_product['menubar2name']; ?></a></li>
<?php } while ($row_rs_menubar_product = mysql_fetch_assoc($rs_menubar_product)); ?>

<?php
mysql_free_result($rs_menubar_product);
?>