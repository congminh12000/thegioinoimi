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

//start Trigger_SetOrderColumn trigger
//remove this line if you want to edit the code by hand 
function Trigger_SetOrderColumn(&$tNG) {
  $orderFieldObj = new tNG_SetOrderField($tNG);
  $orderFieldObj->setFieldName("productorderlist");
  return $orderFieldObj->Execute();
}
//end Trigger_SetOrderColumn trigger

//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileDelete(&$tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../images/product/");
  $deleteObj->setDbFieldName("productimg");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_ImageUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_ImageUpload(&$tNG) {
  $uploadObj = new tNG_ImageUpload($tNG);
  $uploadObj->setFormFieldName("productimg");
  $uploadObj->setDbFieldName("productimg");
  $uploadObj->setFolder("../images/product/");
  $uploadObj->setResize("true", 220, 0);
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
$query_rs_danhmuc1 = "SELECT ID_menubar1, menubar1name FROM menubar1 WHERE ID_menubar1 = 3";
$rs_danhmuc1 = mysql_query($query_rs_danhmuc1, $cnn_hoaly) or die(mysql_error());
$row_rs_danhmuc1 = mysql_fetch_assoc($rs_danhmuc1);
$totalRows_rs_danhmuc1 = mysql_num_rows($rs_danhmuc1);

mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
$query_rs_danhmuc2 = "SELECT ID_menubar2, menubar2name, ID_menubar1 FROM menubar2 WHERE ID_menubar1 = 3 ORDER BY menubar2orderlist ASC";
$rs_danhmuc2 = mysql_query($query_rs_danhmuc2, $cnn_hoaly) or die(mysql_error());
$row_rs_danhmuc2 = mysql_fetch_assoc($rs_danhmuc2);
$totalRows_rs_danhmuc2 = mysql_num_rows($rs_danhmuc2);

// Make an insert transaction instance
$ins_product = new tNG_multipleInsert($conn_cnn_hoaly);
$tNGs->addTransaction($ins_product);
// Register triggers
$ins_product->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_product->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_product->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_product->registerTrigger("BEFORE", "Trigger_SetOrderColumn", 50);
$ins_product->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$ins_product->setTable("product");
$ins_product->addColumn("ID_danhmuc1", "NUMERIC_TYPE", "POST", "ID_danhmuc1");
$ins_product->addColumn("ID_danhmuc2", "NUMERIC_TYPE", "POST", "ID_danhmuc2");
$ins_product->addColumn("productname", "STRING_TYPE", "POST", "productname");
$ins_product->addColumn("productname_EN", "STRING_TYPE", "POST", "productname_EN");
$ins_product->addColumn("productimg", "FILE_TYPE", "FILES", "productimg");
$ins_product->addColumn("productmaterial", "STRING_TYPE", "POST", "productmaterial");
$ins_product->addColumn("productmaterial_EN", "STRING_TYPE", "POST", "productmaterial_EN");
$ins_product->addColumn("productcolor", "STRING_TYPE", "POST", "productcolor");
$ins_product->addColumn("productcolor_EN", "STRING_TYPE", "POST", "productcolor_EN");
$ins_product->addColumn("productprice", "NUMERIC_TYPE", "POST", "productprice");
$ins_product->addColumn("productkind", "NUMERIC_TYPE", "POST", "productkind");
$ins_product->addColumn("productdetail", "STRING_TYPE", "POST", "productdetail");
$ins_product->addColumn("productdetail_EN", "STRING_TYPE", "POST", "productdetail_EN");
$ins_product->addColumn("productapproval", "CHECKBOX_1_0_TYPE", "POST", "productapproval", "0");
$ins_product->addColumn("ID_account", "NUMERIC_TYPE", "POST", "ID_account", "{SESSION.kt_login_id}");
$ins_product->setPrimaryKey("ID_product", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_product = new tNG_multipleUpdate($conn_cnn_hoaly);
$tNGs->addTransaction($upd_product);
// Register triggers
$upd_product->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_product->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_product->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_product->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$upd_product->setTable("product");
$upd_product->addColumn("ID_danhmuc1", "NUMERIC_TYPE", "POST", "ID_danhmuc1");
$upd_product->addColumn("ID_danhmuc2", "NUMERIC_TYPE", "POST", "ID_danhmuc2");
$upd_product->addColumn("productname", "STRING_TYPE", "POST", "productname");
$upd_product->addColumn("productname_EN", "STRING_TYPE", "POST", "productname_EN");
$upd_product->addColumn("productimg", "FILE_TYPE", "FILES", "productimg");
$upd_product->addColumn("productmaterial", "STRING_TYPE", "POST", "productmaterial");
$upd_product->addColumn("productmaterial_EN", "STRING_TYPE", "POST", "productmaterial_EN");
$upd_product->addColumn("productcolor", "STRING_TYPE", "POST", "productcolor");
$upd_product->addColumn("productcolor_EN", "STRING_TYPE", "POST", "productcolor_EN");
$upd_product->addColumn("productprice", "NUMERIC_TYPE", "POST", "productprice");
$upd_product->addColumn("productkind", "NUMERIC_TYPE", "POST", "productkind");
$upd_product->addColumn("productdetail", "STRING_TYPE", "POST", "productdetail");
$upd_product->addColumn("productdetail_EN", "STRING_TYPE", "POST", "productdetail_EN");
$upd_product->addColumn("productapproval", "CHECKBOX_1_0_TYPE", "POST", "productapproval");
$upd_product->addColumn("ID_account", "NUMERIC_TYPE", "POST", "ID_account");
$upd_product->setPrimaryKey("ID_product", "NUMERIC_TYPE", "GET", "ID_product");

// Make an instance of the transaction object
$del_product = new tNG_multipleDelete($conn_cnn_hoaly);
$tNGs->addTransaction($del_product);
// Register triggers
$del_product->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_product->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$del_product->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_product->setTable("product");
$del_product->setPrimaryKey("ID_product", "NUMERIC_TYPE", "GET", "ID_product");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproduct = $tNGs->getRecordset("product");
$row_rsproduct = mysql_fetch_assoc($rsproduct);
$totalRows_rsproduct = mysql_num_rows($rsproduct);
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
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
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
if (@$_GET['ID_product'] == "") {
?>
              <?php echo NXT_getResource("Insert_FH"); ?>
              <?php 
// else Conditional region1
} else { ?>
              <?php echo NXT_getResource("Update_FH"); ?>
              <?php } 
// endif Conditional region1
?>
            Chi tiết sản phẩm </h1>
          <div class="KT_tngform">
            <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
              <?php $cnt1 = 0; ?>
              <?php do { ?>
                <?php $cnt1++; ?>
                <?php 
// Show IF Conditional region1 
if (@$totalRows_rsproduct > 1) {
?>
                  <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
                  <?php } 
// endif Conditional region1
?>
                <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                  <tr>
                    <td width="36%" class="KT_th"><label for="ID_danhmuc1_<?php echo $cnt1; ?>">Danh mục 1:</label></td>
                    <td colspan="2"><select name="ID_danhmuc1_<?php echo $cnt1; ?>" id="ID_danhmuc1_<?php echo $cnt1; ?>">
                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                      <?php 
do {  
?>
                      <option value="<?php echo $row_rs_danhmuc1['ID_menubar1']?>"<?php if (!(strcmp($row_rs_danhmuc1['ID_menubar1'], $row_rsproduct['ID_danhmuc1']))) {echo "SELECTED";} ?>><?php echo $row_rs_danhmuc1['menubar1name']?></option>
                      <?php
} while ($row_rs_danhmuc1 = mysql_fetch_assoc($rs_danhmuc1));
  $rows = mysql_num_rows($rs_danhmuc1);
  if($rows > 0) {
      mysql_data_seek($rs_danhmuc1, 0);
	  $row_rs_danhmuc1 = mysql_fetch_assoc($rs_danhmuc1);
  }
?>
                    </select>
                      <?php echo $tNGs->displayFieldError("product", "ID_danhmuc1", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="ID_danhmuc2_<?php echo $cnt1; ?>">Danh mục 2:</label></td>
                    <td colspan="2"><select name="ID_danhmuc2_<?php echo $cnt1; ?>" id="ID_danhmuc2_<?php echo $cnt1; ?>" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rs_danhmuc2" wdg:displayfield="menubar2name" wdg:valuefield="ID_menubar2" wdg:fkey="ID_menubar1" wdg:triggerobject="ID_danhmuc1_<?php echo $cnt1; ?>" wdg:selected="<?php echo $row_rsproduct['ID_danhmuc2'] ?>">
                      <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
                    </select>
                      <?php echo $tNGs->displayFieldError("product", "ID_danhmuc2", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="productname_<?php echo $cnt1; ?>">Sản phẩm:</label></td>
                    <td colspan="2"><input type="text" name="productname_<?php echo $cnt1; ?>" id="productname_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsproduct['productname']); ?>" size="32" maxlength="68" />
                      <?php echo $tNGs->displayFieldHint("productname");?> <?php echo $tNGs->displayFieldError("product", "productname", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="productname_EN_<?php echo $cnt1; ?>">Sản phẩm (tiếng Anh):</label></td>
                    <td colspan="2"><input type="text" name="productname_EN_<?php echo $cnt1; ?>" id="productname_EN_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsproduct['productname_EN']); ?>" size="32" maxlength="68" />
                      <?php echo $tNGs->displayFieldHint("productname_EN");?> <?php echo $tNGs->displayFieldError("product", "productname_EN", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="productimg_<?php echo $cnt1; ?>">Hình sản phẩm:</label>
                    <br>(220x300 pixels)</td>
                    <td width="36%"><input type="file" name="productimg_<?php echo $cnt1; ?>" id="productimg_<?php echo $cnt1; ?>" size="32" />
                      <?php echo $tNGs->displayFieldError("product", "productimg", $cnt1); ?></td>
                    <td width="28%"><?php 
						// Show If File Exists (region4)
						if (tNG_fileExists("../images/product/", "{rsproduct.productimg}")) {
						?>
												<img src="<?php echo tNG_showDynamicImage("../", "../images/product/", "{rsproduct.productimg}");?>" width="100px" />
												<?php 
						// else File Exists (region4)
												} else { ?>
												  <img src="p7csspbm2/img/product.png" width="100px">
						<?php } 
						// EndIf File Exists (region4)
						?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="productmaterial_<?php echo $cnt1; ?>">Chất liệu:</label></td>
                    <td colspan="2"><input type="text" name="productmaterial_<?php echo $cnt1; ?>" id="productmaterial_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsproduct['productmaterial']); ?>" size="32" maxlength="68" />
                      <?php echo $tNGs->displayFieldHint("productmaterial");?> <?php echo $tNGs->displayFieldError("product", "productmaterial", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="productmaterial_EN_<?php echo $cnt1; ?>">Chất liệu (tiếng Anh):</label></td>
                    <td colspan="2"><input type="text" name="productmaterial_EN_<?php echo $cnt1; ?>" id="productmaterial_EN_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsproduct['productmaterial_EN']); ?>" size="32" maxlength="68" />
                      <?php echo $tNGs->displayFieldHint("productmaterial_EN");?> <?php echo $tNGs->displayFieldError("product", "productmaterial_EN", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="productcolor_<?php echo $cnt1; ?>">Màu sắc:</label></td>
                    <td colspan="2"><input type="text" name="productcolor_<?php echo $cnt1; ?>" id="productcolor_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsproduct['productcolor']); ?>" size="32" maxlength="68" />
                      <?php echo $tNGs->displayFieldHint("productcolor");?> <?php echo $tNGs->displayFieldError("product", "productcolor", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="productcolor_EN_<?php echo $cnt1; ?>">Màu sắc (tiếng Anh):</label></td>
                    <td colspan="2"><input type="text" name="productcolor_EN_<?php echo $cnt1; ?>" id="productcolor_EN_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsproduct['productcolor_EN']); ?>" size="32" maxlength="68" />
                      <?php echo $tNGs->displayFieldHint("productcolor_EN");?> <?php echo $tNGs->displayFieldError("product", "productcolor_EN", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="productprice_<?php echo $cnt1; ?>">Giá công khai:<br>
                      (Viết liền không dấu)
                    </label></td>
                    <td colspan="2"><input type="text" name="productprice_<?php echo $cnt1; ?>" id="productprice_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsproduct['productprice']); ?>" size="7" />
                      <?php echo $tNGs->displayFieldHint("productprice");?> <?php echo $tNGs->displayFieldError("product", "productprice", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="productkind_<?php echo $cnt1; ?>">Loại mi:<br>(Chỉ điền cho sản phẩm MI NỐI)
                    </label></td>
                    <td colspan="2"><select name="productkind_<?php echo $cnt1; ?>" id="productkind_<?php echo $cnt1; ?>">
                      <option value="0" <?php if (!(strcmp(0, KT_escapeAttribute($row_rsproduct['productkind'])))) {echo "SELECTED";} ?>>None</option>
                      <option value="1" <?php if (!(strcmp(1, KT_escapeAttribute($row_rsproduct['productkind'])))) {echo "SELECTED";} ?>>Dầy</option>
                      <option value="2" <?php if (!(strcmp(2, KT_escapeAttribute($row_rsproduct['productkind'])))) {echo "SELECTED";} ?>>Cong</option>
                      <option value="3" <?php if (!(strcmp(3, KT_escapeAttribute($row_rsproduct['productkind'])))) {echo "SELECTED";} ?>>Dài</option>
                    </select>
                      <?php echo $tNGs->displayFieldError("product", "productkind", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="productdetail_<?php echo $cnt1; ?>">Chi tiết sản phẩm:</label></td>
                    <td colspan="2"><textarea name="productdetail_<?php echo $cnt1; ?>" id="productdetail_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsproduct['productdetail']); ?></textarea>
                    	 <script type="text/javascript">
							CKEDITOR.replace('productdetail_<?php echo $cnt1; ?>', {extraPlugins: 'imageuploader'});
						</script>
                      <?php echo $tNGs->displayFieldHint("productdetail");?> <?php echo $tNGs->displayFieldError("product", "productdetail", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="productdetail_EN_<?php echo $cnt1; ?>">Chi tiết sản phẩm (tiếng Anh):</label></td>
                    <td colspan="2"><textarea name="productdetail_EN_<?php echo $cnt1; ?>" id="productdetail_EN_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsproduct['productdetail_EN']); ?></textarea>
                    <script type="text/javascript">
							CKEDITOR.replace('productdetail_EN_<?php echo $cnt1; ?>', {extraPlugins: 'imageuploader'});
						</script>
                      <?php echo $tNGs->displayFieldHint("productdetail_EN");?> <?php echo $tNGs->displayFieldError("product", "productdetail_EN", $cnt1); ?></td>
                  </tr>
                  <tr>
                    <td class="KT_th"><label for="productapproval_<?php echo $cnt1; ?>">Duyệt:</label></td>
                    <td colspan="2"><input  <?php if (!(strcmp(KT_escapeAttribute($row_rsproduct['productapproval']),"1"))) {echo "checked";} ?> type="checkbox" name="productapproval_<?php echo $cnt1; ?>" id="productapproval_<?php echo $cnt1; ?>" value="1" />
                      <?php echo $tNGs->displayFieldError("product", "productapproval", $cnt1); ?></td>
                  </tr>
                </table>
                <input type="hidden" name="kt_pk_product_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsproduct['kt_pk_product']); ?>" />
                <input type="hidden" name="ID_account_<?php echo $cnt1; ?>" id="ID_account_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsproduct['ID_account']); ?>" />
                <?php } while ($row_rsproduct = mysql_fetch_assoc($rsproduct)); ?>
              <div class="KT_bottombuttons">
                <div>
                  <?php 
      // Show IF Conditional region1
      if (@$_GET['ID_product'] == "") {
      ?>
                    <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
                    <?php 
      // else Conditional region1
      } else { ?>
                    <div class="KT_operations">
                      <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'ID_product')" />
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
<?php
mysql_free_result($rs_danhmuc1);
mysql_free_result($rs_danhmuc2);
?>