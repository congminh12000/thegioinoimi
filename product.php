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
        <link rel="stylesheet" href="css/sweet-alert-2.min.css">
        <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link rel="icon" href="images/favicon.ico" type="image/ico" sizes="32x32">
        <script src="vendor/jquery.min.js" type="text/javascript"></script>
        <script src="vendor/bootstrap.js" type="text/javascript"></script>
        <script src="js/sweet-alert-2.min.js" type="text/javascript"></script>
        <script src="storybox/jquery.js"></script>
        <script src="storybox/story-box.min.js"></script>
        <link href="totop/style.css" rel="stylesheet" type="text/css">
        <script src="totop/scoll-to-top.js" type="text/javascript"></script>
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
        <div class="slideshow" data-sb="fadeInUp">
            <div class="container-fluid">
                <img src="images/san-pham-1920x250.jpg" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive">
            </div> <!-- end container-->
        </div> <!-- end slideshow-->
        <div class="product" data-sb="fadeInUp">
            <div class="container">

                <?php if (isset($_GET['cat'])): ?>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 productcategorybox">
                            <h4>Danh mục sản phẩm</h4>
                            <span class="line3"></span>
                            <?php include("inc_productcategory.php"); ?>
                        </div> <!-- end col category-->
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                            <?php include("inc_product.php"); ?>
                        </div> <!-- end col product side-->

                        <div class="col-xs-6 col-sm-6 col-xs-offset-3 col-sm-offset-3 col-md-9 col-lg-9">
                            <?php if ($results->total): ?>
                                <div class="paginator text-center">
                                    <?php echo $classPaginator->createLinks($links, 'pagination pagination-sm'); ?> 
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-xs-6 col-sm-6 col-xs-offset-3 col-sm-offset-3 col-md-9 col-lg-9">
                            <hr>

                            <h3>Sản phẩm liên quan</h3>
                            <span class="line3"></span>

                            <?php
                            $query = 'SELECT * FROM product WHERE ID_danhmuc2 != ' . $_GET['cat'] . ' ORDER BY RAND() LIMIT 3';
                            $rs_productrelative = mysql_query($query);

                            //get ID_product
                            while ($row = mysql_fetch_assoc($rs_productrelative)) {
                                $arrProdId[] = $row['ID_product'];

                                $arrProd[] = $row;
                            }

                            //price 
                            require_once ('includes/my/price.php');
                            $classPrice = new Price();
                            $arrPrice = $classPrice->priceMultiAccessLevel($arrProdId);

                            session_start();
                            $user = $_SESSION['user'];
                            $id_account = (int) $user['ID_account'];
                            ?>

                            <div class="product">
                                <?php
                                foreach ($arrProd as $row_rs_productrelative) {
                                    ?>
                                    <div class = "col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center productbox productboxdetail">
                                        <a href = "productdetail.php?cat=<?php echo $row_rs_productrelative['ID_danhmuc2']; ?>&id=<?php echo $row_rs_productrelative['ID_product']; ?>" target = "_self"><img src = "images/product/<?php echo $row_rs_productrelative['productimg']; ?>" alt = "Công Ty TNHH Thương Mại Lyan"></a>
                                        <h4><a href = "productdetail.php?cat=<?php echo $row_rs_productrelative['ID_danhmuc2']; ?>&id=<?php echo $row_rs_productrelative['ID_product']; ?>" target = "_self"><?php echo $row_rs_productrelative['productname']; ?>
                                            </a></h4>

                                        <?php if ($id_account): ?>
                                            <p><?php echo isset($arrPrice[$row_rs_productrelative['ID_product']]) ? $formatPrice->format($arrPrice[$row_rs_productrelative['ID_product']]) : ''; ?></p>
                                        <?php else: ?>
                                            <?php if (!$row_rs_productrelative['is_hidden_price']): ?>
                                                <p><?php echo isset($arrPrice[$row_rs_productrelative['ID_product']]) ? $formatPrice->format($arrPrice[$row_rs_productrelative['ID_product']]) : $formatPrice->format($row_rs_productrelative['productprice']); ?></p>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <a href="javascript:void(0);" target="_self" class="btn btn-info btn-add-cart" data-id='<?php echo $row_rs_productrelative['ID_product']; ?>' data-is-type-menubar2="1" data-type-menubar2="<?php echo $colname_rs_productrelative; ?>">Thêm giỏ hàng</a>&nbsp;&nbsp;&nbsp; <a href="javascript:void(0);" class="btn btn-info btn-payment-cart" role="button">Thanh toán</a>
                                    </div> <!-- end col -->
                                <?php }; ?>
                            </div>
                        </div>

                    </div> <!-- end row-->

                <?php else: ?>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?php include("inc_general_product.php"); ?>
                    </div> <!-- end col product side-->

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?php if ($results->total): ?>
                            <div class="paginator text-center">
                                <?php echo $classPaginator->createLinks($links, 'pagination pagination-sm'); ?> 
                            </div>
                        <?php endif; ?>
                    </div>

                <?php endif; ?>
            </div> <!-- end container-->
        </div> <!-- end intro-->
        <?php include("footer.php"); ?>
    </body>
</html>
