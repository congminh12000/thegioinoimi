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
$tfi_listtinhthanh1 = new TFI_TableFilter($conn_cnn_hoaly, "tfi_listtinhthanh1");
$tfi_listtinhthanh1->addColumn("tinhthanh.tentinhthanh", "STRING_TYPE", "tentinhthanh", "%");
$tfi_listtinhthanh1->addColumn("tinhthanh.tinhthanhvisible", "NUMERIC_TYPE", "tinhthanhvisible", "=");
$tfi_listtinhthanh1->Execute();

// Sorter
$tso_listtinhthanh1 = new TSO_TableSorter("rstinhthanh1", "tso_listtinhthanh1");
$tso_listtinhthanh1->addColumn("tinhthanh.tentinhthanh");
$tso_listtinhthanh1->addColumn("tinhthanh.tinhthanhvisible");
$tso_listtinhthanh1->setDefault("tinhthanh.tentinhthanh");
$tso_listtinhthanh1->Execute();

// Navigation
$nav_listtinhthanh1 = new NAV_Regular("nav_listtinhthanh1", "rstinhthanh1", "../", $_SERVER['PHP_SELF'], 10);

//NeXTenesio3 Special List Recordset
$maxRows_rstinhthanh1 = $_SESSION['max_rows_nav_listtinhthanh1'];
$pageNum_rstinhthanh1 = 0;
if (isset($_GET['pageNum_rstinhthanh1'])) {
  $pageNum_rstinhthanh1 = $_GET['pageNum_rstinhthanh1'];
}
$startRow_rstinhthanh1 = $pageNum_rstinhthanh1 * $maxRows_rstinhthanh1;

// Defining List Recordset variable
$NXTFilter_rstinhthanh1 = "1=1";
if (isset($_SESSION['filter_tfi_listtinhthanh1'])) {
  $NXTFilter_rstinhthanh1 = $_SESSION['filter_tfi_listtinhthanh1'];
}
// Defining List Recordset variable
$NXTSort_rstinhthanh1 = "tinhthanh.tentinhthanh";
if (isset($_SESSION['sorter_tso_listtinhthanh1'])) {
  $NXTSort_rstinhthanh1 = $_SESSION['sorter_tso_listtinhthanh1'];
}
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

$query_rstinhthanh1 = "SELECT tinhthanh.tentinhthanh, tinhthanh.tinhthanhvisible, tinhthanh.ID_tinhthanh FROM tinhthanh WHERE {$NXTFilter_rstinhthanh1} ORDER BY {$NXTSort_rstinhthanh1}";
$query_limit_rstinhthanh1 = sprintf("%s LIMIT %d, %d", $query_rstinhthanh1, $startRow_rstinhthanh1, $maxRows_rstinhthanh1);
$rstinhthanh1 = mysql_query($query_limit_rstinhthanh1, $cnn_hoaly) or die(mysql_error());
$row_rstinhthanh1 = mysql_fetch_assoc($rstinhthanh1);

