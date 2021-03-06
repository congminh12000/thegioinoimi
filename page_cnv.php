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
$query_rs_cnv_page = "SELECT news.ID_news, news.newstitle, news.newstitle_EN, news.shortdes, news.shortdes_EN, news.newsimg, news.newsapproval, news.newsdate, menubar1.ID_menubar1, menubar1.menubar1name, menubar1.menubar1name_en FROM (news LEFT JOIN menubar1 ON menubar1.ID_menubar1=news.ID_menubar1) WHERE news.newsapproval=1  AND menubar1.ID_menubar1=5 ORDER BY news.newsdate DESC ";

//class paginator
require_once('includes/my/paginator.php');

$classPaginator = new Paginator($query_rs_cnv_page);

$limit = ( isset($_GET['limit']) ) ? $_GET['limit'] : 6;
$page = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
$links = ( isset($_GET['links']) ) ? $_GET['links'] : 1;

$results = $classPaginator->getData($limit, $page);
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
                </div><br>
                <div class="row">
                    <div class="col-xs-12 co-sm-12 col-md-12 col-lg-12">
                        <?php include("menubar.php"); ?>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end container-->
        </header> <!-- end header-->
        <div class="slideshow">
            <div class="container-fluid">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                  </ol>

                  <!-- Wrapper for slides -->
                  <div class="carousel-inner">
                    <div class="item active">
                      <img src="images/cay-nhip-vang-1920x250.jpg" alt="Công Ty TNHH Thương Mại Lyan">
                    </div>

                    <div class="item">
                      <img src="images/cay-nhip-vang-1920x250.jpg" alt="Công Ty TNHH Thương Mại Lyan">
                    </div>

                    <div class="item">
                      <img src="images/cay-nhip-vang-1920x250.jpg" alt="Công Ty TNHH Thương Mại Lyan">
                    </div>
                  </div>

                  <!-- Left and right controls -->
                  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="icon-left-right"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="icon-left-right"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
            </div> <!-- end container-->
        </div> <!-- end slideshow-->
        <div class="page_news">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 co-sm-12 col-md-8 col-lg-8">
                        <?php
                        if ($results->total):
                            $stt = 1;
                            foreach ($results->data as $row):

                                switch ($lang) {
                                    case 'vn':

                                        $title = $row['newstitle'];
                                        $shortdes = $row['shortdes'];
                                        break;
                                    case 'en':

                                        $title = $row['newstitle_EN'];
                                        $shortdes = $row['shortdes_EN'];
                                        break;
                                    case 'tw':

                                        $title = $row['newstitle_TW'];
                                        $shortdes = $row['shortdes_TW'];
                                        break;
                                    default:

                                        $title = $row['newstitle'];
                                        $shortdes = $row['shortdes'];
                                        break;
                                }
                                ?>
                                <div class="row box_news2">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <a href="page_newsdetail.php?cat=<?php echo $row['ID_menubar1']; ?>&id=<?php echo $row['ID_news']; ?>" target="_self"><img src="images/news/<?php echo $row['newsimg']; ?>" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive"></a>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                                        <h4><a href="page_newsdetail.php?cat=<?php echo $row['ID_menubar1']; ?>&id=<?php echo $row['ID_news']; ?>" target="_self"><?php echo $title; ?></a></h4>
                                        <span class="line3"></span>
                                        <p><?php echo $shortdes; ?></p>
                                        <p><a href="page_newsdetail.php?cat=<?php echo $row['ID_menubar1']; ?>&id=<?php echo $row['ID_news']; ?>" target="_self">Chi tiết <i class="fa fa-chevron-right" aria-hidden="true"></i></a></p>
                                    </div> 
                                </div> <!-- row box_news2-->
                                <?php
                            endforeach;
                        else:
                            ?>
                            Không có dữ liệu nào !
                        <?php
                        endif;
                        ?>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?php if ($results->total): ?>
                            <div class="paginator text-center">
                                <?php echo $classPaginator->createLinks($links, 'pagination pagination-sm'); ?> 
                            </div>
                        <?php endif; ?>
                        </div>

                    </div> <!-- end col-->
                    <!--<article class="hidden-xs hidden-sm col-md-4 col-lg-4">-->
                        <img src="images/cay-nhip-vang-280x360.jpg" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive" id="banner-scroll"> 
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
mysql_free_result($rs_cnv_page);
?>