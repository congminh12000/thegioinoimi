<?php
require_once('Connections/cnn_hoaly.php');
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

session_start();
//unset($_SESSION['cart']);die;
$user = $_SESSION['user'];
$id_account = (int) $user['ID_account'];

if ($id_account == 0) {
    header('Location: dntgate.php');
}

$cart = $_SESSION['cart'][$id_account];

$nums = (int) $cart['nums'];

if ($nums) {
    //get price
    require_once ('includes/my/price.php');
    $classPrice = new Price();
    $arrProdCart = $classPrice->productCartToAccessLevel();

    //get type
    $strQuery = "SELECT * FROM type_menubar2 WHERE tm2_status = 1 AND tm2_deleted = 0";
    $query = mysql_query($strQuery);

    while ($row = mysql_fetch_assoc($query)) {
        $arrTypeMenubar2[$row['ID_type_menubar2']] = $row;
    }
}
//echo'<pre>';print_r($arrProdCart);die;
//format price
require_once('includes/my/format-price.php');
$formatPrice = new FormatPrice();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Công Ty TNHH Thương Mại Lyan</title>
        <meta name="title" content="Công Ty TNHH Thương Mại Lyan">
        <meta name="description" content="Công Ty TNHH Thương Mại Lyan">
        <meta name="keywords" content="Lyan, noi mi, nối mi, Hoa Ly, Hoa Lý">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="vendor/bootstrap.css">
        <link rel="stylesheet" href="vendor/font-awesome.css">
        <link rel="stylesheet" href="style-primary.css">
        <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link rel="icon" href="images/favicon.ico" type="image/ico" sizes="32x32">
        <script src="vendor/jquery.min.js" type="text/javascript"></script>
        <script src="vendor/bootstrap.js" type="text/javascript"></script>
        <script src="build/mediaelement-and-player.min.js"></script><!-- Audio/Video Player jQuery -->
        <script src="build/mep-feature-playlist.js"></script><!-- Playlist JavaSCript -->
        <link rel="stylesheet" href="css/progression-player.css" /><!-- Default Player Styles -->	
        <link rel="stylesheet" href="css/skin-default-dark.css" /><!-- Dark Skin -->
    </head>

    <body>
        <header class="top_header">
            <div class="container">
                <div class="row">
                    <?php include("header.php"); ?>
                </div><br> <!--end row-->
                <div class="row">
                    <div class="col-xs-12 co-sm-12 col-md-12 col-lg-12">
                        <?php include("menubar.php"); ?>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end container-->
        </header> <!-- end header-->
        <div class="slideshow">
            <div class="container-fluid">
                <img src="images/demo-banner.png" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive">
            </div> <!-- end container-->
        </div> <!-- end slideshow-->
        <div class="product">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 cartbox">
                        <h3>Giỏ hàng của khách hàng</h3>
                        <span class="line3"></span>
                        <div class="row cart-title">
                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center">
                                <b>Hình sản phẩm</b>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                                <b>Tên sản phẩm</b>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center">
                                <b>Loại</b>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center">
                                <b>Số lượng mua</b>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center">
                                <b>Thành tiền</b>
                            </div>
                        </div> <!-- end row  cart-title-->
                        <?php if ($nums): ?>

                            <?php
                            $priceTotal = 0;
                            foreach ($arrProdCart as $row):
                                $arrIDTypeMenubar2 = implode('-', $row['arr_ID_type_menubar2']);
                                $priceTotal += $row['qty_cart'] * $row['price_access_level'];
                                $sl = $row['qty_cart'];
                                $strTm2Name = '';
                                
                                foreach($row['arr_ID_type_menubar2'] as $id){
                                    
                                    $strTm2Name .= $arrTypeMenubar2[$id]['tm2_name'] . '<br>';
                                }
                                
                                ?>
                                <div class="row cart-product">
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                                        <img src="<?php echo 'images/product/' . $row['productimg']; ?>" alt="Công ty TNHH Thương mại Lyan" class="img-responsive"> 
                                        <button class="btn btn-warning btn-remove-prod" style="margin-top: 5px" data-id="<?php echo $row['ID_product']; ?>" data-type-menubar2="<?php echo $arrIDTypeMenubar2; ?>" data-price="<?php echo $row['price_access_level']; ?>">Xóa sản phẩm</button>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                                        <?php echo $row['productname']; ?>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center">
                                        <?php echo $strTm2Name; ?>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center">
                                        <input type="number" class="so-luong-sp" min='1' value="<?php echo $sl; ?>" />
                                        <button class="btn btn-success btn-update-sl" style="margin-top: 5px" data-id="<?php echo $row['ID_product']; ?>" data-type-menubar2="<?php echo $arrIDTypeMenubar2; ?>" data-price="<?php echo $row['price_access_level']; ?>">Cập nhật số lượng</button>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-center">
                                        <span class="total-price"><?php echo $formatPrice->format($row['price_access_level'] * $sl); ?></span>
                                    </div>
                                </div> <!-- end row  cart-product-->
                            <?php endforeach; ?>

                            <div class="row cart-total-price">
                                <div class="hidden-xs hidden-sm col-md-2 col-lg-2 text-center">
                                </div>
                                <div class="hidden-xs hidden-sm col-md-4 col-lg-4 text-center">
                                </div>
                                <div class="hidden-xs hidden-sm col-md-3 col-lg-3 text-center">
                                    <h4><b>THÀNH TIỀN</b></h4>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-center">
                                    <h4><b class="sum-total" data-price="<?php echo $priceTotal; ?>"><?php echo $formatPrice->format($priceTotal); ?></b></h4>
                                </div>
                            </div> <!-- end row cart-total-price-->
                            <form method="POST" action="cart_thanks.php">
                                <div class="row receiveinfo">
                                    <h3>Thông tin người nhận</h3>
                                    <span class="line3"></span>
                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

                                        <input type="text" name="fullname" placeholder="Họ tên" value="<?php echo $user['fullname']; ?>"><br>
                                        <input type="text" name="phone" placeholder="Điện thoại" value="<?php echo $user['phone']; ?>"><br>                  
                                        <input type="text" name="email" placeholder="Email" value="<?php echo $user['email']; ?>" width="350px"><br>
                                        <input type="text" name="address" placeholder="Địa chỉ nhận hàng" value="<?php echo $user['address']; ?>"><br> 
                                        <textarea rows="4" cols="50" name="note" placeholder="Ghi chú"></textarea><br>

                                    </div>
                                </div> <!-- end row receive-info-->

                                <div class="row receiveinfo">
                                    <h3>Thanh toán</h3>
                                    <span class="line3"></span>
                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                        <input type="radio" name="payment" value="cash" checked=""> Bằng tiền mặt khi nhận hàng (COD)
                                        <input type="radio" name="payment" value="bank"> Chuyển khoản
                                    </div>
                                </div> <!-- end row receive-info-->

                                <button type="submit" class="btn btn-info">Thanh toán</button>
                            </form>
                        <?php else: ?>
                            <p class="text-center">Không có sản phẩm nào trong giỏ</p>
                        <?php endif; ?>
                    </div> <!-- end col -->
                    <div class="hidden-xs hidden-sm col-md-3 col-lg-3">
                        <img src="images/advertising-280x360.png" class="img-responsive">
                    </div> 
                    <!-- end col -->
                </div> <!-- end row-->
            </div> <!-- end container-->
        </div> <!-- end intro-->
        <?php include("footer.php"); ?>
    </body>
</html>
