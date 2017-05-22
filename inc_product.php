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

$KTColParam1_rs_product = "2";
if (isset($_GET["cat"])) {
  $KTColParam1_rs_product = $_GET["cat"];
}
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
$query_rs_product = sprintf("SELECT product.ID_product, product.productname, product.productname_EN, product.productimg, product.productprice, product.ID_danhmuc2, product.productorderlist, product.productapproval FROM product WHERE product.ID_danhmuc2=%s  AND product.productapproval=1 ORDER BY product.productorderlist ASC ", GetSQLValueString($KTColParam1_rs_product, "int"));
$rs_product = mysql_query($query_rs_product, $cnn_hoaly) or die(mysql_error());
$row_rs_product = mysql_fetch_assoc($rs_product);
$totalRows_rs_product = mysql_num_rows($rs_product);

//price 
require_once ('includes/my/price.php');
$classPrice = new Price();
$arrPrice = $classPrice->priceCatToAccessLevel($KTColParam1_rs_product);
//$classPrice->p($arrPrice);
?>

					<?php do { ?>
					  <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center productbox">
					    <a href="productdetail.php?cat=<?php echo $row_rs_product['ID_danhmuc2']; ?>&amp;id=<?php echo $row_rs_product['ID_product']; ?>" target="_self"><img src="images/product/<?php echo $row_rs_product['productimg']; ?>" alt="Công Ty TNHH Thương Mại Lyan"></a>
					    <h4><a href="productdetail.php?cat=<?php echo $row_rs_product['ID_danhmuc2']; ?>&amp;id=<?php echo $row_rs_product['ID_product']; ?>" target="_self"><?php echo $row_rs_product['productname']; ?></a></h4>
					    <p><?php echo isset($arrPrice[$row_rs_product['ID_product']]) ? $arrPrice[$row_rs_product['ID_product']] : $row_rs_product['productprice']; ?>đ</p>
                                            <p><a href="productdetail.php?cat=<?php echo $row_rs_product['ID_danhmuc2']; ?>&amp;id=<?php echo $row_rs_product['ID_product']; ?>" target="_self">Chi tiết</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" target="_self" class="btn-add-cart" data-id='<?php echo $row_rs_product['ID_product']; ?>'>Giỏ hàng</a></p>
                                            <p class="success-add-cart" style="display: none"><i class="fa fa-check" aria-hidden="true" style="color: #00BB00; font-size: 20px"></i></p>
					    </div> <!-- end col product box-->
					  <?php } while ($row_rs_product = mysql_fetch_assoc($rs_product)); ?>

<?php
mysql_free_result($rs_product);
?>