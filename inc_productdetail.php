<?php require_once('Connections/cnn_hoaly.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
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

$KTColParam1_rs_productdetail = "1";
if (isset($_GET["id"])) {
  $KTColParam1_rs_productdetail = $_GET["id"];
}
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
$query_rs_productdetail = sprintf("SELECT product.ID_product, product.productname_EN, product.productname, product.productimg, product.productmaterial, product.productcolor, product.productprice, product.productkind, product.productdetail, product.productdetail_EN, product.productmaterial_EN, product.productcolor_EN, product.ID_danhmuc2 FROM product WHERE product.ID_product=%s ", GetSQLValueString($KTColParam1_rs_productdetail, "int"));
$rs_productdetail = mysql_query($query_rs_productdetail, $cnn_hoaly) or die(mysql_error());
$row_rs_productdetail = mysql_fetch_assoc($rs_productdetail);
$totalRows_rs_productdetail = mysql_num_rows($rs_productdetail);
?>

					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <img src="images/product/<?php echo $row_rs_productdetail['productimg']; ?>" alt="<?php echo $row_rs_productdetail['productname']; ?>" class="img-responsive">
                    </div> <!-- end col -->
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <h4><?php echo $row_rs_productdetail['productname']; ?></h4>
                        <span class="line3"></span>
                        <h5><b>Giá bán:</b> <?php echo $row_rs_productdetail['productprice']; ?>đ</h5>
                        <h5><b>Số lượng:</b> </h5>
                        <h5><b>Chất liệu:</b> <?php echo $row_rs_productdetail['productkind']; ?></h5>
                        <h5><b>Màu sắc:</b> <?php echo $row_rs_productdetail['productcolor']; ?></h5>
                        <a href="#" class="btn btn-info" role="button">Thêm giỏ hàng</a>&nbsp;&nbsp;&nbsp; <a href="#" class="btn btn-info" role="button">Thanh toán</a>
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