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

$maxRows_rs_index_cs = 4;
$pageNum_rs_index_cs = 0;
if (isset($_GET['pageNum_rs_index_cs'])) {
  $pageNum_rs_index_cs = $_GET['pageNum_rs_index_cs'];
}
$startRow_rs_index_cs = $pageNum_rs_index_cs * $maxRows_rs_index_cs;

mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
$query_rs_index_cs = "SELECT news.ID_news, news.newstitle, news.newstitle_EN, news.shortdes, news.shortdes_EN, news.newsimg, news.newsapproval, news.newsdate, menubar1.ID_menubar1, menubar1.menubar1name, menubar1.menubar1name_en FROM (news LEFT JOIN menubar1 ON menubar1.ID_menubar1=news.ID_menubar1) WHERE news.newsapproval=1  AND menubar1.ID_menubar1=8 ORDER BY news.newsdate DESC ";
$query_limit_rs_index_cs = sprintf("%s LIMIT %d, %d", $query_rs_index_cs, $startRow_rs_index_cs, $maxRows_rs_index_cs);
$rs_index_cs = mysql_query($query_limit_rs_index_cs, $cnn_hoaly) or die(mysql_error());
$row_rs_index_cs = mysql_fetch_assoc($rs_index_cs);

if (isset($_GET['totalRows_rs_index_cs'])) {
  $totalRows_rs_index_cs = $_GET['totalRows_rs_index_cs'];
} else {
  $all_rs_index_cs = mysql_query($query_rs_index_cs);
  $totalRows_rs_index_cs = mysql_num_rows($all_rs_index_cs);
}
$totalPages_rs_index_cs = ceil($totalRows_rs_index_cs/$maxRows_rs_index_cs)-1;
?>
<?php do { ?>
  <h4><a href="page_newsdetail.php?cat=<?php echo $row_rs_index_cs['ID_menubar1']; ?>&amp;id=<?php echo $row_rs_index_cs['ID_news']; ?>" target="_self"><i class="fa fa-check-square-o" aria-hidden="true"></i> <?php echo $row_rs_index_cs['newstitle']; ?></a>
  </h4>
  <?php } while ($row_rs_index_cs = mysql_fetch_assoc($rs_index_cs)); ?>
<?php
mysql_free_result($rs_index_cs);
?>