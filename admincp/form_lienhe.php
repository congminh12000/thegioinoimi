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

// Make an insert transaction instance
$ins_contact = new tNG_multipleInsert($conn_cnn_hoaly);
$tNGs->addTransaction($ins_contact);
// Register triggers
$ins_contact->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_contact->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_contact->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$ins_contact->setTable("contact");
$ins_contact->addColumn("contactfullname", "STRING_TYPE", "POST", "contactfullname");
$ins_contact->addColumn("contactemail", "STRING_TYPE", "POST", "contactemail");
$ins_contact->addColumn("contactphonenumber", "STRING_TYPE", "POST", "contactphonenumber");
$ins_contact->addColumn("contactaddress", "STRING_TYPE", "POST", "contactaddress");
$ins_contact->addColumn("contactcontent", "STRING_TYPE", "POST", "contactcontent");
$ins_contact->addColumn("contactdate", "DATE_TYPE", "VALUE", "");
$ins_contact->setPrimaryKey("ID_contact", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_contact = new tNG_multipleUpdate($conn_cnn_hoaly);
$tNGs->addTransaction($upd_contact);
// Register triggers
$upd_contact->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_contact->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_contact->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$upd_contact->setTable("contact");
$upd_contact->addColumn("contactfullname", "STRING_TYPE", "POST", "contactfullname");
$upd_contact->addColumn("contactemail", "STRING_TYPE", "POST", "contactemail");
$upd_contact->addColumn("contactphonenumber", "STRING_TYPE", "POST", "contactphonenumber");
$upd_contact->addColumn("contactaddress", "STRING_TYPE", "POST", "contactaddress");
$upd_contact->addColumn("contactcontent", "STRING_TYPE", "POST", "contactcontent");
$upd_contact->addColumn("contactdate", "DATE_TYPE", "CURRVAL", "");
$upd_contact->setPrimaryKey("ID_contact", "NUMERIC_TYPE", "GET", "ID_contact");

// Make an instance of the transaction object
$del_contact = new tNG_multipleDelete($conn_cnn_hoaly);
$tNGs->addTransaction($del_contact);
// Register triggers
$del_contact->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_contact->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
// Add columns
$del_contact->setTable("contact");
$del_contact->setPrimaryKey("ID_contact", "NUMERIC_TYPE", "GET", "ID_contact");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rscontact = $tNGs->getRecordset("contact");
$row_rscontact = mysql_fetch_assoc($rscontact);
$totalRows_rscontact = mysql_num_rows($rscontact);
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
if (@$_GET['ID_contact'] == "") {
?>
              <?php echo NXT_getResource("Insert_FH"); ?>
              <?php 
// else Conditional region1
} else { ?>
              <?php echo NXT_getResource("Update_FH"); ?>
              <?php } 
// endif Conditional region1
?>
            Chi tiết nội dung liên hệ </h1>
          <div class="KT_tngform">
            <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
              <?php $cnt1 = 0; ?>
              <?php do { ?>
                <?php $cnt1++; ?>
                <?php 
// Show IF Conditional region1 
if (@$totalRows_rscontact > 1) {
?>
                  <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
                  <?php } 
// endif Conditional region1
?>
                <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                  <tr>
                    <td class="KT_th"><label for="contactfullname_<?php echo $cnt1; ?>">Họ tên:</label></td>
                    <td><input type="text" name="contactfullname_<?php echo $cnt1; ?>" id="contactfullname_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontact['contactfullname']); ?>" size="32" maxlength="68" />
                      <?php echo $tNGs->displayFieldHint("contactfullname");?> <?php echo $tNGs->displayFieldError("contact", "contactfullname", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="contactemail_<?php echo $cnt1; ?>">Email:</label></td>
                    <td><input type="text" name="contactemail_<?php echo $cnt1; ?>" id="contactemail_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontact['contactemail']); ?>" size="32" maxlength="168" />
                      <?php echo $tNGs->displayFieldHint("contactemail");?> <?php echo $tNGs->displayFieldError("contact", "contactemail", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="contactphonenumber_<?php echo $cnt1; ?>">Điện thoại:</label></td>
                    <td><input type="text" name="contactphonenumber_<?php echo $cnt1; ?>" id="contactphonenumber_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontact['contactphonenumber']); ?>" size="26" maxlength="26" />
                      <?php echo $tNGs->displayFieldHint("contactphonenumber");?> <?php echo $tNGs->displayFieldError("contact", "contactphonenumber", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="contactaddress_<?php echo $cnt1; ?>">Địa chỉ:</label></td>
                    <td><input type="text" name="contactaddress_<?php echo $cnt1; ?>" id="contactaddress_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rscontact['contactaddress']); ?>" size="32" maxlength="168" />
                      <?php echo $tNGs->displayFieldHint("contactaddress");?> <?php echo $tNGs->displayFieldError("contact", "contactaddress", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="contactcontent_<?php echo $cnt1; ?>">Nội dung:</label></td>
                    <td><textarea name="contactcontent_<?php echo $cnt1; ?>" id="contactcontent_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rscontact['contactcontent']); ?></textarea>
                      <?php echo $tNGs->displayFieldHint("contactcontent");?> <?php echo $tNGs->displayFieldError("contact", "contactcontent", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th">Ngày:</td>
                    <td><?php echo KT_formatDate($row_rscontact['contactdate']); ?></td>
                  </tr>
                </table>
                <input type="hidden" name="kt_pk_contact_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rscontact['kt_pk_contact']); ?>" />
                <?php } while ($row_rscontact = mysql_fetch_assoc($rscontact)); ?>
              <div class="KT_bottombuttons">
                <div>
                  <?php 
      // Show IF Conditional region1
      if (@$_GET['ID_contact'] == "") {
      ?>
                    <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
                    <?php 
      // else Conditional region1
      } else { ?>
                    <div class="KT_operations">
                      <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'ID_contact')" />
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