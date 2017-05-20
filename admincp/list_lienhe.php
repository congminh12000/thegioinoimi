<?php require_once('../Connections/cnn_hoaly.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');
 session_start();?>
<?php
// Require the MXI classes
require_once ('../includes/mxi/MXI.php');

// Load the required classes
require_once('../includes/tfi/TFI.php');
require_once('../includes/tso/TSO.php');
require_once('../includes/nav/NAV.php');

// Make unified connection variable
$conn_cnn_hoaly = new KT_connection($cnn_hoaly, $database_cnn_hoaly);

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

// Filter
$tfi_listcontact1 = new TFI_TableFilter($conn_cnn_hoaly, "tfi_listcontact1");
$tfi_listcontact1->addColumn("contact.contactfullname", "STRING_TYPE", "contactfullname", "%");
$tfi_listcontact1->addColumn("contact.contactemail", "STRING_TYPE", "contactemail", "%");
$tfi_listcontact1->addColumn("contact.contactphonenumber", "STRING_TYPE", "contactphonenumber", "%");
$tfi_listcontact1->addColumn("contact.contactdate", "DATE_TYPE", "contactdate", "=");
$tfi_listcontact1->Execute();

// Sorter
$tso_listcontact1 = new TSO_TableSorter("rscontact1", "tso_listcontact1");
$tso_listcontact1->addColumn("contact.contactfullname");
$tso_listcontact1->addColumn("contact.contactemail");
$tso_listcontact1->addColumn("contact.contactphonenumber");
$tso_listcontact1->addColumn("contact.contactdate");
$tso_listcontact1->setDefault("contact.contactdate DESC");
$tso_listcontact1->Execute();

// Navigation
$nav_listcontact1 = new NAV_Regular("nav_listcontact1", "rscontact1", "../", $_SERVER['PHP_SELF'], 10);

//NeXTenesio3 Special List Recordset
$maxRows_rscontact1 = $_SESSION['max_rows_nav_listcontact1'];
$pageNum_rscontact1 = 0;
if (isset($_GET['pageNum_rscontact1'])) {
  $pageNum_rscontact1 = $_GET['pageNum_rscontact1'];
}
$startRow_rscontact1 = $pageNum_rscontact1 * $maxRows_rscontact1;

// Defining List Recordset variable
$NXTFilter_rscontact1 = "1=1";
if (isset($_SESSION['filter_tfi_listcontact1'])) {
  $NXTFilter_rscontact1 = $_SESSION['filter_tfi_listcontact1'];
}
// Defining List Recordset variable
$NXTSort_rscontact1 = "contact.contactdate DESC";
if (isset($_SESSION['sorter_tso_listcontact1'])) {
  $NXTSort_rscontact1 = $_SESSION['sorter_tso_listcontact1'];
}
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

$query_rscontact1 = "SELECT contact.contactfullname, contact.contactemail, contact.contactphonenumber, contact.contactdate, contact.ID_contact FROM contact WHERE {$NXTFilter_rscontact1} ORDER BY {$NXTSort_rscontact1}";
$query_limit_rscontact1 = sprintf("%s LIMIT %d, %d", $query_rscontact1, $startRow_rscontact1, $maxRows_rscontact1);
$rscontact1 = mysql_query($query_limit_rscontact1, $cnn_hoaly) or die(mysql_error());
$row_rscontact1 = mysql_fetch_assoc($rscontact1);

if (isset($_GET['totalRows_rscontact1'])) {
  $totalRows_rscontact1 = $_GET['totalRows_rscontact1'];
} else {
  $all_rscontact1 = mysql_query($query_rscontact1);
  $totalRows_rscontact1 = mysql_num_rows($all_rscontact1);
}
$totalPages_rscontact1 = ceil($totalRows_rscontact1/$maxRows_rscontact1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listcontact1->checkBoundries();
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
<script src="../includes/nxt/scripts/list.js" type="text/javascript"></script>
<script src="../includes/nxt/scripts/list.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_LIST_SETTINGS = {
  duplicate_buttons: true,
  duplicate_navigation: true,
  row_effects: true,
  show_as_buttons: true,
  record_counter: true
}
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_contactfullname {width:100%; overflow:hidden;}
  .KT_col_contactemail {width:100%; overflow:hidden;}
  .KT_col_contactphonenumber {width:100%; overflow:hidden;}
  .KT_col_contactdate {width:100%; overflow:hidden;}
</style>
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
        <div class="KT_tng" id="listcontact1">
          <h1> Quản lý liên hệ khách hàng
            <?php
  $nav_listcontact1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
          </h1>
          <div class="KT_tnglist">
            <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
              <div class="KT_options"> <a href="<?php echo $nav_listcontact1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
                <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listcontact1'] == 1) {
