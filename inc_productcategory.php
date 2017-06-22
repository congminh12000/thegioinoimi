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
$query_rs_productcategory = "SELECT ID_menubar2, menubar2name, menubar2name_EN, menubar2visible FROM menubar2 WHERE ID_menubar1 = 3 AND menubar2visible =1 ORDER BY menubar2orderlist ASC";
$rs_productcategory = mysql_query($query_rs_productcategory, $cnn_hoaly) or die(mysql_error());
$row_rs_productcategory = mysql_fetch_assoc($rs_productcategory);
$totalRows_rs_productcategory = mysql_num_rows($rs_productcategory);
?>

<?php
do {

    switch ($lang) {
        case 'vn':

            $name = $row_rs_productcategory['menubar2name'];
            break;
        case 'en':

            $name = $row_rs_productcategory['menubar2name_EN'];
            break;
        case 'tw':

            $name = $row_rs_productcategory['menubar2name_TW'];
            break;
        default:

            $name = $row_rs_productcategory['menubar2name'];
            break;
    }
    ?>
    <p><a href="product.php?cat=<?php echo $row_rs_productcategory['ID_menubar2']; ?>" target="_self"><i class="fa fa-star" aria-hidden="true"></i>&nbsp;&nbsp<?php echo $name; ?></a></p>
<?php } while ($row_rs_productcategory = mysql_fetch_assoc($rs_productcategory)); ?>

<?php
mysql_free_result($rs_productcategory);
?>