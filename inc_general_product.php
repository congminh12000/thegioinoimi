<?php require_once('Connections/cnn_hoaly.php'); ?>
<?php
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

$query_rs_product = "SELECT * FROM product WHERE product.productapproval = 1 ORDER BY product.productorderlist ASC";

//class paginator
require_once('includes/my/paginator.php');
//echo $query_rs_product;die;
$classPaginator = new Paginator($query_rs_product);

$limit = ( isset($_GET['limit']) ) ? $_GET['limit'] : 9;
$page = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
$links = ( isset($_GET['links']) ) ? $_GET['links'] : 1;

$results = $classPaginator->getData($limit, $page);

$arrProdId = array_column($results->data, 'ID_product');

//price 
require_once ('includes/my/price.php');
$classPrice = new Price();
$arrPrice = $classPrice->priceMultiAccessLevel($arrProdId);

//session
session_start();
$user = $_SESSION['user'];
$id_account = (int) $user['ID_account'];

//format price
require_once('includes/my/format-price.php');
$formatPrice = new FormatPrice();
?>
<div class="product">
    <?php
    if ($results->total):
        $stt = 1;
        foreach ($results->data as $row):

            switch ($lang) {
                case 'vn':

                    $name = $row['productname'];
                    break;
                case 'en':

                    $name = $row['productname_EN'];
                    break;
                case 'tw':

                    $name = $row['productname_TW'];
                    break;
                default:

                    $name = $row['productname'];
                    break;
            }
            ?>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center productbox productboxdetail">
                <a href="productdetail.php?cat=<?php echo $row['ID_danhmuc2']; ?>&amp;id=<?php echo $row['ID_product']; ?>" target="_self"><img src="images/product/<?php echo $row['productimg']; ?>" alt="Công Ty TNHH Thương Mại Lyan"></a>
                <h4><a href="productdetail.php?cat=<?php echo $row['ID_danhmuc2']; ?>&amp;id=<?php echo $row['ID_product']; ?>" target="_self"><?php echo $name; ?></a></h4>

        <?php if ($id_account): ?>
                    <p><?php echo isset($arrPrice[$row['ID_product']]) ? $formatPrice->format($arrPrice[$row['ID_product']]) : ''; ?></p>
                <?php else: ?>
                    <?php if (!$row['is_hidden_price']): ?>
                        <p><?php echo isset($arrPrice[$row['ID_product']]) ? $formatPrice->format($arrPrice[$row['ID_product']]) : $formatPrice->format($row['productprice']); ?></p>
                    <?php endif; ?>
                <?php endif; ?>


                <p><a href="javascript:void(0);" class="btn btn-info btn-payment-cart" role="button">Thanh toán</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" target="_self" class="btn btn-info btn-add-cart" data-id='<?php echo $row['ID_product']; ?>' data-is-type-menubar2="1" data-type-menubar2="<?php echo $row['ID_danhmuc2']; ?>">Thêm giỏ hàng</a></p>
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