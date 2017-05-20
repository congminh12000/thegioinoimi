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
$tfi_listaccount1 = new TFI_TableFilter($conn_cnn_hoaly, "tfi_listaccount1");
$tfi_listaccount1->addColumn("account.username", "STRING_TYPE", "username", "%");
$tfi_listaccount1->addColumn("account.fullname", "STRING_TYPE", "fullname", "%");
$tfi_listaccount1->addColumn("account.email", "STRING_TYPE", "email", "%");
$tfi_listaccount1->addColumn("account.accesslevel", "NUMERIC_TYPE", "accesslevel", "=");
$tfi_listaccount1->addColumn("account.registereddate", "DATE_TYPE", "registereddate", "=");
$tfi_listaccount1->Execute();

// Sorter
$tso_listaccount1 = new TSO_TableSorter("rsaccount1", "tso_listaccount1");
$tso_listaccount1->addColumn("account.username");
$tso_listaccount1->addColumn("account.fullname");
$tso_listaccount1->addColumn("account.email");
$tso_listaccount1->addColumn("account.accesslevel");
$tso_listaccount1->addColumn("account.registereddate");
$tso_listaccount1->setDefault("account.registereddate DESC");
$tso_listaccount1->Execute();

// Navigation
$nav_listaccount1 = new NAV_Regular("nav_listaccount1", "rsaccount1", "../", $_SERVER['PHP_SELF'], 10);

//NeXTenesio3 Special List Recordset
$maxRows_rsaccount1 = $_SESSION['max_rows_nav_listaccount1'];
$pageNum_rsaccount1 = 0;
if (isset($_GET['pageNum_rsaccount1'])) {
  $pageNum_rsaccount1 = $_GET['pageNum_rsaccount1'];
}
$startRow_rsaccount1 = $pageNum_rsaccount1 * $maxRows_rsaccount1;

// Defining List Recordset variable
$NXTFilter_rsaccount1 = "1=1";
if (isset($_SESSION['filter_tfi_listaccount1'])) {
  $NXTFilter_rsaccount1 = $_SESSION['filter_tfi_listaccount1'];
}
// Defining List Recordset variable
$NXTSort_rsaccount1 = "account.registereddate DESC";
if (isset($_SESSION['sorter_tso_listaccount1'])) {
  $NXTSort_rsaccount1 = $_SESSION['sorter_tso_listaccount1'];
}
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

$query_rsaccount1 = "SELECT account.username, account.fullname, account.email, account.accesslevel, account.registereddate, account.ID_account FROM account WHERE {$NXTFilter_rsaccount1} ORDER BY {$NXTSort_rsaccount1}";
$query_limit_rsaccount1 = sprintf("%s LIMIT %d, %d", $query_rsaccount1, $startRow_rsaccount1, $maxRows_rsaccount1);
$rsaccount1 = mysql_query($query_limit_rsaccount1, $cnn_hoaly) or die(mysql_error());
$row_rsaccount1 = mysql_fetch_assoc($rsaccount1);

if (isset($_GET['totalRows_rsaccount1'])) {
  $totalRows_rsaccount1 = $_GET['totalRows_rsaccount1'];
} else {
  $all_rsaccount1 = mysql_query($query_rsaccount1);
  $totalRows_rsaccount1 = mysql_num_rows($all_rsaccount1);
}
$totalPages_rsaccount1 = ceil($totalRows_rsaccount1/$maxRows_rsaccount1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listaccount1->checkBoundries();
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
  record_counter: false
}
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_username {width:100%; overflow:hidden;}
  .KT_col_fullname {width:100%; overflow:hidden;}
  .KT_col_email {width:100%; overflow:hidden;}
  .KT_col_accesslevel {width:100%; overflow:hidden;}
  .KT_col_registereddate {width:100%; overflow:hidden;}
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
        <div class="KT_tng" id="listaccount1">
          <h1> Quản lý tài khoản
            <?php
  $nav_listaccount1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
          </h1>
          <div class="KT_tnglist">
            <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
              <div class="KT_options"> <a href="<?php echo $nav_listaccount1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
                <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listaccount1'] == 1) {
