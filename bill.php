<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Thông báo đơn hàng Hoa Ly's</title>
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
    </head>

    <body>
        <?php
        //format price
        require_once('includes/my/format-price.php');
        $formatPrice = new FormatPrice();
        ?>
        <div class="bill">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 co-sm-12 col-md-12 col-lg-12 text-center">
                        <img src="images/logo.png" width="120px">
                    </div> <!-- end col-->
                    <div class="col-xs-12 co-sm-12 col-md-6 col-lg-6 col-md-push-3">
                        <div class="box-bill">
                            <h5><b><i class="fa fa-calendar" aria-hidden="true"></i> Thông tin đơn hàng của khách hàng:</b></h5>
                            <span class="line4"></span>
                            <h4>Tài khoản: <b><?php echo $user['username']; ?></b> - đặt vào lúc <b><?php echo date('H:i d/m/Y'); ?></b></h4>
                            <h5>Họ tên người nhận: <b><?php echo $fullname; ?></b></h5>
                            <h5>Điện thoại: <b><?php echo $phone; ?></b> - Email: <b><?php echo $email; ?></b></h5>
                            <h5>Địa chỉ nhận hàng: <b><?php echo $address; ?></b></h5>
                            <h5>Tổng tiền: <b><?php echo $formatPrice->format($grandTotal); ?></b></h5>
                        </div>
                        <div class="box-bill">
                            <h5><b><i class="fa fa-shopping-cart" aria-hidden="true"></i> Chi tiết đơn hàng:</b></h5>
                            <span class="line4"></span>

                            <div class="row">
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
                            </div> <!-- end row hàng sp-->

                            <?php
                            $stt = 1;
                            foreach ($arrProdCart as $prod):
                                ?>
                                <div class="row">
                                    <div class="col-xs-12 co-sm-12 col-md-2 col-lg-2 text-center">
                                        <b><?php echo $stt; ?></b>
                                    </div> <!-- end col--> 
                                    <div class="col-xs-12 co-sm-12 col-md-4 col-lg-4 text-center">
                                        <b><?php echo $prod['productname']; ?></b>
                                    </div> <!-- end col-->
                                    <div class="col-xs-12 co-sm-12 col-md-2 col-lg-2 text-center">
                                        <b><?php echo $prod['qty_cart']; ?></b>
                                    </div> <!-- end col-->
                                    <div class="col-xs-12 co-sm-12 col-md-2 col-lg-2 text-center">
                                        <b><?php echo $formatPrice->format($prod['price_access_level']); ?></b>
                                    </div> <!-- end col-->
                                    <div class="col-xs-12 co-sm-12 col-md-2 col-lg-2 text-center">
                                        <b><?php echo $for ?></b>
                                    </div> <!-- end col--><br>
                                </div> <!-- end row hàng sp-->
                                <?php $stt++;
                            endforeach;
                            ?>
                            <br></div>
                        <a href="dntgate.php" class="btn btn-info" role="button">Xử lý đơn hàng</a>
                    </div>
                </div> <!-- end col-->
            </div> <!-- end row-->
        </div> <!-- end container-->
    </div> <!-- end bill-->
</body>
</html>