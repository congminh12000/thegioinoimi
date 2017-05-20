<?php require_once('../Connections/cnn_hoaly.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');
 session_start();?>
<?php
// Require the MXI classes
require_once ('../includes/mxi/MXI.php');

// Load the required classes
require_once('../includes/tor/TOR.php');
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

// Order
$tor_listmenubar1 = new TOR_SetOrder($conn_cnn_hoaly, 'menubar1', 'ID_menubar1', 'NUMERIC_TYPE', 'menubar1orderlist', 'listmenubar1_menubar1orderlist_order');
$tor_listmenubar1->Execute();

// Filter
$tfi_listmenubar1 = new TFI_TableFilter($conn_cnn_hoaly, "tfi_listmenubar1");
$tfi_listmenubar1->addColumn("menubar1.menubar1name", "STRING_TYPE", "menubar1name", "%");
$tfi_listmenubar1->addColumn("menubar1.menubar1visible", "NUMERIC_TYPE", "menubar1visible", "=");
$tfi_listmenubar1->addColumn("menubar1.menubar1link", "NUMERIC_TYPE", "menubar1link", "=");
$tfi_listmenubar1->Execute();

// Sorter
$tso_listmenubar1 = new TSO_TableSorter("rsmenubar1", "tso_listmenubar1");
$tso_listmenubar1->addColumn("menubar1.menubar1orderlist"); // Order column
$tso_listmenubar1->setDefault("menubar1.menubar1orderlist");
$tso_listmenubar1->Execute();

// Navigation
$nav_listmenubar1 = new NAV_Regular("nav_listmenubar1", "rsmenubar1", "../", $_SERVER['PHP_SELF'], 10);

//NeXTenesio3 Special List Recordset
$maxRows_rsmenubar1 = $_SESSION['max_rows_nav_listmenubar1'];
$pageNum_rsmenubar1 = 0;
if (isset($_GET['pageNum_rsmenubar1'])) {
  $pageNum_rsmenubar1 = $_GET['pageNum_rsmenubar1'];
}
$startRow_rsmenubar1 = $pageNum_rsmenubar1 * $maxRows_rsmenubar1;

// Defining List Recordset variable
$NXTFilter_rsmenubar1 = "1=1";
if (isset($_SESSION['filter_tfi_listmenubar1'])) {
  $NXTFilter_rsmenubar1 = $_SESSION['filter_tfi_listmenubar1'];
}
// Defining List Recordset variable
$NXTSort_rsmenubar1 = "menubar1.menubar1orderlist";
if (isset($_SESSION['sorter_tso_listmenubar1'])) {
  $NXTSort_rsmenubar1 = $_SESSION['sorter_tso_listmenubar1'];
}
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

$query_rsmenubar1 = "SELECT menubar1.menubar1name, menubar1.menubar1visible, menubar1.menubar1link, menubar1.ID_menubar1, menubar1.menubar1orderlist FROM menubar1 WHERE {$NXTFilter_rsmenubar1} ORDER BY {$NXTSort_rsmenubar1}";
$query_limit_rsmenubar1 = sprintf("%s LIMIT %d, %d", $query_rsmenubar1, $startRow_rsmenubar1, $maxRows_rsmenubar1);
$rsmenubar1 = mysql_query($query_limit_rsmenubar1, $cnn_hoaly) or die(mysql_error());
$row_rsmenubar1 = mysql_fetch_assoc($rsmenubar1);

