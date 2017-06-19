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

mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
$query_rs_news_lh = "SELECT ID_news, newstitle, newstitle_EN, shortdes, shortdes_EN, newsimg, newsapproval, ID_menubar1, ID_menubar2 FROM news WHERE newsapproval = 1 AND ID_menubar1=4 AND ID_menubar2=9 ORDER BY newsdate DESC";
$rs_news_lh = mysql_query($query_rs_news_lh, $cnn_hoaly) or die(mysql_error());
$row_rs_news_lh = mysql_fetch_assoc($rs_news_lh);
$totalRows_rs_news_lh = mysql_num_rows($rs_news_lh);
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
                <img src="images/dao-tao-1920x250.jpg" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive">
            </div> <!-- end container-->
        </div> <!-- end slideshow-->
        <div class="page_news">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 co-sm-12 col-md-8 col-lg-8">

                        <?php do { ?>
                            <div class="row box_news2" data-sb="fadeInUp">
                                <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                    <a href="page_newsdetail.php?cat=<?php echo $row_rs_news_lh['ID_menubar1']; ?>&id=<?php echo $row_rs_news_lh['ID_news']; ?>" target="_self"><img src="images/news/<?php echo $row_rs_news_lh['newsimg']; ?>" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive"></a>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                                    <h4><a href="page_newsdetail.php?cat=<?php echo $row_rs_news_lh['ID_menubar1']; ?>&id=<?php echo $row_rs_news_lh['ID_news']; ?>" target="_self"><?php echo $row_rs_news_lh['newstitle']; ?></a></h4>
                                    <span class="line3"></span>
                                    <p><?php echo $row_rs_news_lh['shortdes']; ?></p>
                                    <p><a href="page_newsdetail.php?cat=<?php echo $row_rs_news_lh['ID_menubar1']; ?>&id=<?php echo $row_rs_news_lh['ID_news']; ?>" target="_self">Chi tiết <i class="fa fa-chevron-right" aria-hidden="true"></i></a></p>
                                </div> 
                            </div> <!-- row box_news2-->
                        <?php } while ($row_rs_news_lh = mysql_fetch_assoc($rs_news_lh)); ?>
                    </div> <!-- end col-->
                    <!--<article class="hidden-xs hidden-sm col-md-4 col-lg-4" data-sb="fadeInUp">-->
                        <img src="images/khoa-hoc-lich-hoc-280x360.jpg" alt="Công Ty TNHH Thương Mại Lyan" id="banner-scroll" class="img-responsive"> 
                    <!--</article>--> 
                    <!-- end article-->
                </div> 
                <!-- end row-->
            </div> <!-- end container-->
        </div> <!-- end page_news-->
        <?php include("footer.php"); ?>
    </body>
</html>
<?php
mysql_free_result($rs_news_lh);
?>