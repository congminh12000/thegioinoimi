<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Công Ty TNHH Thương Mại Lyan</title>
        <meta name="title" content="Công Ty TNHH Thương Mại Lyan">
        <meta name="description" content="Công Ty TNHH Thương Mại Lyan">
        <meta name="keywords" content="Lyan, noi mi, nối mi, Hoa Ly, Hoa Lý">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://thegioinoimi.dev/vendor/bootstrap.css">
        <link rel="stylesheet" href="http://thegioinoimi.dev/vendor/font-awesome.css">
        <link rel="stylesheet" href="http://thegioinoimi.dev/style-primary.css">
        <link rel="stylesheet" href="http://thegioinoimi.dev/vendor/font-awesome/css/font-awesome.min.css">
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

        <?php
        require_once('Connections/cnn_hoaly.php');
        mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

        session_start();
        $user = $_SESSION['user'];
        $id_account = (int) $user['ID_account'];

        if ($id_account == 0) {
            header('Location: dntgate.php');
        }

//save order
        if ($_POST) {
            $fullname = trim($_POST['fullname']);
            $phone = trim($_POST['phone']);
            $email = trim($_POST['email']);
            $address = trim($_POST['address']);
            $note = $_POST['note'];
            $payment = trim($_POST['payment']);

            if ($payment == '') {
                header('Location: cart.php');
            }

            $cart = $_SESSION['cart'][$id_account];

            if ($cart) {
                //get price access level
                require_once ('includes/my/price.php');
                $classPrice = new Price();
                $arrProdCart = $classPrice->productCartToAccessLevel();

                $grandTotalOrder = 0;
//    echo '<pre>';print_r($arrProdCart);die;  
                foreach ($arrProdCart as $prod) {
                    $grandTotalOrder += $prod['price_access_level'] * $prod['qty_cart'];
                }

                //insert orders
                $strKeys = '`status`, total_qty, grand_total, receiver_name, receiver_phone, receiver_email, receiver_address, receiver_note, buyer_id';
                $strValuesOrder = "'pending', '{$cart['nums']}', '{$grandTotalOrder}', '{$fullname}', '{$phone}', '{$email}', '{$address}', '{$note}', '{$id_account}'";

                $strQuery = "INSERT INTO orders({$strKeys}) VALUES({$strValuesOrder})";
                mysql_query($strQuery);

                $orderId = mysql_insert_id();

                //insert payment
                $strKeys = 'order_id, type';
                $strValuesOrder = "'{$orderId}', '{$payment}'";

                $strQuery = "INSERT INTO order_payment({$strKeys}) VALUES({$strValuesOrder})";
                mysql_query($strQuery);

                //insert order_item
                $strKeys = 'ID_order, qty_ordered, ID_product, grand_total, price_access_level, ID_type_menubar2';

                $strValuesItem = '';
                foreach ($arrProdCart as $prod) {
                    $grandTotalItem = $prod['price_access_level'] * $prod['qty_cart'];
                    $jsonType = implode(',', $prod['arr_ID_type_menubar2']);

                    $strValuesItem .= "('{$orderId}', '{$prod['qty_cart']}', '{$prod['ID_product']}', '{$grandTotalItem}', {$prod['price_access_level']}, '{$jsonType}'),";
                }
                $strValuesItem = rtrim($strValuesItem, ',');

                $strQuery = "INSERT INTO order_item({$strKeys}) VALUES{$strValuesItem}";

                mysql_query($strQuery);

                //format price
                require_once('includes/my/format-price.php');
                $formatPrice = new FormatPrice();

                //send mail
                $to = 'minh.phan@sstechvn.com';
                $from = 'congminh12000@gmail.com';
                $subject = "Thông báo đơn hàng Hoa Ly's";

                $style = '<head>
                    <style>
.bill .box-bill {
                border: 1px solid #292929;
                padding: 15px;
                border-radius: 8px;
                margin-top: 30px;
                margin-bottom: 15px;
            }
            .h5{
                font-size: 14px;
                margin-top: 10px;
    margin-bottom: 10px;
        font-family: inherit;
    font-weight: 500;
    line-height: 1.1;
    color: inherit;
                }
                
.line4 {
    display: block;
    width: 98%px;
    border-top: 1px solid #c3c3c3;
    margin-top: 15px;
    margin-bottom: 20px;
}

h4{
    font-size: 18px;
        margin-top: 10px;
    margin-bottom: 10px;
    font-family: inherit;
    font-weight: 500;
    line-height: 1.1;
    color: inherit;
}

.bill .btn-info {
    color: #ffffff;
    background-color: #2f0a44;
    border: none;
    padding: 4px 10px 4px 10px;
    margin-bottom: 10px;
}
.btn-info {
    color: #fff;
    background-color: #5bc0de;
    border-color: #46b8da;
}
.btn{
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
}
a {
    text-decoration: none;
}
.col-lg-2 {
    width: 16.66666667%;
    float: left;
}
.text-center {
    text-align: center;
}
.col-lg-4 {
    width: 33.33333333%;
        float: left;
}
</style>
</head>
';

                $body = '<html>' . $style . '<body><div class="bill">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 co-sm-12 col-md-12 col-lg-12 text-center">
                        <img src="http://thegioinoimi.dev/images/logo.png" width="120px">
                    </div> <!-- end col-->
                    <div class="col-xs-12 co-sm-12 col-md-6 col-lg-6 col-md-push-3">
                        <div class="box-bill">
                            <h5><b><i class="fa fa-calendar" aria-hidden="true"></i> Thông tin đơn hàng của khách hàng:</b></h5>
                            <span class="line4"></span>
                            <h4>Tài khoản: <b>' . $user['username'] . '</b> - đặt vào lúc <b>' . date('H:i d/m/Y') . '</b></h4>
                            <h5>Họ tên người nhận: <b>' . $fullname . '</b></h5>
                            <h5>Điện thoại: <b>' . $phone . '</b> - Email: <b>' . $email . '</b></h5>
                            <h5>Địa chỉ nhận hàng: <b>' . $address . '</b></h5>
                            <h5>Tổng tiền: <b>' . $formatPrice->format($grandTotalOrder) . '</b></h5>
                        </div>
                        <div class="box-bill">
                            <h5><b><i class="fa fa-shopping-cart" aria-hidden="true"></i> Chi tiết đơn hàng:</b></h5>
                            <span class="line4"></span>

                            <div class="row" style="margin-bottom: 10px">
                                <div class="col-xs-12 co-sm-12 col-md-2 col-lg-2 text-center">
                                    <b>STT</b>
                                </div> <!-- end col--> 
                                <div class="col-xs-12 co-sm-12 col-md-4 col-lg-4 text-center">
                                    <b>Tên sản phẩm</b>
                                </div> <!-- end col-->
                                <div class="col-xs-12 co-sm-12 col-md-2 col-lg-2 text-center">
                                    <b>Số lượng</b>
                                </div> <!-- end col-->
                                <div class="col-xs-12 co-sm-12 col-md-2 col-lg-2 text-center">
                                    <b>Đơn giá</b>
                                </div> <!-- end col-->
                                <div class="col-xs-12 co-sm-12 col-md-2 col-lg-2 text-center">
                                    <b>Thành tiền</b>
                                </div> <!-- end col--><br>
                            </div> <!-- end row hàng sp-->';

                $stt = 1;
                foreach ($arrProdCart as $prod) {
                    $body .= '<div class = "row">
        <div class = "col-xs-12 co-sm-12 col-md-2 col-lg-2 text-center">
        <b>' . $stt . '</b>
        </div> <!-- end col--> 
        <div class="col-xs-12 co-sm-12 col-md-4 col-lg-4 text-center">
            <b>' . $prod['productname'] . '</b>
        </div> <!-- end col-->
        <div class="col-xs-12 co-sm-12 col-md-2 col-lg-2 text-center">
            <b>' . $prod['qty_cart'] . '</b>
        </div> <!-- end col-->
        <div class="col-xs-12 co-sm-12 col-md-2 col-lg-2 text-center">
            <b>' . $formatPrice->format($prod['price_access_level']) . '</b>
        </div> <!-- end col-->
        <div class="col-xs-12 co-sm-12 col-md-2 col-lg-2 text-center">
            <b>' . $formatPrice->format($prod['price_access_level'] * $prod['qty_cart']) . '</b>
        </div> <!-- end col--><br>
        </div> <!-- end row hàng sp-->';

                    $stt++;
                }

                $body .= '<br></div>
        <a href = "' . $_SERVER['HTTP_ORIGIN'] . '/admincp/list_order.php' . '" class = "btn btn-info" role = "button">Xử lý đơn hàng</a>
        </div>
        </div> <!--end col-->
        </div> <!--end row-->
        </div> <!--end container-->
        </div> <!--end bill-->
        </body></html>';

                $header = "From: {$from} \r\n";
                $header .= "MIME-Version: 1.0 \r\n";
                $header .= "Content-Type: text/html; charset=ISO-8859-1 \r\n";

                mail($to, $subject, $body, $header);
            }
        }

//remove session cart
        unset($_SESSION['cart'][$id_account]);
        ?>


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
        <div class="intro">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-push-2 text-center">
                        <h2>CẢM ƠN QUÝ KHÁCH TIN TƯỞNG & CHỌN MUA SẢN PHẨM<br>TẠI HOA LY'S EYELASHES</h3>
                            <a href = "index.php" class = "btn btn-info" role = "button">TRANG CHỦ</a>
                    </div> <!--end col-->
                </div> <!--end row-->
            </div> <!--end container-->
        </div> <!--end intro-->
        <?php include("footer.php");
        ?>
    </body>
</html>
