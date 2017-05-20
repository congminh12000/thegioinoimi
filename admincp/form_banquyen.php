<?php require_once('../Connections/cnn_hoaly.php'); ?>
<?php
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
  $deleteObj->setFolder("../images/avatar/");
  $deleteObj->setDbFieldName("businesslogo");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_ImageUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_ImageUpload(&$tNG) {
  $uploadObj = new tNG_ImageUpload($tNG);
  $uploadObj->setFormFieldName("businesslogo");
  $uploadObj->setDbFieldName("businesslogo");
  $uploadObj->setFolder("../images/avatar/");
  $uploadObj->setMaxSize(1000);
  $uploadObj->setAllowedExtensions("jpg, png");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_ImageUpload trigger

// Make an insert transaction instance
$ins_copyright = new tNG_multipleInsert($conn_cnn_hoaly);
$tNGs->addTransaction($ins_copyright);
// Register triggers
$ins_copyright->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_copyright->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_copyright->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_copyright->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$ins_copyright->setTable("copyright");
$ins_copyright->addColumn("businessname", "STRING_TYPE", "POST", "businessname");
$ins_copyright->addColumn("businesslogo", "FILE_TYPE", "FILES", "businesslogo");
$ins_copyright->addColumn("businessaddress", "STRING_TYPE", "POST", "businessaddress");
$ins_copyright->addColumn("businessemail", "STRING_TYPE", "POST", "businessemail");
$ins_copyright->addColumn("businessphonenumber", "STRING_TYPE", "POST", "businessphonenumber");
$ins_copyright->addColumn("businesswebsite", "STRING_TYPE", "POST", "businesswebsite");
$ins_copyright->addColumn("business_metakey", "STRING_TYPE", "POST", "business_metakey");
$ins_copyright->addColumn("business_metades", "STRING_TYPE", "POST", "business_metades");
$ins_copyright->addColumn("businessfanpageaddon", "STRING_TYPE", "POST", "businessfanpageaddon");
$ins_copyright->addColumn("businessgoogleanalytics", "STRING_TYPE", "POST", "businessgoogleanalytics");
$ins_copyright->addColumn("businessfacebook", "STRING_TYPE", "POST", "businessfacebook");
$ins_copyright->addColumn("businesstwitter", "STRING_TYPE", "POST", "businesstwitter");
$ins_copyright->addColumn("businessgoogle", "STRING_TYPE", "POST", "businessgoogle");
$ins_copyright->addColumn("businessyoutube", "STRING_TYPE", "POST", "businessyoutube");
$ins_copyright->addColumn("businessinstagram", "STRING_TYPE", "POST", "businessinstagram");
$ins_copyright->addColumn("businesspinterest", "STRING_TYPE", "POST", "businesspinterest");
$ins_copyright->setPrimaryKey("ID_copyright", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_copyright = new tNG_multipleUpdate($conn_cnn_hoaly);
$tNGs->addTransaction($upd_copyright);
// Register triggers
$upd_copyright->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_copyright->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_copyright->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_copyright->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$upd_copyright->setTable("copyright");
$upd_copyright->addColumn("businessname", "STRING_TYPE", "POST", "businessname");
$upd_copyright->addColumn("businesslogo", "FILE_TYPE", "FILES", "businesslogo");
$upd_copyright->addColumn("businessaddress", "STRING_TYPE", "POST", "businessaddress");
$upd_copyright->addColumn("businessemail", "STRING_TYPE", "POST", "businessemail");
$upd_copyright->addColumn("businessphonenumber", "STRING_TYPE", "POST", "businessphonenumber");
$upd_copyright->addColumn("businesswebsite", "STRING_TYPE", "POST", "businesswebsite");
$upd_copyright->addColumn("business_metakey", "STRING_TYPE", "POST", "business_metakey");
$upd_copyright->addColumn("business_metades", "STRING_TYPE", "POST", "business_metades");
$upd_copyright->addColumn("businessfanpageaddon", "STRING_TYPE", "POST", "businessfanpageaddon");
$upd_copyright->addColumn("businessgoogleanalytics", "STRING_TYPE", "POST", "businessgoogleanalytics");
$upd_copyright->addColumn("businessfacebook", "STRING_TYPE", "POST", "businessfacebook");
$upd_copyright->addColumn("businesstwitter", "STRING_TYPE", "POST", "businesstwitter");
$upd_copyright->addColumn("businessgoogle", "STRING_TYPE", "POST", "businessgoogle");
$upd_copyright->addColumn("businessyoutube", "STRING_TYPE", "POST", "businessyoutube");
$upd_copyright->addColumn("businessinstagram", "STRING_TYPE", "POST", "businessinstagram");
$upd_copyright->addColumn("businesspinterest", "STRING_TYPE", "POST", "businesspinterest");
$upd_copyright->setPrimaryKey("ID_copyright", "NUMERIC_TYPE", "GET", "ID_copyright");

// Make an instance of the transaction object
$del_copyright = new tNG_multipleDelete($conn_cnn_hoaly);
$tNGs->addTransaction($del_copyright);
// Register triggers
$del_copyright->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_copyright->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$del_copyright->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_copyright->setTable("copyright");
$del_copyright->setPrimaryKey("ID_copyright", "NUMERIC_TYPE", "GET", "ID_copyright");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscopyright = $tNGs->getRecordset("copyright");
$row_rscopyright = mysql_fetch_assoc($rscopyright);
$totalRows_rscopyright = mysql_num_rows($rscopyright);
?>
<!doctype html>
<html>
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
if (@$_GET['ID_copyright'] == "") {
?>
              <?php echo NXT_getResource("Insert_FH"); ?>
              <?php 
// else Conditional region1
} else { ?>
              <?php echo NXT_getResource("Update_FH"); ?>
              <?php } 
// endif Conditional region1
?>
            Chi tiết bản quyền </h1>
          <div class="KT_tngform">
            <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
              <?php $cnt1 = 0; ?>
              <?php do { ?>
                <?php $cnt1++; ?>
                <?php 
// Show IF Conditional region1 
if (@$totalRows_rscopyright > 1) {
?>
                  <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
                  <?php } 
// endif Conditional region1
?>
                <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                  <tr>
                    <td width="26%" class="KT_th"><label for="businessname_<?php echo $cnt1; ?>">Tên công ty:</label></td>
                    <td colspan="2"><input type="text" name="businessname_<?php echo $cnt1; ?>" id="businessname_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscopyright['businessname']); ?>" size="32" maxlength="168" />
                      <?php echo $tNGs->displayFieldHint("businessname");?> <?php echo $tNGs->displayFieldError("copyright", "businessname", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="businesslogo_<?php echo $cnt1; ?>">Logo:</label></td>
                    <td width="38%"><input type="file" name="businesslogo_<?php echo $cnt1; ?>" id="businesslogo_<?php echo $cnt1; ?>" size="32" />
                      <?php echo $tNGs->displayFieldError("copyright", "businesslogo", $cnt1); ?></td>
                    <td width="36%"><?php 
						// Show If File Exists (region4)
						if (tNG_fileExists("../images/avatar/", "{rscopyright.businesslogo}")) {
						?>
												<img src="<?php echo tNG_showDynamicImage("../", "../images/avatar/", "{rscopyright.businesslogo}");?>" />
												<?php 
						// else File Exists (region4)
						} else { ?>
												<img src="p7csspbm2/img/logo.png" width="150" height="150">
						<?php } 
						// EndIf File Exists (region4)
						?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="businessaddress_<?php echo $cnt1; ?>">Địa chỉ:</label></td>
                    <td colspan="2"><input type="text" name="businessaddress_<?php echo $cnt1; ?>" id="businessaddress_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscopyright['businessaddress']); ?>" size="32" maxlength="208" />
                      <?php echo $tNGs->displayFieldHint("businessaddress");?> <?php echo $tNGs->displayFieldError("copyright", "businessaddress", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="businessemail_<?php echo $cnt1; ?>">Email:</label></td>
                    <td colspan="2"><input type="text" name="businessemail_<?php echo $cnt1; ?>" id="businessemail_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscopyright['businessemail']); ?>" size="32" maxlength="168" />
                      <?php echo $tNGs->displayFieldHint("businessemail");?> <?php echo $tNGs->displayFieldError("copyright", "businessemail", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="businessphonenumber_<?php echo $cnt1; ?>">Điện thoại:</label></td>
                    <td colspan="2"><input type="text" name="businessphonenumber_<?php echo $cnt1; ?>" id="businessphonenumber_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscopyright['businessphonenumber']); ?>" size="26" maxlength="26" />
                      <?php echo $tNGs->displayFieldHint("businessphonenumber");?> <?php echo $tNGs->displayFieldError("copyright", "businessphonenumber", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="businesswebsite_<?php echo $cnt1; ?>">Website:</label></td>
                    <td colspan="2"><input type="text" name="businesswebsite_<?php echo $cnt1; ?>" id="businesswebsite_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscopyright['businesswebsite']); ?>" size="32" maxlength="168" />
                      <?php echo $tNGs->displayFieldHint("businesswebsite");?> <?php echo $tNGs->displayFieldError("copyright", "businesswebsite", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="business_metakey_<?php echo $cnt1; ?>">Meta keywords:</label></td>
                    <td colspan="2"><textarea name="business_metakey_<?php echo $cnt1; ?>" id="business_metakey_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rscopyright['business_metakey']); ?></textarea>
                      <?php echo $tNGs->displayFieldHint("business_metakey");?> <?php echo $tNGs->displayFieldError("copyright", "business_metakey", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="business_metades_<?php echo $cnt1; ?>">Meta description:</label></td>
                    <td colspan="2"><textarea name="business_metades_<?php echo $cnt1; ?>" id="business_metades_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rscopyright['business_metades']); ?></textarea>
                      <?php echo $tNGs->displayFieldHint("business_metades");?> <?php echo $tNGs->displayFieldError("copyright", "business_metades", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="businessfanpageaddon_<?php echo $cnt1; ?>">Addon Fanpage:</label></td>
                    <td colspan="2"><textarea name="businessfanpageaddon_<?php echo $cnt1; ?>" id="businessfanpageaddon_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rscopyright['businessfanpageaddon']); ?></textarea>
                      <?php echo $tNGs->displayFieldHint("businessfanpageaddon");?> <?php echo $tNGs->displayFieldError("copyright", "businessfanpageaddon", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="businessgoogleanalytics_<?php echo $cnt1; ?>">Google Analytics:</label></td>
                    <td colspan="2"><textarea name="businessgoogleanalytics_<?php echo $cnt1; ?>" id="businessgoogleanalytics_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rscopyright['businessgoogleanalytics']); ?></textarea>
                      <?php echo $tNGs->displayFieldHint("businessgoogleanalytics");?> <?php echo $tNGs->displayFieldError("copyright", "businessgoogleanalytics", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="businessfacebook_<?php echo $cnt1; ?>">Facebook:</label></td>
                    <td colspan="2"><input type="text" name="businessfacebook_<?php echo $cnt1; ?>" id="businessfacebook_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscopyright['businessfacebook']); ?>" size="32" maxlength="168" />
                      <?php echo $tNGs->displayFieldHint("businessfacebook");?> <?php echo $tNGs->displayFieldError("copyright", "businessfacebook", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="businesstwitter_<?php echo $cnt1; ?>">Twitter:</label></td>
                    <td colspan="2"><input type="text" name="businesstwitter_<?php echo $cnt1; ?>" id="businesstwitter_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscopyright['businesstwitter']); ?>" size="32" maxlength="168" />
                      <?php echo $tNGs->displayFieldHint("businesstwitter");?> <?php echo $tNGs->displayFieldError("copyright", "businesstwitter", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="businessgoogle_<?php echo $cnt1; ?>">Google+:</label></td>
                    <td colspan="2"><input type="text" name="businessgoogle_<?php echo $cnt1; ?>" id="businessgoogle_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscopyright['businessgoogle']); ?>" size="32" maxlength="168" />
                      <?php echo $tNGs->displayFieldHint("businessgoogle");?> <?php echo $tNGs->displayFieldError("copyright", "businessgoogle", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="businessyoutube_<?php echo $cnt1; ?>">Youtube:</label></td>
                    <td colspan="2"><input type="text" name="businessyoutube_<?php echo $cnt1; ?>" id="businessyoutube_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscopyright['businessyoutube']); ?>" size="32" maxlength="168" />
                      <?php echo $tNGs->displayFieldHint("businessyoutube");?> <?php echo $tNGs->displayFieldError("copyright", "businessyoutube", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="businessinstagram_<?php echo $cnt1; ?>">Instagram:</label></td>
                    <td colspan="2"><input type="text" name="businessinstagram_<?php echo $cnt1; ?>" id="businessinstagram_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscopyright['businessinstagram']); ?>" size="32" maxlength="168" />
                      <?php echo $tNGs->displayFieldHint("businessinstagram");?> <?php echo $tNGs->displayFieldError("copyright", "businessinstagram", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="businesspinterest_<?php echo $cnt1; ?>">Pinterest:</label></td>
                    <td colspan="2"><input type="text" name="businesspinterest_<?php echo $cnt1; ?>" id="businesspinterest_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscopyright['businesspinterest']); ?>" size="32" maxlength="168" />
                      <?php echo $tNGs->displayFieldHint("businesspinterest");?> <?php echo $tNGs->displayFieldError("copyright", "businesspinterest", $cnt1); ?></td>
                  </tr>
                </table>
                <input type="hidden" name="kt_pk_copyright_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rscopyright['kt_pk_copyright']); ?>" />
                <?php } while ($row_rscopyright = mysql_fetch_assoc($rscopyright)); ?>
              <div class="KT_bottombuttons">
                <div>
                  <?php 
      // Show IF Conditional region1
      if (@$_GET['ID_copyright'] == "") {
      ?>
                    <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
                    <?php 
      // else Conditional region1
      } else { ?>
                    <div class="KT_operations">
                      <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'ID_copyright')" />
                    </div>
                    <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" />
                    <input type="submit" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" onclick="return confirm('<?php echo NXT_getResource("Are you sure?"); ?>');" />
                    <?php }
      // endif Conditional region1
      ?>
                  <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onclick="return UNI_navigateCancel(event, '../includes/nxt/back.php')" />
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