?>
                  <?php echo $_SESSION['default_max_rows_nav_listaccount1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listaccount1'] == 1) {
?>
                  <a href="<?php echo $tfi_listaccount1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listaccount1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
              </div>
              <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                <thead>
                  <tr class="KT_row_order">
                    <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
                    </th>
                    <th id="username" class="KT_sorter KT_col_username <?php echo $tso_listaccount1->getSortIcon('account.username'); ?>"> <a href="<?php echo $tso_listaccount1->getSortLink('account.username'); ?>">Username</a> </th>
                    <th id="fullname" class="KT_sorter KT_col_fullname <?php echo $tso_listaccount1->getSortIcon('account.fullname'); ?>"> <a href="<?php echo $tso_listaccount1->getSortLink('account.fullname'); ?>">Họ tên</a> </th>
                    <th id="email" class="KT_sorter KT_col_email <?php echo $tso_listaccount1->getSortIcon('account.email'); ?>"> <a href="<?php echo $tso_listaccount1->getSortLink('account.email'); ?>">Email</a> </th>
                    <th id="accesslevel" class="KT_sorter KT_col_accesslevel <?php echo $tso_listaccount1->getSortIcon('account.accesslevel'); ?>"> <a href="<?php echo $tso_listaccount1->getSortLink('account.accesslevel'); ?>">Quyền</a> </th>
                    <th id="registereddate" class="KT_sorter KT_col_registereddate <?php echo $tso_listaccount1->getSortIcon('account.registereddate'); ?>"> <a href="<?php echo $tso_listaccount1->getSortLink('account.registereddate'); ?>">Ngày ĐK</a> </th>
                    <th>&nbsp;</th>
                  </tr>
                  <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listaccount1'] == 1) {
?>
                    <tr class="KT_row_filter">
                      <td>&nbsp;</td>
                      <td><input type="text" name="tfi_listaccount1_username" id="tfi_listaccount1_username" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listaccount1_username']); ?>" size="20" maxlength="68" /></td>
                      <td><input type="text" name="tfi_listaccount1_fullname" id="tfi_listaccount1_fullname" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listaccount1_fullname']); ?>" size="20" maxlength="168" /></td>
                      <td><input type="text" name="tfi_listaccount1_email" id="tfi_listaccount1_email" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listaccount1_email']); ?>" size="20" maxlength="168" /></td>
                      <td><input type="text" name="tfi_listaccount1_accesslevel" id="tfi_listaccount1_accesslevel" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listaccount1_accesslevel']); ?>" size="20" maxlength="100" /></td>
                      <td><input type="text" name="tfi_listaccount1_registereddate" id="tfi_listaccount1_registereddate" value="<?php echo @$_SESSION['tfi_listaccount1_registereddate']; ?>" size="10" maxlength="22" /></td>
                      <td><input type="submit" name="tfi_listaccount1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
                    </tr>
                    <?php } 
  // endif Conditional region3
?>
                </thead>
                <tbody>
                  <?php if ($totalRows_rsaccount1 == 0) { // Show if recordset empty ?>
                    <tr>
                      <td colspan="7"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
                    </tr>
                    <?php } // Show if recordset empty ?>
                  <?php if ($totalRows_rsaccount1 > 0) { // Show if recordset not empty ?>
                    <?php do { ?>
                      <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                        <td><input type="checkbox" name="kt_pk_account" class="id_checkbox" value="<?php echo $row_rsaccount1['ID_account']; ?>" />
                          <input type="hidden" name="ID_account" class="id_field" value="<?php echo $row_rsaccount1['ID_account']; ?>" /></td>
                        <td><div class="KT_col_username"><?php echo KT_FormatForList($row_rsaccount1['username'], 20); ?></div></td>
                        <td><div class="KT_col_fullname"><?php echo KT_FormatForList($row_rsaccount1['fullname'], 20); ?></div></td>
                        <td><div class="KT_col_email"><?php echo KT_FormatForList($row_rsaccount1['email'], 20); ?></div></td>
                        <td><div class="KT_col_accesslevel"><b><?php 
							// Show IF Conditional region4 
							if (@$row_rsaccount1['accesslevel'] == 1) {
							?>
														Admin
														<?php 
							// else Conditional region4
							} else { ?>
														Guess
							  <?php } 
							// endif Conditional region4
							?>
                        </b></div></td>
                        <td><div class="KT_col_registereddate"><?php echo KT_formatDate($row_rsaccount1['registereddate']); ?></div></td>
<td><a class="KT_edit_link" href="form_taikhoan.php?ID_account=<?php echo $row_rsaccount1['ID_account']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a></td>
                      </tr>
                      <?php } while ($row_rsaccount1 = mysql_fetch_assoc($rsaccount1)); ?>
                    <?php } // Show if recordset not empty ?>
                </tbody>
              </table>
              <div class="KT_bottomnav">
                <div>
                  <?php
            $nav_listaccount1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
                </div>
              </div>
              <div class="KT_bottombuttons">
                <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onClick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onClick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a> </div>
                <span>&nbsp;</span>
                <select name="no_new" id="no_new">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                </select>
                <a class="KT_additem_op_link" href="form_taikhoan.php?KT_back=1" onClick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
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
mysql_free_result($rsaccount1);
?>