?>
                  <?php echo $_SESSION['default_max_rows_nav_listcontact1']; ?>
                  <?php 
  // else Conditional region1
  } else { ?>
                  <?php echo NXT_getResource("all"); ?>
                  <?php } 
  // endif Conditional region1
?>
<?php echo NXT_getResource("records"); ?></a> &nbsp;
                &nbsp;
                <?php 
  // Show IF Conditional region2
  if (@$_SESSION['has_filter_tfi_listcontact1'] == 1) {
?>
                  <a href="<?php echo $tfi_listcontact1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listcontact1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
              </div>
              <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                <thead>
                  <tr class="KT_row_order">
                    <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
                    </th>
                    <th id="contactfullname" class="KT_sorter KT_col_contactfullname <?php echo $tso_listcontact1->getSortIcon('contact.contactfullname'); ?>"> <a href="<?php echo $tso_listcontact1->getSortLink('contact.contactfullname'); ?>">Họ tên</a> </th>
                    <th id="contactemail" class="KT_sorter KT_col_contactemail <?php echo $tso_listcontact1->getSortIcon('contact.contactemail'); ?>"> <a href="<?php echo $tso_listcontact1->getSortLink('contact.contactemail'); ?>">Email</a> </th>
                    <th id="contactphonenumber" class="KT_sorter KT_col_contactphonenumber <?php echo $tso_listcontact1->getSortIcon('contact.contactphonenumber'); ?>"> <a href="<?php echo $tso_listcontact1->getSortLink('contact.contactphonenumber'); ?>">Điện thoại</a> </th>
                    <th id="contactdate" class="KT_sorter KT_col_contactdate <?php echo $tso_listcontact1->getSortIcon('contact.contactdate'); ?>"> <a href="<?php echo $tso_listcontact1->getSortLink('contact.contactdate'); ?>">Ngày</a> </th>
                    <th>&nbsp;</th>
                  </tr>
                  <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listcontact1'] == 1) {
?>
                    <tr class="KT_row_filter">
                      <td>&nbsp;</td>
                      <td><input type="text" name="tfi_listcontact1_contactfullname" id="tfi_listcontact1_contactfullname" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listcontact1_contactfullname']); ?>" size="20" maxlength="68" /></td>
                      <td><input type="text" name="tfi_listcontact1_contactemail" id="tfi_listcontact1_contactemail" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listcontact1_contactemail']); ?>" size="20" maxlength="168" /></td>
                      <td><input type="text" name="tfi_listcontact1_contactphonenumber" id="tfi_listcontact1_contactphonenumber" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listcontact1_contactphonenumber']); ?>" size="20" maxlength="26" /></td>
                      <td><input type="text" name="tfi_listcontact1_contactdate" id="tfi_listcontact1_contactdate" value="<?php echo @$_SESSION['tfi_listcontact1_contactdate']; ?>" size="10" maxlength="22" /></td>
                      <td><input type="submit" name="tfi_listcontact1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
                    </tr>
                    <?php } 
  // endif Conditional region3
?>
                </thead>
                <tbody>
                  <?php if ($totalRows_rscontact1 == 0) { // Show if recordset empty ?>
                    <tr>
                      <td colspan="6"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
                    </tr>
                    <?php } // Show if recordset empty ?>
                  <?php if ($totalRows_rscontact1 > 0) { // Show if recordset not empty ?>
                    <?php do { ?>
                      <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                        <td><input type="checkbox" name="kt_pk_contact" class="id_checkbox" value="<?php echo $row_rscontact1['ID_contact']; ?>" />
                          <input type="hidden" name="ID_contact" class="id_field" value="<?php echo $row_rscontact1['ID_contact']; ?>" /></td>
                        <td><div class="KT_col_contactfullname"><?php echo KT_FormatForList($row_rscontact1['contactfullname'], 20); ?></div></td>
                        <td><div class="KT_col_contactemail"><?php echo KT_FormatForList($row_rscontact1['contactemail'], 20); ?></div></td>
                        <td><div class="KT_col_contactphonenumber"><?php echo KT_FormatForList($row_rscontact1['contactphonenumber'], 20); ?></div></td>
                        <td><div class="KT_col_contactdate"><?php echo KT_formatDate($row_rscontact1['contactdate']); ?></div></td>
                        <td><a class="KT_edit_link" href="form_lienhe.php?ID_contact=<?php echo $row_rscontact1['ID_contact']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a></td>
                      </tr>
                      <?php } while ($row_rscontact1 = mysql_fetch_assoc($rscontact1)); ?>
                    <?php } // Show if recordset not empty ?>
                </tbody>
              </table>
              <div class="KT_bottomnav">
                <div>
                  <?php
            $nav_listcontact1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
                </div>
              </div>
              <div class="KT_bottombuttons">
                <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a> </div>
                <span>&nbsp;</span>
                <select name="no_new" id="no_new">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                </select>
                <a class="KT_additem_op_link" href="form_lienhe.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
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
mysql_free_result($rscontact1);
?>