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

//start Trigger_SetOrderColumn trigger
//remove this line if you want to edit the code by hand 
function Trigger_SetOrderColumn(&$tNG) {
  $orderFieldObj = new tNG_SetOrderField($tNG);
  $orderFieldObj->setFieldName("menubar1orderlist");
  return $orderFieldObj->Execute();
}
//end Trigger_SetOrderColumn trigger

// Make an insert transaction instance
$ins_menubar1 = new tNG_multipleInsert($conn_cnn_hoaly);
$tNGs->addTransaction($ins_menubar1);
// Register triggers
$ins_menubar1->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_menubar1->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_menubar1->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_menubar1->registerTrigger("BEFORE", "Trigger_SetOrderColumn", 50);
// Add columns
$ins_menubar1->setTable("menubar1");
$ins_menubar1->addColumn("menubar1name", "STRING_TYPE", "POST", "menubar1name");
$ins_menubar1->addColumn("menubar1name_en", "STRING_TYPE", "POST", "menubar1name_en");
$ins_menubar1->addColumn("menubar1seo", "STRING_TYPE", "POST", "menubar1seo");
$ins_menubar1->addColumn("menubar1visible", "CHECKBOX_1_0_TYPE", "POST", "menubar1visible", "0");
$ins_menubar1->addColumn("menubar1link", "CHECKBOX_1_0_TYPE", "POST", "menubar1link", "0");
$ins_menubar1->addColumn("menubar1linkurl", "STRING_TYPE", "POST", "menubar1linkurl");
$ins_menubar1->setPrimaryKey("ID_menubar1", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_menubar1 = new tNG_multipleUpdate($conn_cnn_hoaly);
$tNGs->addTransaction($upd_menubar1);
// Register triggers
$upd_menubar1->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_menubar1->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_menubar1->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_menubar1->setTable("menubar1");
$upd_menubar1->addColumn("menubar1name", "STRING_TYPE", "POST", "menubar1name");
$upd_menubar1->addColumn("menubar1name_en", "STRING_TYPE", "POST", "menubar1name_en");
$upd_menubar1->addColumn("menubar1seo", "STRING_TYPE", "POST", "menubar1seo");
$upd_menubar1->addColumn("menubar1visible", "CHECKBOX_1_0_TYPE", "POST", "menubar1visible");
$upd_menubar1->addColumn("menubar1link", "CHECKBOX_1_0_TYPE", "POST", "menubar1link");
$upd_menubar1->addColumn("menubar1linkurl", "STRING_TYPE", "POST", "menubar1linkurl");
$upd_menubar1->setPrimaryKey("ID_menubar1", "NUMERIC_TYPE", "GET", "ID_menubar1");

// Make an instance of the transaction object
$del_menubar1 = new tNG_multipleDelete($conn_cnn_hoaly);
$tNGs->addTransaction($del_menubar1);
// Register triggers
$del_menubar1->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_menubar1->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_menubar1->setTable("menubar1");
$del_menubar1->setPrimaryKey("ID_menubar1", "NUMERIC_TYPE", "GET", "ID_menubar1");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsmenubar1 = $tNGs->getRecordset("menubar1");
$row_rsmenubar1 = mysql_fetch_assoc($rsmenubar1);
$totalRows_rsmenubar1 = mysql_num_rows($rsmenubar1);
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
if (@$_GET['ID_menubar1'] == "") {
?>
              <?php echo NXT_getResource("Insert_FH"); ?>
              <?php 
// else Conditional region1
} else { ?>
              <?php echo NXT_getResource("Update_FH"); ?>
              <?php } 
// endif Conditional region1
?>
            Chỉnh sửa danh mục 1 </h1>
          <div class="KT_tngform">
            <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
              <?php $cnt1 = 0; ?>
              <?php do { ?>
                <?php $cnt1++; ?>
                <?php 
// Show IF Conditional region1 
if (@$totalRows_rsmenubar1 > 1) {
?>
                  <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
                  <?php } 
// endif Conditional region1
?>
                <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                  <tr>
                    <td class="KT_th"><label for="menubar1name_<?php echo $cnt1; ?>">Tên danh mục 1:</label></td>
                    <td><input type="text" name="menubar1name_<?php echo $cnt1; ?>" id="menubar1name_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsmenubar1['menubar1name']); ?>" size="32" maxlength="68" />
                      <?php echo $tNGs->displayFieldHint("menubar1name");?> <?php echo $tNGs->displayFieldError("menubar1", "menubar1name", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="menubar1name_en_<?php echo $cnt1; ?>">Tên danh mục 1 (tiếng Anh):</label></td>
                    <td><input type="text" name="menubar1name_en_<?php echo $cnt1; ?>" id="menubar1name_en_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsmenubar1['menubar1name_en']); ?>" size="32" maxlength="68" />
                      <?php echo $tNGs->displayFieldHint("menubar1name_en");?> <?php echo $tNGs->displayFieldError("menubar1", "menubar1name_en", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="menubar1seo_<?php echo $cnt1; ?>">SEO danh mục 1:</label></td>
                    <td><input type="text" name="menubar1seo_<?php echo $cnt1; ?>" id="menubar1seo_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsmenubar1['menubar1seo']); ?>" size="32" maxlength="68" />
                      <?php echo $tNGs->displayFieldHint("menubar1seo");?> <?php echo $tNGs->displayFieldError("menubar1", "menubar1seo", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="menubar1visible_<?php echo $cnt1; ?>">Ẩn/Hiện:</label></td>
                    <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rsmenubar1['menubar1visible']),"1"))) {echo "checked";} ?> type="checkbox" name="menubar1visible_<?php echo $cnt1; ?>" id="menubar1visible_<?php echo $cnt1; ?>" value="1" />
                      <?php echo $tNGs->displayFieldError("menubar1", "menubar1visible", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="menubar1link_<?php echo $cnt1; ?>">Link:</label></td>
                    <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rsmenubar1['menubar1link']),"1"))) {echo "checked";} ?> type="checkbox" name="menubar1link_<?php echo $cnt1; ?>" id="menubar1link_<?php echo $cnt1; ?>" value="1" />
                      <?php echo $tNGs->displayFieldError("menubar1", "menubar1link", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="menubar1linkurl_<?php echo $cnt1; ?>">Đường dẫn link:</label></td>
                    <td><input type="text" name="menubar1linkurl_<?php echo $cnt1; ?>" id="menubar1linkurl_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsmenubar1['menubar1linkurl']); ?>" size="32" maxlength="208" />
                      <?php echo $tNGs->displayFieldHint("menubar1linkurl");?> <?php echo $tNGs->displayFieldError("menubar1", "menubar1linkurl", $cnt1); ?></td>
                  </tr>
                </table>
                <input type="hidden" name="kt_pk_menubar1_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsmenubar1['kt_pk_menubar1']); ?>" />
                <?php } while ($row_rsmenubar1 = mysql_fetch_assoc($rsmenubar1)); ?>
              <div class="KT_bottombuttons">
                <div>
                  <?php 
      // Show IF Conditional region1
      if (@$_GET['ID_menubar1'] == "") {
      ?>
                    <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
                    <?php 
      // else Conditional region1
      } else { ?>
                    <div class="KT_operations">
                      <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'ID_menubar1')" />
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