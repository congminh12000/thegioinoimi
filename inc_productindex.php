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

//format price
require_once('includes/my/format-price.php');
$formatPrice = new FormatPrice();

mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
$query_rs_productindex = "SELECT * FROM product WHERE productapproval = 1 ORDER BY productorderlist ASC LIMIT 0,8";
$rs_productindex = mysql_query($query_rs_productindex, $cnn_hoaly) or die(mysql_error());

//get ID_product
while ($row = mysql_fetch_assoc($rs_productindex)) {
    $arrProdId[] = $row['ID_product'];
}

$rs_productindex = mysql_query($query_rs_productindex, $cnn_hoaly) or die(mysql_error());

$row_rs_productindex = mysql_fetch_assoc($rs_productindex);
$totalRows_rs_productindex = mysql_num_rows($rs_productindex);

//price 
require_once ('includes/my/price.php');
$classPrice = new Price();
$arrPrice = $classPrice->priceMultiAccessLevel($arrProdId);
//var_dump($arrProdId);die;
session_start();
$user = $_SESSION['user'];
$id_account = (int) $user['ID_account'];
?>

<?php do { ?>
    <li class="productboxdetail" style="height:auto"> 
        <a href="productdetail.php?cat=<?php echo $row_rs_productindex['ID_danhmuc2']; ?>&amp;id=<?php echo $row_rs_productindex['ID_product']; ?>" target="_self"><img src="images/product/<?php echo $row_rs_productindex['productimg']; ?>" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive"></a>
        <span class="text-center">
            <h4><a href="productdetail.php?cat=<?php echo $row_rs_productindex['ID_danhmuc2']; ?>&amp;id=<?php echo $row_rs_productindex['ID_product']; ?>" target="_self"><?php echo $row_rs_productindex['productname']; ?></a></h4>

            <?php if ($id_account): ?>
                <p><?php echo isset($arrPrice[$row_rs_productindex['ID_product']]) ? $formatPrice->format($arrPrice[$row_rs_productindex['ID_product']]) : ''; ?></p>
            <?php else: ?>
                <?php if (!$row_rs_productindex['is_hidden_price']): ?>
                    <p><?php echo isset($arrPrice[$row_rs_productindex['ID_product']]) ? $formatPrice->format($arrPrice[$row_rs_productindex['ID_product']]) : $formatPrice->format($row_rs_productindex['productprice']); ?></p>
                <?php endif; ?>
            <?php endif; ?>

            <p><a href="cart.php" class="btn btn-info" role="button">Thanh toán</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" target="_self" class="btn btn-info btn-add-cart" data-id='<?php echo $row_rs_productindex['ID_product']; ?>' data-is-type-menubar2="1" data-type-menubar2="<?php echo $row_rs_productindex['ID_danhmuc2']; ?>">Thêm giỏ hàng</a></p>
        </span>
    </li>
<?php } while ($row_rs_productindex = mysql_fetch_assoc($rs_productindex)); ?>

<?php
mysql_free_result($rs_productindex);
?>