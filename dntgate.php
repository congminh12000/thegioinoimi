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

// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("kt_login_user", true, "text", "", "", "", "");
$formValidation->addField("kt_login_password", true, "text", "", "", "", "");
$tNGs->prepareValidation($formValidation);
// End trigger

// Make a login transaction instance
$loginTransaction = new tNG_login($conn_cnn_hoaly);
$tNGs->addTransaction($loginTransaction);
// Register triggers
$loginTransaction->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "kt_login1");
$loginTransaction->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$loginTransaction->registerTrigger("END", "Trigger_Default_Redirect", 99, "{kt_login_redirect}");
// Add columns
$loginTransaction->addColumn("kt_login_user", "STRING_TYPE", "POST", "kt_login_user");
$loginTransaction->addColumn("kt_login_password", "STRING_TYPE", "POST", "kt_login_password");
$loginTransaction->addColumn("kt_login_rememberme", "CHECKBOX_1_0_TYPE", "POST", "kt_login_rememberme", "0");
// End of login transaction instance

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscustom = $tNGs->getRecordset("custom");
$row_rscustom = mysql_fetch_assoc($rscustom);
$totalRows_rscustom = mysql_num_rows($rscustom);
?>
<!DOCTYPE html>
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
<link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="includes/common/js/base.js" type="text/javascript"></script>
<script src="includes/common/js/utility.js" type="text/javascript"></script>
<script src="includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
</head>

<body><header class="top_header">
    	<div class="container">
        	<div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                	<h4><b>Công ty TNHH Thương mại Lyan</b></h4>
                    <h4>365 Sư Vạn Hạnh, Phường 12, Quận 10, TP.HCM</h4>
                	<h4><a href="tel:0965777515">Hotline: 0965 777 515</a> - <a href="tel:0862822555">Tel: 08 62 822 555</a></h4>
                    <h4>Email: <a href="mailto:hoalys.lyan@gmail.com">hoalys.lyan@gmail.com</a></h4>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
                	<img src="images/logo.png" alt="Công Ty TNHH Thương Mại Lyan" width="200px">
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right">
                	<div class="row language_box">
                    	<span class="submenu">
                       		<a href="#" target="_self"><img src="images/vietnameseflag.png">&nbsp;&nbsp;Việt Nam</a>&nbsp;&nbsp;|&nbsp;&nbsp; 
                        </span>
                         <span class="submenu">
                        	<a href="#" target="_self"><img src="images/englishflag.png">&nbsp;&nbsp;English</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                        </span>
                         <span class="submenu">
                        	<a href="#" target="_self"><img src="images/chineseflag.png">&nbsp;&nbsp;中文 (中国)</a> 
                        </span> 
                  </div>
                	<div class="row language_box">
                   		<span class="submenu">
                        	<a href="#">Đăng nhập&nbsp;&nbsp;</a>
                        </span>
                        <span class="submenu">
                        	<a href="#">Đăng ký&nbsp;&nbsp;</a>
                        </span>
                        <span class="submenu">
                        	<a href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Giỏ hàng <span class="badge">6</span></a>
                        </span>
                    </div>
                </div>
            </div><br>
        	<div class="row">
            	<div class="hidden-xs hidden-sm col-md-1 col-lg-1">
                </div>
                <div class="col-xs-12 co-sm-12 col-md-10 col-lg-10">
                	<nav class="navbar navbar-default" role="navigation">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                    
                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse navbar-ex1-collapse">
                                <ul class="nav navbar-nav">
                                    <li><a href="#">TRANG CHỦ</a></li>
                                    <li><a href="#">GIỚI THIỆU</a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">SẢN PHẨM <b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Keo nối mi</a></li>
                                            <li><a href="#">Mi nối</a></li>
                                            <li><a href="#">Nhíp gắp mi</a></li>
                                            <li><a href="#">Dưỡng mi</a></li>
                                            <li><a href="#">Dụng cụ hỗ trợ</a></li>
                                            <li><a href="#">Sản phẩm khác</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">ĐÀO TẠO</a></li>
                                    <li><a href="#">CÂY NHÍP VÀNG</a></li>
                                    <li><a href="#">SỰ KIỆN</a></li>
                                    <li><a href="#">KIẾN THỨC CHUYÊN MÔN</a></li>
                                    <li><a href="#">CHÍNH SÁCH</a></li>
                                    <li><a href="#">LIÊN HỆ</a></li>
                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </div>
                    </nav>
                    </div>
                    <div class="hidden-xs hidden-sm col-md-1 col-lg-1">
                	</div>
           	 </div> <!-- end row-->
        </div> <!-- end container-->
    </header> <!-- end header-->
    <div class="login">
    	<div class="container">
        <form method="post" id="form1" class="KT_tngformerror" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
          <table cellpadding="2" cellspacing="0" class="KT_tngtable">
            <tr>
              <td class="KT_th"><label for="kt_login_user">Username:</label></td>
              <td><input type="text" name="kt_login_user" id="kt_login_user" value="<?php echo KT_escapeAttribute($row_rscustom['kt_login_user']); ?>" size="32" />
                <?php echo $tNGs->displayFieldHint("kt_login_user");?> <?php echo $tNGs->displayFieldError("custom", "kt_login_user"); ?></td>
            </tr>
            <tr>
              <td class="KT_th"><label for="kt_login_password">Password:</label></td>
              <td><input type="password" name="kt_login_password" id="kt_login_password" value="" size="32" />
                <?php echo $tNGs->displayFieldHint("kt_login_password");?> <?php echo $tNGs->displayFieldError("custom", "kt_login_password"); ?></td>
            </tr>
            <tr>
              <td class="KT_th"><label for="kt_login_rememberme">Remember me:</label></td>
              <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rscustom['kt_login_rememberme']),"1"))) {echo "checked";} ?> type="checkbox" name="kt_login_rememberme" id="kt_login_rememberme" value="1" />
                <?php echo $tNGs->displayFieldError("custom", "kt_login_rememberme"); ?></td>
            </tr>
            <tr class="KT_buttons">
              <td colspan="2"><input type="submit" name="kt_login1" id="kt_login1" value="Đăng nhập" /></td>
            </tr>
          </table>
        </form>
        <p>&nbsp;</p>
        </div> <!-- end container-->
        </div> <!-- end login-->
