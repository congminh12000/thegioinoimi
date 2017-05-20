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
            	<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 productboxdetail">
                   <?php include("inc_productdetail.php");?> 
                    <div class="row">
                    	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 boxproductcaption">
                            <h3>SẢN PHẨM LIÊN QUAN</h3>
                            <span class="line3"></span>
                            <?php include("inc_productrelative.php");?>
                        </div> <!-- end col -->
                    </div> <!-- end row productrelative-->
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
