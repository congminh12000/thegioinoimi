<?php require_once('Connections/cnn_hoaly.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
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

$maxRows_rs_index_sk = 3;
$pageNum_rs_index_sk = 0;
if (isset($_GET['pageNum_rs_index_sk'])) {
  $pageNum_rs_index_sk = $_GET['pageNum_rs_index_sk'];
}
$startRow_rs_index_sk = $pageNum_rs_index_sk * $maxRows_rs_index_sk;

mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
$query_rs_index_sk = "SELECT news.ID_news, news.newstitle, news.newstitle_EN, news.shortdes, news.shortdes_EN, news.newsimg, news.newsapproval, news.newsdate, menubar1.ID_menubar1, menubar1.menubar1name, menubar1.menubar1name_en FROM (news LEFT JOIN menubar1 ON menubar1.ID_menubar1=news.ID_menubar1) WHERE news.newsapproval=1  AND menubar1.ID_menubar1=6 ORDER BY news.newsdate DESC ";
$query_limit_rs_index_sk = sprintf("%s LIMIT %d, %d", $query_rs_index_sk, $startRow_rs_index_sk, $maxRows_rs_index_sk);
$rs_index_sk = mysql_query($query_limit_rs_index_sk, $cnn_hoaly) or die(mysql_error());
$row_rs_index_sk = mysql_fetch_assoc($rs_index_sk);

if (isset($_GET['totalRows_rs_index_sk'])) {
  $totalRows_rs_index_sk = $_GET['totalRows_rs_index_sk'];
} else {
  $all_rs_index_sk = mysql_query($query_rs_index_sk);
  $totalRows_rs_index_sk = mysql_num_rows($all_rs_index_sk);
}
$totalPages_rs_index_sk = ceil($totalRows_rs_index_sk/$maxRows_rs_index_sk)-1;
?>
<?php do { ?>
  <div class="row box_news">
    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
      <a href="page_newsdetail.php?cat=<?php echo $row_rs_index_sk['ID_menubar1']; ?>&amp;id=<?php echo $row_rs_index_sk['ID_news']; ?>" target="_self"><img src="images/news/<?php echo $row_rs_index_sk['newsimg']; ?>/" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive"></a>
      </div>
    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
      <h4><a href="page_newsdetail.php?cat=<?php echo $row_rs_index_sk['ID_menubar1']; ?>&amp;id=<?php echo $row_rs_index_sk['ID_news']; ?>" target="_self"><?php echo $row_rs_index_sk['newstitle']; ?></a></h4>
      <p><?php echo $row_rs_index_sk['shortdes']; ?></p>
      <p><a href="page_newsdetail.php?cat=<?php echo $row_rs_index_sk['ID_menubar1']; ?>&amp;id=<?php echo $row_rs_index_sk['ID_news']; ?>" target="_self">Chi tiết <i class="fa fa-chevron-right" aria-hidden="true"></i></a></p>
      </div>
  </div> <!-- end row-->
  <?php } while ($row_rs_index_sk = mysql_fetch_assoc($rs_index_sk)); ?>
<?php
mysql_free_result($rs_index_sk);
?>