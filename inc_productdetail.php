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

$KTColParam1_rs_productdetail = "1";
if (isset($_GET["id"])) {
    $KTColParam1_rs_productdetail = $_GET["id"];
}
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
$query_rs_productdetail = sprintf("SELECT * FROM product WHERE product.ID_product=%s ", GetSQLValueString($KTColParam1_rs_productdetail, "int"));
$rs_productdetail = mysql_query($query_rs_productdetail, $cnn_hoaly) or die(mysql_error());
$row_rs_productdetail = mysql_fetch_assoc($rs_productdetail);
$totalRows_rs_productdetail = mysql_num_rows($rs_productdetail);

//class price
require_once ('includes/my/price.php');
$classPrice = new Price();
$price = $classPrice->priceDetailToAccessLevel($KTColParam1_rs_productdetail);

//session
session_start();
$user = $_SESSION['user'];
$id_account = (int) $user['ID_account'];

//get type menubar2
$strQuery = "SELECT * FROM type_menubar2 WHERE tm2_status = 1 AND tm2_deleted = 0 AND ID_menubar2 = {$row_rs_productdetail['ID_danhmuc2']}";
$query = mysql_query($strQuery);
?>

<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
    <img src="images/product/<?php echo $row_rs_productdetail['productimg']; ?>" alt="<?php echo $row_rs_productdetail['productname']; ?>" class="img-responsive">
</div> <!-- end col -->
<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
    <h4><?php echo $row_rs_productdetail['productname']; ?></h4>
    <span class="line3"></span>

    <?php if ($id_account): ?>
        <h5><b>Giá bán:</b> <?php echo $price !== false ? $formatPrice->format($price) : ''; ?></h5>
    <?php else: ?>
        <?php if (!$row_rs_productdetail['is_hidden_price']): ?>
            <h5><b>Giá bán:</b> <?php echo $price !== false ? $formatPrice->format($price) : $formatPrice->format($row_rs_productdetail['productprice']); ?></h5>
        <?php endif; ?>
    <?php endif; ?>


    <h5><b>Chất liệu:</b> <?php echo $row_rs_productdetail['productmaterial']; ?></h5>
    <h5><b>Màu sắc:</b> <?php echo $row_rs_productdetail['productcolor']; ?></h5>

    <?php
    //get cate noi mi
    if (mysql_num_rows($query)):
        ?>
        <h5><b>Loại :</b> 
            <select class="type-menubar2">
                <?php while ($row = mysql_fetch_assoc($query)): ?>
                    <option value="<?php echo $row['ID_type_menubar2']; ?>"><?php echo $row['tm2_name']; ?></option>
                <?php endwhile; ?>
            </select>
        </h5>
        <?php
    else:
        ?>
        <input type="hidden" class="type-menubar2" value="0" />
    <?php
    endif;
    ?>
    <a href="javascript:void(0);" class="btn btn-info btn-add-cart" data-id="<?php echo $row_rs_productdetail['ID_product']; ?>" role="button">Thêm giỏ hàng</a>&nbsp;&nbsp;&nbsp; <a href="cart.php" class="btn btn-info" role="button">Thanh toán</a>
</div> <!-- end col -->
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 boxproductcaption">
        <h3>Mô tả sản phẩm:</h3>
        <span class="line3"></span>
        <p><?php echo $row_rs_productdetail['productdetail']; ?></p>
    </div> <!-- end col -->
</div> <!-- end row boxproductcaption-->

<?php
mysql_free_result($rs_productdetail);
?>