<footer class="bottom_tail">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 box_footer">
                	<img src="images/logo-ora.png" alt="Công Ty TNHH Thương Mại Lyan" height="60px">
                	<p>ORA Nails Eyelash Salon là salon nhượng quyền chuyên chăm sóc mi & móng đầu tiên ở Việt Nam của hệ thống salon ORA Taiwan.</p>
                    <p><i class="fa fa-facebook-square fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<i class="fa fa-google-plus-square fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<i class="fa fa-youtube-play fa-lg" aria-hidden="true"></i></p>
                    <div id="fb-root"></div>
					<script>(function(d, s, id) {
                      var js, fjs = d.getElementsByTagName(s)[0];
                      if (d.getElementById(id)) return;
                      js = d.createElement(s); js.id = id;
                      js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.9&appId=883184878397689";
                      fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                    <div class="fb-page" data-href="https://www.facebook.com/orasalon.vn" data-width="350" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/orasalon.vn/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/orasalon.vn/">ORA Salon</a></blockquote></div>
                </div> <!-- end box_footer-->
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 box_footer">
                	<img src="images/logo.png" alt="Công Ty TNHH Thương Mại Lyan" height="60px">
                    <p>Vẻ đẹp của bạn là niềm tự hào và động lực cho chúng tôi luôn cố gắng!</p>
                    <p><i class="fa fa-facebook-square fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<i class="fa fa-google-plus-square fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<i class="fa fa-youtube-play fa-lg" aria-hidden="true"></i></p>
                	<div id="fb-root"></div>
					<script>(function(d, s, id) {
                      var js, fjs = d.getElementsByTagName(s)[0];
                      if (d.getElementById(id)) return;
                      js = d.createElement(s); js.id = id;
                      js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.9&appId=883184878397689";
                      fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                    <div class="fb-page" data-href="https://www.facebook.com/hoaly.vn/" data-width="350" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/hoaly.vn/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/hoaly.vn/">HoaLy&#039;s Eyelash Nails</a></blockquote></div>
                </div> <!-- end box_footer-->
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 box_footer">
                <h3>Chính sách</h3>
                    <p><a href="#" target="_self"><i class="fa fa-check-square-o" aria-hidden="true"></i> Bài viết nội dung chính sách 01</a></p>
                    <p><a href="#" target="_self"><i class="fa fa-check-square-o" aria-hidden="true"></i> Bài viết nội dung chính sách 01</a></p>
                    <p><a href="#" target="_self"><i class="fa fa-check-square-o" aria-hidden="true"></i> Bài viết nội dung chính sách 01</a></p>
                    <p><a href="#" target="_self"><i class="fa fa-check-square-o" aria-hidden="true"></i> Bài viết nội dung chính sách 01</a></p>
              </div> <!-- end box_footer-->
            </div> <!-- end row-->
        </div> <!-- end container-->
    </footer> <!-- end footer-->
    <div class="copyright">
    	<div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            &copy; Copyright 2017 by Hoa Ly's Eyelash. All Rights Reserved. Designed by <a href="https://www.teamdnt.website" target="_blank">TeamDnT - WedDesign</a>.
            </div>
        </div> <!-- end container-->
    </div> <!-- end copyright-->
</body>
</html>