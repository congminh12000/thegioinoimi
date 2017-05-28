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
        <link rel="stylesheet" href="css/sweet-alert-2.min.css">
        <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link rel="icon" href="images/favicon.ico" type="image/ico" sizes="32x32">
        <script src="vendor/jquery.min.js" type="text/javascript"></script>
        <script src="vendor/bootstrap.js" type="text/javascript"></script>
        <link rel="stylesheet" href="everslider/css/everslider.css">
        <link rel="stylesheet" href="everslider/css/everslider-custom.css">
        <script src="storybox/jquery.js"></script>
        <script src="js/sweet-alert-2.min.js"></script>
        <script src="storybox/story-box.min.js"></script>
        <link href="totop/style.css" rel="stylesheet" type="text/css">
        <script src="totop/scoll-to-top.js" type="text/javascript"></script>
        <!-- JavaScript -->
        <script type="text/javascript" src="everslider/js/jquery.easing.1.3.js"></script>
        <script type="text/javascript" src="everslider/js/jquery.mousewheel.js"></script>
        <script type="text/javascript" src="everslider/js/jquery.everslider.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {


                /* Fullwidth slider */
                $('#fullwidth_slider').everslider({
                    mode: 'carousel',
                    moveSlides: 1,
                    slideEasing: 'easeInOutCubic',
                    slideDuration: 700,
                    navigation: true,
                    keyboard: true,
                    nextNav: '<span class="alt-arrow">Next</span>',
                    prevNav: '<span class="alt-arrow">Next</span>',
                    ticker: false,
                    tickerAutoStart: true,
                    tickerHover: true,
                    tickerTimeout: 2000
                });

            });
        </script>  
    </head>

    <body>
        <?php require_once('Connections/cnn_hoaly.php'); ?>
        <header class="top_header">
            <div class="container">
                <div class="row">
                    <?php include("header.php"); ?>
                </div><br>
                <div class="row">
                    <div class="col-xs-12 co-sm-12 col-md-12 col-lg-12">
                        <?php include("menubar.php"); ?>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end container-->
        </header> <!-- end header-->
        <div class="slideshow" data-sb="fadeInUp">
            <div class="container-fluid">
                <div id="myCarousel1" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel1" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel1" data-slide-to="1"></li>
                        <li data-target="#myCarousel1" data-slide-to="2"></li>
                        <li data-target="#myCarousel1" data-slide-to="3"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="images/1_giangvien.jpg" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive">
                        </div>

                        <div class="item">
                            <img src="images/2_orasalon.jpg" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive">
                        </div>

                        <div class="item">
                            <img src="images/3_sanpham.jpg" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive">
                        </div>

                        <div class="item">
                            <img src="images/4_keonoimi.jpg" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive">
                        </div>
                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel1" data-slide="prev">
                        <span class="icon-left-right"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel1" data-slide="next">
                        <span class="icon-left-right"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div> <!-- end container-->
        </div> <!-- end slideshow-->
        <div class="body1" data-sb="fadeInUp">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <img src="images/box-1.jpg" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive">
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <img src="images/box-2.jpg" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive">
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <img src="images/box-3.jpg" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive">
                    </div>
                </div> <!-- end row-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center icon_line">
                    <img src="images/icon-line.png">
                </div><!-- end line icon-->
            </div> <!-- end container-->
        </div> <!-- end body1-->
        <div class="body2">
            <div class="container">
                <?php include("inc_gvkh_videoclip.php"); ?>
            </div> <!-- end container-->
        </div> <!-- end body2-->  
        <div class="body3" data-sb="fadeInUp">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <h3><img src="images/icon-lis.png"> SẢN PHẨM</h3>
                        <span class="line1"></span>
                    </div>
                </div> <!-- end row-->
                <div class="row">
                    <div id="fullwidth_slider" class="everslider fullwidth-slider">
                        <ul class="es-slides product">
                            
                            <?php include("inc_productindex.php"); ?>

                        </ul>
                    </div> <!-- end everslider -->
                </div><!-- end row-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center icon_line">
                    <img src="images/icon-line.png">
                </div><!-- end line icon-->
            </div> <!-- end container--> 
        </div> <!-- end body3-->
        <div class="body4" data-sb="fadeInUp">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="row">                    
                            <h3 class="text-center"><img src="images/icon-lis.png"> SỰ KIỆN</h3>
                            <span class="line1"></span>
                        </div> <!-- end row-->
                        <?php include("index_sk.php"); ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="row">
                            <h3 class="text-center"><img src="images/icon-lis.png"> KIẾN THỨC CHUYÊN MÔN</h3>
                            <span class="line1"></span>
                        </div> <!-- end row-->
                        <?php include("index_ktcm.php"); ?>
                    </div>
                </div> <!-- end row-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center icon_line">
                    <img src="images/icon-line.png">
                </div><!-- end line icon-->
            </div> <!-- end container-->
        </div> <!-- end body4-->
        <div class="body5" data-sb="fadeInUp">
            <div class="container-fluid">
                <div class="row">
                    <img src="images/vedep.png" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive">
                </div> <!-- end row-->
            </div> <!-- end container-->
        </div> <!-- end body5-->
        <div class="body6" data-sb="fadeInUp">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <h3>HỌC VIÊN NHẬN XÉT</h3>
                        <span class="line1"></span>
                    </div>
                </div> <!-- end row-->
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <img src="images/avatar-comment-1.png">
                        </div>
                        <blockquote class="quote-card">
                            <p>
                                Chương trình học ở đây rất linh hoạt, giảng viên nhiệt tình. Thật sự cảm ơn HoaLy's rất nhiều. 
                            </p>

                            <cite>
                                - Lucy Nguyễn
                            </cite>
                        </blockquote>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                            <img src="images/avatar-comment-2.png">
                        </div>
                        <blockquote class="quote-card">
                            <p>
                                Mình vừa kết thúc khóa học tại Hoa Ly's. Nói chung rất hài lòng. 
                            </p>

                            <cite>
                                - Tracy Huỳnh
                            </cite>
                        </blockquote>
                    </div>
                </div> <!-- end row-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center icon_line">
                    <img src="images/icon-line.png">
                </div><!-- end line icon-->
            </div> <!-- end container-->
        </div> <!-- end body6-->
        <?php include("footer.php"); ?>
    </body>
</html>
