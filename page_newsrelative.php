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

$colname_rs_page_newsrelative = "7";
if (isset($_GET['cat'])) {
    $colname_rs_page_newsrelative = $_GET['cat'];
}
$colname2_rs_page_newsrelative = "1";
if (isset($_GET['id'])) {
    $colname2_rs_page_newsrelative = $_GET['id'];
}
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
$query_rs_page_newsrelative = sprintf("SELECT ID_news, newstitle, newstitle_EN, shortdes, shortdes_EN, newsimg, newsapproval, newsdate, ID_menubar1 FROM news WHERE ID_menubar1 = %s AND ID_news != %s AND newsapproval = 1 ORDER BY newsdate DESC LIMIT 0,4", GetSQLValueString($colname_rs_page_newsrelative, "int"), GetSQLValueString($colname2_rs_page_newsrelative, "int"));
$rs_page_newsrelative = mysql_query($query_rs_page_newsrelative, $cnn_hoaly) or die(mysql_error());
$row_rs_page_newsrelative = mysql_fetch_assoc($rs_page_newsrelative);
$totalRows_rs_page_newsrelative = mysql_num_rows($rs_page_newsrelative);
?>
<div class="container">
    <div class="row">
        <h2>BÀI VIẾT LIÊN QUAN</h2>
        <span class="line3"></span>
    </div> <!-- end row-->
    <div class="row">
        <?php
        do {

            switch ($lang) {
                case 'vn':

                    $title = $row_rs_page_newsrelative['newstitle'];
                    $shortdes = $row_rs_page_newsrelative['shortdes'];
                    break;
                case 'en':

                    $title = $row_rs_page_newsrelative['newstitle_EN'];
                    $shortdes = $row_rs_page_newsrelative['shortdes_EN'];
                    break;
                case 'tw':

                    $title = $row_rs_page_newsrelative['newstitle_TW'];
                    $shortdes = $row_rs_page_newsrelative['shortdes_TW'];
                    break;
                default:

                    $title = $row_rs_page_newsrelative['newstitle'];
                    $shortdes = $row_rs_page_newsrelative['shortdes'];
                    break;
            }
            ?>
            <div class="col-xs-12 co-sm-6 col-md-3 col-lg-3">
                <div class="box_news4">
                    <a href="page_newsdetail.php?cat=<?php echo $row_rs_page_newsrelative['ID_menubar1']; ?>&id=<?php echo $row_rs_page_newsrelative['ID_news']; ?>" target="_self"><img src="images/news/<?php echo $row_rs_page_newsrelative['newsimg']; ?>" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive"></a>
                    <h4><a href="page_newsdetail.php?cat=<?php echo $row_rs_page_newsrelative['ID_menubar1']; ?>&id=<?php echo $row_rs_page_newsrelative['ID_news']; ?>" target="_self"><?php echo $title; ?></a></h4>
                    <p><a href="page_newsdetail.php?cat=<?php echo $row_rs_page_newsrelative['ID_menubar1']; ?>&id=<?php echo $row_rs_page_newsrelative['ID_news']; ?>" target="_self">Chi tiết <i class="fa fa-chevron-right" aria-hidden="true"></i></a></p>
                </div> <!-- end box_news3-->
            </div> <!-- end col-->
        <?php } while ($row_rs_page_newsrelative = mysql_fetch_assoc($rs_page_newsrelative)); ?>
    </div> 
    <!-- end row-->
</div> <!-- end container--> 
<?php
mysql_free_result($rs_page_newsrelative);
?>