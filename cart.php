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
                <?php include("header.php");?>
            </div><br> <!--end row-->
        	<div class="row">
                <div class="col-xs-12 co-sm-12 col-md-12 col-lg-12">
                	<?php include("menubar.php");?>
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
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-center">
                        	<b>Số lượng mua</b>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-center">
                        	<b>Thành tiền</b>
                        </div>
                    </div> <!-- end row  cart-title-->
                <div class="row cart-product">
                    	<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                      		<img src="images/san-pham-1.png" alt="Công ty TNHH Thương mại Lyan" class="img-responsive"> 
                      	</div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                        	HH01 - Keo nối mi
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-center">
                        	1
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-center">
                        	58000đ
                        </div>
                    </div> <!-- end row  cart-product-->
                    <div class="row cart-product">
                    	<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                      		<img src="images/san-pham-1.png" alt="Công ty TNHH Thương mại Lyan" class="img-responsive">
                      	</div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                        	HH02 - Keo dán mi
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-center">
                        	1
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-center">
                        	108000đ
                        </div>
                    </div> <!-- end row cart-product-->
                    <div class="row cart-total-price">
                    	<div class="hidden-xs hidden-sm col-md-2 col-lg-2 text-center">
                      	</div>
                        <div class="hidden-xs hidden-sm col-md-4 col-lg-4 text-center">
                      	</div>
                        <div class="hidden-xs hidden-sm col-md-3 col-lg-3 text-center">
                        	<h4><b>THÀNH TIỀN</b></h4>
                      	</div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-center">
                        	<h4><b>108000đ</b></h4>
                        </div>
                    </div> <!-- end row cart-total-price-->
                    <div class="row receiveinfo">
                    	<h3>Thông tin người nhận</h3>
                    	<span class="line3"></span>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        	<form>
                                <input type="text" name="fullname" placeholder="Họ tên"><br>
                                <input type="text" name="phoneumber" placeholder="Điện thoại"><br>                  
                                <input type="text" name="email" placeholder="Email" width="350px"><br>
                                <input type="text" name="address" placeholder="Địa chỉ nhận hàng"><br> 
                                <textarea rows="4" cols="50" placeholder="Ghi chú"></textarea><br>
                                <button type="button" class="btn btn-info">Thanh toán</button>
                    		</form>
                        </div>
                    </div> <!-- end row receive-info-->
                </div> <!-- end col -->
                <div class="hidden-xs hidden-sm col-md-3 col-lg-3">
       		    	<img src="images/advertising-280x360.png" class="img-responsive">
                </div> 
                <!-- end col -->
            </div> <!-- end row-->
        </div> <!-- end container-->
    </div> <!-- end intro-->
    <?php include("footer.php");?>
</body>
</html>
