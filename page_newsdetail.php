<?php require_once('Connections/cnn_hoaly.php'); ?>
<?php
// Load the common classes
require_once('includes/common/KT_common.php');

// Load the tNG classes
require_once('includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("");

// Make unified connection variable
$conn_cnn_hoaly = new KT_connection($cnn_hoaly, $database_cnn_hoaly);

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

$KTColParam1_rs_pagenewsdetail = "1";
if (isset($_GET["id"])) {
    $KTColParam1_rs_pagenewsdetail = $_GET["id"];
}
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
$query_rs_pagenewsdetail = sprintf("SELECT menubar1.ID_menubar1, menubar1.menubar1name, news.ID_news, news.newstitle, news.newstitle_EN, news.shortdes, news.shortdes_EN, news.newsimg, news.newscontent, news.newscontent_EN, news.newsview, menubar1.menubar1name_en FROM (news LEFT JOIN menubar1 ON menubar1.ID_menubar1=news.ID_menubar1) WHERE news.ID_news=%s ", GetSQLValueString($KTColParam1_rs_pagenewsdetail, "int"));
$rs_pagenewsdetail = mysql_query($query_rs_pagenewsdetail, $cnn_hoaly) or die(mysql_error());
$row_rs_pagenewsdetail = mysql_fetch_assoc($rs_pagenewsdetail);
$totalRows_rs_pagenewsdetail = mysql_num_rows($rs_pagenewsdetail);

$colname_rs_bannerdetail = "-1";
if (isset($_GET['cat'])) {
    $colname_rs_bannerdetail = $_GET['cat'];
}
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
$query_rs_bannerdetail = sprintf("SELECT ID_bannerdetail, bannerdetailimg, ID_menubar1 FROM bannerdetail WHERE ID_menubar1 = %s", GetSQLValueString($colname_rs_bannerdetail, "int"));
$rs_bannerdetail = mysql_query($query_rs_bannerdetail, $cnn_hoaly) or die(mysql_error());
$row_rs_bannerdetail = mysql_fetch_assoc($rs_bannerdetail);
$totalRows_rs_bannerdetail = mysql_num_rows($rs_bannerdetail);

// Make a custom transaction instance
$customTransaction = new tNG_custom($conn_cnn_hoaly);
$tNGs->addTransaction($customTransaction);
// Register triggers
$customTransaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "VALUE", "1");
// Set custom transaction SQL
$customTransaction->setSQL("UPDATE news SET newsview = newsview + 1 WHERE ID_news={GET.id}");
// Add columns
// End of custom transaction instance
// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscustom = $tNGs->getRecordset("custom");
$row_rscustom = mysql_fetch_assoc($rscustom);
$totalRows_rscustom = mysql_num_rows($rscustom);
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
        <link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
        <script src="includes/common/js/base.js" type="text/javascript"></script>
        <script src="includes/common/js/utility.js" type="text/javascript"></script>
        <script src="includes/skins/style.js" type="text/javascript"></script>
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

        <?php
        switch ($lang) {
            case 'vn':

                $title = $row_rs_pagenewsdetail['newstitle'];
                $shortdes = $row_rs_pagenewsdetail['shortdes'];
                $newscontent = $row_rs_pagenewsdetail['newscontent'];
                break;
            case 'en':

                $title = $row_rs_pagenewsdetail['newstitle_EN'];
                $shortdes = $row_rs_pagenewsdetail['shortdes_EN'];
                $newscontent = $row_rs_pagenewsdetail['newscontent_EN'];
                break;
            case 'tw':

                $title = $row_rs_pagenewsdetail['newstitle_TW'];
                $shortdes = $row_rs_pagenewsdetail['shortdes_TW'];
                $newscontent = $row_rs_pagenewsdetail['newscontent_TW'];
                break;
            default:

                $title = $row_rs_pagenewsdetail['newstitle'];
                $shortdes = $row_rs_pagenewsdetail['shortdes'];
                $newscontent = $row_rs_pagenewsdetail['newscontent'];
                break;
        }
        ?>

        <div class="slideshow">
            <div class="container-fluid">
                <img src="images/banner/<?php echo $row_rs_bannerdetail['bannerdetailimg']; ?>" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive">
            </div> <!-- end container-->
        </div> <!-- end slideshow-->
        <div class="pagenewsdetail">
            <div class="container">
                <div class="row">
                    <div class="newsdetailbox">
                        <div class="row">
                            <div class="col-xs-12 co-sm-12 col-md-4 col-lg-4">
                                <img src="images/news/<?php echo $row_rs_pagenewsdetail['newsimg']; ?>" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive">
                            </div> <!-- end col-->
                            <div class="col-xs-12 co-sm-12 col-md-8 col-lg-8">
                                <h3><?php echo $row_rs_pagenewsdetail['menubar1name']; ?></h3>
                                <span class="line3"></span>
                                <h4><?php echo $title; ?></h4>
                                <p><?php echo $shortdes; ?></p>
                            </div> <!-- end col-->
                        </div> <!-- end row-->
                        <div class="row">
                            <div class="col-xs-12 co-sm-12 col-md-12 col-lg-12 newsdetail">
                                <span class="line4"></span>
                                <?php echo $newscontent; ?> 
                            </div> <!-- end col-->
                        </div> <!-- end row-->
                    </div> <!-- end newsdetailbox-->
                </div> <!-- end row-->
            </div> <!-- end container-->
            <?php include("page_newsrelative.php"); ?>
        </div> <!-- end pagenewsdetail-->
        <?php include("footer.php"); ?>
    </body>
</html>
<?php
mysql_free_result($rs_pagenewsdetail);

mysql_free_result($rs_bannerdetail);
?>