if (isset($_GET['totalRows_rstinhthanh1'])) {
  $totalRows_rstinhthanh1 = $_GET['totalRows_rstinhthanh1'];
} else {
  $all_rstinhthanh1 = mysql_query($query_rstinhthanh1);
  $totalRows_rstinhthanh1 = mysql_num_rows($all_rstinhthanh1);
}
$totalPages_rstinhthanh1 = ceil($totalRows_rstinhthanh1/$maxRows_rstinhthanh1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listtinhthanh1->checkBoundries();
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
  .KT_col_tentinhthanh {width:100%; overflow:hidden;}
  .KT_col_tinhthanhvisible {width:100%; overflow:hidden;}
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
        <div class="KT_tng" id="listtinhthanh1">
          <h1> Quản lý tỉnh thành
            <?php
  $nav_listtinhthanh1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
          </h1>
          <div class="KT_tnglist">
            <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
              <div class="KT_options"> <a href="<?php echo $nav_listtinhthanh1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
                <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listtinhthanh1'] == 1) {
?>
                  <?php echo $_SESSION['default_max_rows_nav_listtinhthanh1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listtinhthanh1'] == 1) {
?>
                  <a href="<?php echo $tfi_listtinhthanh1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listtinhthanh1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
              </div>
              <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                <thead>
                  <tr class="KT_row_order">
                    <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
                    </th>
                    <th id="tentinhthanh" class="KT_sorter KT_col_tentinhthanh <?php echo $tso_listtinhthanh1->getSortIcon('tinhthanh.tentinhthanh'); ?>"> <a href="<?php echo $tso_listtinhthanh1->getSortLink('tinhthanh.tentinhthanh'); ?>">Tỉnh thành</a> </th>
                    <th id="tinhthanhvisible" class="KT_sorter KT_col_tinhthanhvisible <?php echo $tso_listtinhthanh1->getSortIcon('tinhthanh.tinhthanhvisible'); ?>"> <a href="<?php echo $tso_listtinhthanh1->getSortLink('tinhthanh.tinhthanhvisible'); ?>">Ẩn/Hiện</a> </th>
                    <th>&nbsp;</th>
                  </tr>
                  <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listtinhthanh1'] == 1) {
?>
                    <tr class="KT_row_filter">
                      <td>&nbsp;</td>
                      <td><input type="text" name="tfi_listtinhthanh1_tentinhthanh" id="tfi_listtinhthanh1_tentinhthanh" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtinhthanh1_tentinhthanh']); ?>" size="20" maxlength="68" /></td>
                      <td><input type="text" name="tfi_listtinhthanh1_tinhthanhvisible" id="tfi_listtinhthanh1_tinhthanhvisible" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listtinhthanh1_tinhthanhvisible']); ?>" size="20" maxlength="100" /></td>
                      <td><input type="submit" name="tfi_listtinhthanh1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
                    </tr>
                    <?php } 
  // endif Conditional region3
?>
                </thead>
                <tbody>
                  <?php if ($totalRows_rstinhthanh1 == 0) { // Show if recordset empty ?>
                    <tr>
                      <td colspan="4"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
                    </tr>
                    <?php } // Show if recordset empty ?>
                  <?php if ($totalRows_rstinhthanh1 > 0) { // Show if recordset not empty ?>
                    <?php do { ?>
                      <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                        <td><input type="checkbox" name="kt_pk_tinhthanh" class="id_checkbox" value="<?php echo $row_rstinhthanh1['ID_tinhthanh']; ?>" />
                          <input type="hidden" name="ID_tinhthanh" class="id_field" value="<?php echo $row_rstinhthanh1['ID_tinhthanh']; ?>" /></td>
                        <td><div class="KT_col_tentinhthanh"><?php echo KT_FormatForList($row_rstinhthanh1['tentinhthanh'], 68); ?></div></td>
                        <td><div class="KT_col_tinhthanhvisible">
                          <?php 
							// Show IF Conditional region4 
							if (@$row_rstinhthanh1['tinhthanhvisible'] == 1) {
							?>
														<img src="p7csspbm2/img/icon-yes.png" width="16" height="16">
														<?php 
							// else Conditional region4
							} else { ?>
														<img src="p7csspbm2/img/icon-no.png" width="16" height="16">
							  <?php } 
							// endif Conditional region4
							?>
                        </div></td>
<td><a class="KT_edit_link" href="form_tinhthanh.php?ID_tinhthanh=<?php echo $row_rstinhthanh1['ID_tinhthanh']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a></td>
                      </tr>
                      <?php } while ($row_rstinhthanh1 = mysql_fetch_assoc($rstinhthanh1)); ?>
                    <?php } // Show if recordset not empty ?>
                </tbody>
              </table>
              <div class="KT_bottomnav">
                <div>
                  <?php
            $nav_listtinhthanh1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
                </div>
              </div>
              <div class="KT_bottombuttons">
                <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onClick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onClick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a> </div>
                <span>&nbsp;</span>
                <select name="no_new" id="no_new">
                  <option value="1">1</option>
                  <option value="3">3</option>
                  <option value="6">6</option>
                </select>
                <a class="KT_additem_op_link" href="form_tinhthanh.php?KT_back=1" onClick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
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
mysql_free_result($rstinhthanh1);
?>