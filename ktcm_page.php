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

mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
$query_rs_ktcm_page = "SELECT news.ID_news, news.newstitle, news.newstitle_EN, news.shortdes, news.shortdes_EN, news.newsimg, news.newsapproval, news.newsdate, menubar1.ID_menubar1, menubar1.menubar1name, menubar1.menubar1name_en FROM (news LEFT JOIN menubar1 ON menubar1.ID_menubar1=news.ID_menubar1) WHERE news.newsapproval=1  AND menubar1.ID_menubar1=7 ORDER BY news.newsdate DESC ";
$rs_ktcm_page = mysql_query($query_rs_ktcm_page, $cnn_hoaly) or die(mysql_error());
$row_rs_ktcm_page = mysql_fetch_assoc($rs_ktcm_page);
$totalRows_rs_ktcm_page = mysql_num_rows($rs_ktcm_page);
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
              <?php include("header.php");?>
            </div><br>
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
    <div class="page_news">
    	<div class="container">
       	  <div class="row">
            <div class="col-xs-12 co-sm-12 col-md-8 col-lg-8">
                    <?php do { ?>
                    <div class="row box_news2">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                          <img src="images/news/<?php echo $row_rs_ktcm_page['newsimg']; ?>" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive">
                          </div>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                          <h4><?php echo $row_rs_ktcm_page['newstitle']; ?></h4>
                          <span class="line3"></span>
                          <p><?php echo $row_rs_ktcm_page['shortdes']; ?></p>
                          <p><a href="#" target="_self">Chi tiết <i class="fa fa-chevron-right" aria-hidden="true"></i></a></p>
                          </div> 
                        </div> <!-- row box_news2-->
                      <?php } while ($row_rs_ktcm_page = mysql_fetch_assoc($rs_ktcm_page)); ?>
            </div> <!-- end col-->
              <article class="hidden-xs hidden-sm col-md-4 col-lg-4">
              	<img src="images/advertising-280x360.png" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive"> 
              </article> 
              <!-- end article-->
        	</div> 
        	<!-- end row-->
    	</div> <!-- end container-->
	</div> <!-- end page_news-->
    <?php include("footer.php");?>
</body>
</html>
<?php
mysql_free_result($rs_ktcm_page);
?>
