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

//session
session_start();
$user = $_SESSION['user'];
$id_account = (int) $user['ID_account'];

$colname_rs_productrelative = "2";
if (isset($_GET['cat'])) {
    $colname_rs_productrelative = $_GET['cat'];
}
$colname2_rs_productrelative = "1";
if (isset($_GET['id'])) {
    $colname2_rs_productrelative = $_GET['id'];
}
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
$query_rs_productrelative = sprintf("SELECT * FROM product WHERE ID_danhmuc2 = %s AND productapproval = 1 AND ID_product != %s ORDER BY productorderlist ASC LIMIT 0,3", GetSQLValueString($colname_rs_productrelative, "int"), GetSQLValueString($colname2_rs_productrelative, "int"));
$rs_productrelative = mysql_query($query_rs_productrelative, $cnn_hoaly) or die(mysql_error());
$row_rs_productrelative = mysql_fetch_assoc($rs_productrelative);
$totalRows_rs_productrelative = mysql_num_rows($rs_productrelative);

//price 
require_once ('includes/my/price.php');
$classPrice = new Price();
$arrPrice = $classPrice->priceCatToAccessLevel($colname_rs_productrelative);
?>
<div class="product">
    <?php do { ?>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center productbox productboxdetail">
            <a href="productdetail.php?cat=<?php echo $row_rs_productrelative['ID_danhmuc2']; ?>&id=<?php echo $row_rs_productrelative['ID_product']; ?>" target="_self"><img src="images/product/<?php echo $row_rs_productrelative['productimg']; ?>" alt="Công Ty TNHH Thương Mại Lyan"></a>
            <h4><a href="productdetail.php?cat=<?php echo $row_rs_productrelative['ID_danhmuc2']; ?>&id=<?php echo $row_rs_productrelative['ID_product']; ?>" target="_self"><?php echo $row_rs_productrelative['productname']; ?></a></h4>

            <?php if ($id_account): ?>
                <p><?php echo isset($arrPrice[$row_rs_productrelative['ID_product']]) ? $formatPrice->format($arrPrice[$row_rs_productrelative['ID_product']]) : ''; ?></p>
            <?php else: ?>
                <?php if (!$row_rs_productrelative['is_hidden_price']): ?>
                    <p><?php echo isset($arrPrice[$row_rs_productrelative['ID_product']]) ? $formatPrice->format($arrPrice[$row_rs_productrelative['ID_product']]) : $formatPrice->format($row_rs_productrelative['productprice']); ?></p>
                <?php endif; ?>
            <?php endif; ?>

            <a href="javascript:void(0);" target="_self" class="btn btn-info btn-add-cart" data-id='<?php echo $row_rs_productrelative['ID_product']; ?>' data-is-type-menubar2="1" data-type-menubar2="<?php echo $colname_rs_productrelative; ?>">Thêm giỏ hàng</a>&nbsp;&nbsp;&nbsp; <a href="cart.php" class="btn btn-info" role="button">Thanh toán</a>
        </div> <!-- end col -->
    <?php } while ($row_rs_productrelative = mysql_fetch_assoc($rs_productrelative)); ?>
</div>
<?php
mysql_free_result($rs_productrelative);
?>