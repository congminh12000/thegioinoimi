<?php require_once('../Connections/cnn_hoaly.php'); ?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

// Load the common classes
require_once('../includes/common/KT_common.php');
 session_start();?>
<?php
// Require the MXI classes
require_once ('../includes/mxi/MXI.php');

// Load the tNG classes
require_once('../includes/tng/tNG.inc.php');

// Load the KT_back class
require_once('../includes/nxt/KT_back.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../");

// Make unified connection variable
$conn_cnn_hoaly = new KT_connection($cnn_hoaly, $database_cnn_hoaly);

// Start trigger
$formValidation = new tNG_FormValidation();
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileDelete(&$tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../images/news/");
  $deleteObj->setDbFieldName("newsimg");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_ImageUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_ImageUpload(&$tNG) {
  $uploadObj = new tNG_ImageUpload($tNG);
  $uploadObj->setFormFieldName("newsimg");
  $uploadObj->setDbFieldName("newsimg");
  $uploadObj->setFolder("../images/news/");
  $uploadObj->setResize("true", 800, 0);
  $uploadObj->setMaxSize(1000);
  $uploadObj->setAllowedExtensions("jpg, png");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_ImageUpload trigger

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
$query_rs_danhmuc1 = "SELECT ID_menubar1, menubar1name FROM menubar1 WHERE menubar1link = 0 ORDER BY menubar1orderlist ASC";
$rs_danhmuc1 = mysql_query($query_rs_danhmuc1, $cnn_hoaly) or die(mysql_error());
$row_rs_danhmuc1 = mysql_fetch_assoc($rs_danhmuc1);
$totalRows_rs_danhmuc1 = mysql_num_rows($rs_danhmuc1);

mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
$query_rs_danhmuc2 = "SELECT ID_menubar2, menubar2name, ID_menubar1 FROM menubar2 WHERE menubar2link = 0 ORDER BY menubar2orderlist ASC";
$rs_danhmuc2 = mysql_query($query_rs_danhmuc2, $cnn_hoaly) or die(mysql_error());
$row_rs_danhmuc2 = mysql_fetch_assoc($rs_danhmuc2);
$totalRows_rs_danhmuc2 = mysql_num_rows($rs_danhmuc2);

// Make an insert transaction instance
$ins_news = new tNG_multipleInsert($conn_cnn_hoaly);
$tNGs->addTransaction($ins_news);
// Register triggers
$ins_news->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_news->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_news->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_news->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$ins_news->setTable("news");
$ins_news->addColumn("ID_menubar1", "NUMERIC_TYPE", "POST", "ID_menubar1");
$ins_news->addColumn("ID_menubar2", "NUMERIC_TYPE", "POST", "ID_menubar2");
$ins_news->addColumn("newstitle", "STRING_TYPE", "POST", "newstitle");
$ins_news->addColumn("newstitle_EN", "STRING_TYPE", "POST", "newstitle_EN");
$ins_news->addColumn("shortdes", "STRING_TYPE", "POST", "shortdes");
$ins_news->addColumn("shortdes_EN", "STRING_TYPE", "POST", "shortdes_EN");
$ins_news->addColumn("newsimg", "FILE_TYPE", "FILES", "newsimg");
$ins_news->addColumn("newscontent", "STRING_TYPE", "POST", "newscontent");
$ins_news->addColumn("newscontent_EN", "STRING_TYPE", "POST", "newscontent_EN");
$ins_news->addColumn("newsview", "NUMERIC_TYPE", "VALUE", "");
$ins_news->addColumn("newsapproval", "CHECKBOX_1_0_TYPE", "POST", "newsapproval", "0");
$ins_news->addColumn("newsdate", "DATE_TYPE", "VALUE", "{NOW_DT}");
$ins_news->addColumn("ID_account", "NUMERIC_TYPE", "POST", "ID_account", "{SESSION.kt_login_id}");
$ins_news->setPrimaryKey("ID_news", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_news = new tNG_multipleUpdate($conn_cnn_hoaly);
$tNGs->addTransaction($upd_news);
// Register triggers
$upd_news->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_news->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_news->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_news->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$upd_news->setTable("news");
$upd_news->addColumn("ID_menubar1", "NUMERIC_TYPE", "POST", "ID_menubar1");
$upd_news->addColumn("ID_menubar2", "NUMERIC_TYPE", "POST", "ID_menubar2");
$upd_news->addColumn("newstitle", "STRING_TYPE", "POST", "newstitle");
$upd_news->addColumn("newstitle_EN", "STRING_TYPE", "POST", "newstitle_EN");
$upd_news->addColumn("shortdes", "STRING_TYPE", "POST", "shortdes");
$upd_news->addColumn("shortdes_EN", "STRING_TYPE", "POST", "shortdes_EN");
$upd_news->addColumn("newsimg", "FILE_TYPE", "FILES", "newsimg");
$upd_news->addColumn("newscontent", "STRING_TYPE", "POST", "newscontent");
$upd_news->addColumn("newscontent_EN", "STRING_TYPE", "POST", "newscontent_EN");
$upd_news->addColumn("newsview", "NUMERIC_TYPE", "CURRVAL", "");
$upd_news->addColumn("newsapproval", "CHECKBOX_1_0_TYPE", "POST", "newsapproval");
$upd_news->addColumn("newsdate", "DATE_TYPE", "CURRVAL", "");
$upd_news->addColumn("ID_account", "NUMERIC_TYPE", "POST", "ID_account");
$upd_news->setPrimaryKey("ID_news", "NUMERIC_TYPE", "GET", "ID_news");

// Make an instance of the transaction object
$del_news = new tNG_multipleDelete($conn_cnn_hoaly);
$tNGs->addTransaction($del_news);
// Register triggers
$del_news->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_news->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$del_news->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_news->setTable("news");
$del_news->setPrimaryKey("ID_news", "NUMERIC_TYPE", "GET", "ID_news");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsnews = $tNGs->getRecordset("news");
$row_rsnews = mysql_fetch_assoc($rsnews);
$totalRows_rsnews = mysql_num_rows($rsnews);
?>
<!doctype html>
<html xmlns:wdg="http://ns.adobe.com/addt">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width">
<title>Công Ty TNHH Thương Mại Lyan</title>
<script type="text/javascript" src="p7ehc/p7EHCscripts.js"></script>
<link href="p7csspbm2/p7csspbm2_12.css" rel="stylesheet" type="text/css">
<link href="p7csspbm2/p7csspbm2_print.css" rel="stylesheet" type="text/css" media="print">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" href="../vendor/font-awesome/css/font-awesome.min.css">
<script src="../vendor/jquery.min.js" type="text/javascript"></script>
<script src="../vendor/bootstrap.js" type="text/javascript"></script>
<link rel="shortcut icon" href="../images/favicon.ico">
<!--[if lte IE 7]>
<style>
.menutop li {display: inline;}
div, .menuside a {zoom: 1;}
.masthead .banner, .masthead .banner img {width: 100%;}
.sidebar2 {width: 19%;}
</style>
<![endif]-->
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
<script src="../includes/nxt/scripts/form.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/form.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_FORM_SETTINGS = {
  duplicate_buttons: true,
  show_as_grid: true,
  merge_down_value: true
}
</script>
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<?php
//begin JSRecordset
$jsObject_rs_danhmuc2 = new WDG_JsRecordset("rs_danhmuc2");
echo $jsObject_rs_danhmuc2->getOutput();
//end JSRecordset
?>
</head>

<body>
<div class="content-wrapper">
    <div class="masthead">
		<?php
            mxi_includes_start("admincp_header.php");
            require(basename("admincp_header.php"));
            mxi_includes_end();
        ?>
 	</div> <!-- end masthead -->
  <div class="columns-wrapper">
  <div class="sidebar">
      <div class="content p7ehc-1">
         <?php
			  mxi_includes_start("admincp_menu.php");
			  require(basename("admincp_menu.php"));
			  mxi_includes_end();
		?>
      </div>
    </div> <!-- end sidebar -->
    <div class="main-content">
      <div class="content p7ehc-1">
        <div class="KT_tng">
          <h1>
            <?php 
// Show IF Conditional region1 
if (@$_GET['ID_news'] == "") {
?>
              <?php echo NXT_getResource("Insert_FH"); ?>
              <?php 
// else Conditional region1
} else { ?>
              <?php echo NXT_getResource("Update_FH"); ?>
              <?php } 
// endif Conditional region1
?>
            Chi tiết tin </h1>
          <div class="KT_tngform">
            <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
              <?php $cnt1 = 0; ?>
              <?php do { ?>
                <?php $cnt1++; ?>
                <?php 
// Show IF Conditional region1 
if (@$totalRows_rsnews > 1) {
?>
                  <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
                  <?php } 
// endif Conditional region1
?>
                <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                  <tr>
                    <td width="26%" class="KT_th"><label for="ID_menubar1_<?php echo $cnt1; ?>">Danh mục 1:</label></td>
                    <td colspan="2"><select name="ID_menubar1_<?php echo $cnt1; ?>" id="ID_menubar1_<?php echo $cnt1; ?>">
                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                      <?php 
do {  
?>
                      <option value="<?php echo $row_rs_danhmuc1['ID_menubar1']?>"<?php if (!(strcmp($row_rs_danhmuc1['ID_menubar1'], $row_rsnews['ID_menubar1']))) {echo "SELECTED";} ?>><?php echo $row_rs_danhmuc1['menubar1name']?></option>
                      <?php
} while ($row_rs_danhmuc1 = mysql_fetch_assoc($rs_danhmuc1));
  $rows = mysql_num_rows($rs_danhmuc1);
  if($rows > 0) {
      mysql_data_seek($rs_danhmuc1, 0);
	  $row_rs_danhmuc1 = mysql_fetch_assoc($rs_danhmuc1);
  }
?>
                    </select>
                      <?php echo $tNGs->displayFieldError("news", "ID_menubar1", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="ID_menubar2_<?php echo $cnt1; ?>">Danh mục 2:</label></td>
                    <td colspan="2"><select name="ID_menubar2_<?php echo $cnt1; ?>" id="ID_menubar2_<?php echo $cnt1; ?>" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rs_danhmuc2" wdg:displayfield="ID_menubar1" wdg:valuefield="ID_menubar2" wdg:fkey="menubar2name" wdg:triggerobject="ID_menubar1_<?php echo $cnt1; ?>" wdg:selected="<?php echo $row_rsnews['ID_menubar2'] ?>">
                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                    </select>
                    <?php echo $tNGs->displayFieldError("news", "ID_menubar2", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="newstitle_<?php echo $cnt1; ?>">Tiêu đề:</label></td>
                    <td colspan="2"><input type="text" name="newstitle_<?php echo $cnt1; ?>" id="newstitle_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsnews['newstitle']); ?>" size="32" maxlength="168" />
                      <?php echo $tNGs->displayFieldHint("newstitle");?> <?php echo $tNGs->displayFieldError("news", "newstitle", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="newstitle_EN_<?php echo $cnt1; ?>">Tiêu đề (tiếng Anh):</label></td>
                    <td colspan="2"><input type="text" name="newstitle_EN_<?php echo $cnt1; ?>" id="newstitle_EN_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsnews['newstitle_EN']); ?>" size="32" maxlength="168" />
                      <?php echo $tNGs->displayFieldHint("newstitle_EN");?> <?php echo $tNGs->displayFieldError("news", "newstitle_EN", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="shortdes_<?php echo $cnt1; ?>">Mô tả ngắn:</label></td>
                    <td colspan="2"><textarea name="shortdes_<?php echo $cnt1; ?>" id="shortdes_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsnews['shortdes']); ?></textarea>
                      <?php echo $tNGs->displayFieldHint("shortdes");?> <?php echo $tNGs->displayFieldError("news", "shortdes", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="shortdes_EN_<?php echo $cnt1; ?>">Mô tả ngắn (tiếng Anh):</label></td>
                    <td colspan="2"><textarea name="shortdes_EN_<?php echo $cnt1; ?>" id="shortdes_EN_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsnews['shortdes_EN']); ?></textarea>
                      <?php echo $tNGs->displayFieldHint("shortdes_EN");?> <?php echo $tNGs->displayFieldError("news", "shortdes_EN", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="newsimg_<?php echo $cnt1; ?>">Hình đại diện:<br>(800x600 pixels)</label></td>
                    <td width="37%"><input type="file" name="newsimg_<?php echo $cnt1; ?>" id="newsimg_<?php echo $cnt1; ?>" size="32" />
                      <?php echo $tNGs->displayFieldError("news", "newsimg", $cnt1); ?></td>
                    <td width="37%"><?php 
						// Show If File Exists (region4)
						if (tNG_fileExists("../images/news/", "{rsnews.newsimg}")) {
						?>
                        <img src="<?php echo tNG_showDynamicImage("../", "../images/news/", "{rsnews.newsimg}");?>" width="200px"/>
                        <?php 
						// else File Exists (region4)
						} else { ?>
												<img src="p7csspbm2/img/image.png" width="200px">
					<?php } 
						// EndIf File Exists (region4)
						?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="newscontent_<?php echo $cnt1; ?>">Nội dung tin:</label></td>
                    <td colspan="2"><textarea name="newscontent_<?php echo $cnt1; ?>" id="newscontent_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsnews['newscontent']); ?></textarea>
                    <script type="text/javascript">
						CKEDITOR.replace('newscontent_<?php echo $cnt1; ?>', {extraPlugins: 'imageuploader'});
					</script>
                      <?php echo $tNGs->displayFieldHint("newscontent");?> <?php echo $tNGs->displayFieldError("news", "newscontent", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="newscontent_EN_<?php echo $cnt1; ?>">Nội dung tin (tiếng Anh):</label></td>
                    <td colspan="2"><textarea name="newscontent_EN_<?php echo $cnt1; ?>" id="newscontent_EN_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsnews['newscontent_EN']); ?></textarea>
                    <script type="text/javascript">
						CKEDITOR.replace('newscontent_EN_<?php echo $cnt1; ?>', {extraPlugins: 'imageuploader'});
					</script>
                      <?php echo $tNGs->displayFieldHint("newscontent_EN");?> <?php echo $tNGs->displayFieldError("news", "newscontent_EN", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th">Lượt xem:</td>
                    <td colspan="2"><?php echo KT_escapeAttribute($row_rsnews['newsview']); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="newsapproval_<?php echo $cnt1; ?>">Duyệt:</label></td>
                    <td colspan="2"><input  <?php if (!(strcmp(KT_escapeAttribute($row_rsnews['newsapproval']),"1"))) {echo "checked";} ?> type="checkbox" name="newsapproval_<?php echo $cnt1; ?>" id="newsapproval_<?php echo $cnt1; ?>" value="1" />
                      <?php echo $tNGs->displayFieldError("news", "newsapproval", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th">Newsdate:</td>
                    <td colspan="2"><?php echo KT_formatDate($row_rsnews['newsdate']); ?></td>
                  </tr>
                </table>
                <input type="hidden" name="kt_pk_news_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsnews['kt_pk_news']); ?>" />
                <input type="hidden" name="ID_account_<?php echo $cnt1; ?>" id="ID_account_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsnews['ID_account']); ?>" />
                <?php } while ($row_rsnews = mysql_fetch_assoc($rsnews)); ?>
              <div class="KT_bottombuttons">
                <div>
                  <?php 
      // Show IF Conditional region1
      if (@$_GET['ID_news'] == "") {
      ?>
                    <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
                    <?php 
      // else Conditional region1
      } else { ?>
                    <div class="KT_operations">
                      <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onClick="nxt_form_insertasnew(this, 'ID_news')" />
                    </div>
                    <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" />
                    <input type="submit" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" onClick="return confirm('<?php echo NXT_getResource("Are you sure?"); ?>');" />
                    <?php }
      // endif Conditional region1
      ?>
                  <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onClick="return UNI_navigateCancel(event, '../includes/nxt/back.php')" />
                </div>
              </div>
            </form>
          </div>
          <br class="clearfixplain" />
        </div>
      </div> 
      <!-- end content -->
    </div> <!-- end main-content -->
</div> <!-- end columns-wrapper -->
  <?php
		mxi_includes_start("admincp_footer.php");
		require(basename("admincp_footer.php"));
		mxi_includes_end();
	?>
</div> <!-- end content-wrapper -->
</body>
</html>
<?php
mysql_free_result($rs_danhmuc1);
mysql_free_result($rs_danhmuc2);
?>