if (isset($_GET['totalRows_rsmenubar1'])) {
  $totalRows_rsmenubar1 = $_GET['totalRows_rsmenubar1'];
} else {
  $all_rsmenubar1 = mysql_query($query_rsmenubar1);
  $totalRows_rsmenubar1 = mysql_num_rows($all_rsmenubar1);
}
$totalPages_rsmenubar1 = ceil($totalRows_rsmenubar1/$maxRows_rsmenubar1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listmenubar1->checkBoundries();
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
  .KT_col_menubar1name {width:100%; overflow:hidden;}
  .KT_col_menubar1visible {width:100%; overflow:hidden;}
  .KT_col_menubar1link {width:100%; overflow:hidden;}
</style>
<?php echo $tor_listmenubar1->scriptDefinition(); ?>
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
        <div class="KT_tng" id="listmenubar1">
          <h1> Quản lý Danh mục 1
            <?php
  $nav_listmenubar1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
          </h1>
          <div class="KT_tnglist">
            <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
              <div class="KT_options"> <a href="<?php echo $nav_listmenubar1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
                <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listmenubar1'] == 1) {
?>
                  <?php echo $_SESSION['default_max_rows_nav_listmenubar1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listmenubar1'] == 1) {
?>
                  <a href="<?php echo $tfi_listmenubar1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listmenubar1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
              </div>
              <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                <thead>
                  <tr class="KT_row_order">
                    <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
                    </th>
                    <th id="menubar1name" class="KT_col_menubar1name">Danh mục</th>
                    <th id="menubar1visible" class="KT_col_menubar1visible">Ẩn/Hiện</th>
                    <th id="menubar1link" class="KT_col_menubar1link">Link</th>
                    <th id="menubar1orderlist" class="KT_sorter <?php echo $tso_listmenubar1->getSortIcon('menubar1.menubar1orderlist'); ?> KT_order"> <a href="<?php echo $tso_listmenubar1->getSortLink('menubar1.menubar1orderlist'); ?>"><?php echo NXT_getResource("Sắp xếp"); ?></a> <a class="KT_move_op_link" href="#" onClick="nxt_list_move_link_form(this); return false;"><?php echo NXT_getResource("save"); ?></a> </th>
                    <th>&nbsp;</th>
                  </tr>
                  <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listmenubar1'] == 1) {
?>
                    <tr class="KT_row_filter">
                      <td>&nbsp;</td>
                      <td><input type="text" name="tfi_listmenubar1_menubar1name" id="tfi_listmenubar1_menubar1name" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listmenubar1_menubar1name']); ?>" size="20" maxlength="68" /></td>
                      <td><input type="text" name="tfi_listmenubar1_menubar1visible" id="tfi_listmenubar1_menubar1visible" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listmenubar1_menubar1visible']); ?>" size="20" maxlength="100" /></td>
                      <td><input type="text" name="tfi_listmenubar1_menubar1link" id="tfi_listmenubar1_menubar1link" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listmenubar1_menubar1link']); ?>" size="20" maxlength="100" /></td>
                      <td>&nbsp;</td>
                      <td><input type="submit" name="tfi_listmenubar1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
                    </tr>
                    <?php } 
  // endif Conditional region3
?>
                </thead>
                <tbody>
                  <?php if ($totalRows_rsmenubar1 == 0) { // Show if recordset empty ?>
                    <tr>
                      <td colspan="6"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
                    </tr>
                    <?php } // Show if recordset empty ?>
                  <?php if ($totalRows_rsmenubar1 > 0) { // Show if recordset not empty ?>
                    <?php do { ?>
                      <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                        <td><input type="checkbox" name="kt_pk_menubar1" class="id_checkbox" value="<?php echo $row_rsmenubar1['ID_menubar1']; ?>" />
                          <input type="hidden" name="ID_menubar1" class="id_field" value="<?php echo $row_rsmenubar1['ID_menubar1']; ?>" /></td>
                        <td><div class="KT_col_menubar1name"><?php echo KT_FormatForList($row_rsmenubar1['menubar1name'], 26); ?></div></td>
                        <td><div class="KT_col_menubar1visible">
                          <?php 
							// Show IF Conditional region4 
							if (@$row_rsmenubar1['menubar1visible'] == 1) {
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
                        <td><div class="KT_col_menubar1link">
                          <?php 
							// Show IF Conditional region5 
							if (@$row_rsmenubar1['menubar1link'] == 1) {
							?>
														<img src="p7csspbm2/img/icon-yes.png" width="16" height="16">
														<?php 
							// else Conditional region5
							} else { ?>
														<img src="p7csspbm2/img/icon-no.png" width="16" height="16">
							  <?php } 
							// endif Conditional region5
							?>
                        </div></td>
                        <td class="KT_order"><input type="hidden" class="KT_orderhidden" name="<?php echo $tor_listmenubar1->getOrderFieldName() ?>" value="<?php echo $tor_listmenubar1->getOrderFieldValue($row_rsmenubar1) ?>" />
                          <a class="KT_movedown_link" href="#move_down">v</a> <a class="KT_moveup_link" href="#move_up">^</a></td>
<td><a class="KT_edit_link" href="form_danhmuc1.php?ID_menubar1=<?php echo $row_rsmenubar1['ID_menubar1']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a></td>
                      </tr>
                      <?php } while ($row_rsmenubar1 = mysql_fetch_assoc($rsmenubar1)); ?>
                    <?php } // Show if recordset not empty ?>
                </tbody>
              </table>
              <div class="KT_bottomnav">
                <div>
                  <?php
            $nav_listmenubar1->Prepare();
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
                <a class="KT_additem_op_link" href="form_danhmuc1.php?KT_back=1" onClick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
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
mysql_free_result($rsmenubar1);
?>