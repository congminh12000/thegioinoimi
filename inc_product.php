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
$query_rs_product = "SELECT * FROM product WHERE product.productapproval=1";

$KTColParam1_rs_product = "2";
if (isset($_GET["cat"])) {
    $KTColParam1_rs_product = (int) $_GET["cat"];
}

$query_rs_product .= " AND product.ID_danhmuc2 = {$KTColParam1_rs_product} ORDER BY product.productorderlist ASC";

//get list product
//$rs_product = mysql_query($query_rs_product, $cnn_hoaly) or die(mysql_error());
//class paginator
require_once('includes/my/paginator.php');
//echo $query_rs_product;die;
$classPaginator = new Paginator($query_rs_product);

$limit = ( isset($_GET['limit']) ) ? $_GET['limit'] : 9;
$page = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
$links = ( isset($_GET['links']) ) ? $_GET['links'] : 1;

$results = $classPaginator->getData($limit, $page);

//price 
require_once ('includes/my/price.php');
$classPrice = new Price();
$arrPrice = $classPrice->priceCatToAccessLevel($KTColParam1_rs_product);
//$classPrice->p($arrPrice);
//session
session_start();
$user = $_SESSION['user'];
$id_account = (int) $user['ID_account'];

//get type_menubar2
$strQuery = "SELECT * FROM type_menubar2 WHERE tm2_status = 1 AND tm2_deleted = 0 AND ID_menubar2 = {$KTColParam1_rs_product}";
$query = mysql_query($strQuery);
$arrTypeMenubar2 = [];

if (mysql_num_rows($query)) {
    while ($row = mysql_fetch_assoc($query)) {
        $arrTypeMenubar2[] = $row;
    }
}

//var_dump($arrPrice);
?>
<div class="product">
    <?php
    if ($results->total):
        $stt = 1;
        foreach ($results->data as $row):
//                                                var_dump($row);die;
            ?>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center productbox productboxdetail">
                <a href="productdetail.php?cat=<?php echo $row['ID_danhmuc2']; ?>&amp;id=<?php echo $row['ID_product']; ?>" target="_self"><img src="images/product/<?php echo $row['productimg']; ?>" alt="Công Ty TNHH Thương Mại Lyan"></a>
                <h4><a href="productdetail.php?cat=<?php echo $row['ID_danhmuc2']; ?>&amp;id=<?php echo $row['ID_product']; ?>" target="_self"><?php echo $row['productname']; ?></a></h4>

                <?php if ($id_account): ?>
                    <p><?php echo isset($arrPrice[$row['ID_product']]) ? $formatPrice->format($arrPrice[$row['ID_product']]) : ''; ?></p>
                <?php else: ?>
                    <?php if (!$row['is_hidden_price']): ?>
                        <p><?php echo isset($arrPrice[$row['ID_product']]) ? $formatPrice->format($arrPrice[$row['ID_product']]) : $formatPrice->format($row['productprice']); ?></p>
                    <?php endif; ?>
                <?php endif; ?>


                <p><a href="javascript:void(0);" class="btn btn-info btn-payment-cart" role="button">Thanh toán</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" target="_self" class="btn btn-info btn-add-cart" data-id='<?php echo $row['ID_product']; ?>' data-is-type-menubar2="1" data-type-menubar2="<?php echo $KTColParam1_rs_product; ?>">Thêm giỏ hàng</a></p>
            </div> <!-- end col product box-->
            <?php
            $stt++;
        endforeach;
    else:
        ?>
        Không có dữ liệu nào !
    <?php
    endif;
    ?>
</div>
<?php
mysql_free_result($rs_product);
?>