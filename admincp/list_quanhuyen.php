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
$tfi_listquanhuyen1 = new TFI_TableFilter($conn_cnn_hoaly, "tfi_listquanhuyen1");
$tfi_listquanhuyen1->addColumn("tinhthanh.ID_tinhthanh", "NUMERIC_TYPE", "ID_tinhthanh", "=");
$tfi_listquanhuyen1->addColumn("quanhuyen.tenquanhuyen", "STRING_TYPE", "tenquanhuyen", "%");
$tfi_listquanhuyen1->addColumn("quanhuyen.quanhuyenvisible", "NUMERIC_TYPE", "quanhuyenvisible", "=");
$tfi_listquanhuyen1->Execute();

// Sorter
$tso_listquanhuyen1 = new TSO_TableSorter("rsquanhuyen1", "tso_listquanhuyen1");
$tso_listquanhuyen1->addColumn("tinhthanh.tentinhthanh");
$tso_listquanhuyen1->addColumn("quanhuyen.tenquanhuyen");
$tso_listquanhuyen1->addColumn("quanhuyen.quanhuyenvisible");
$tso_listquanhuyen1->setDefault("quanhuyen.ID_tinhthanh");
$tso_listquanhuyen1->Execute();

// Navigation
$nav_listquanhuyen1 = new NAV_Regular("nav_listquanhuyen1", "rsquanhuyen1", "../", $_SERVER['PHP_SELF'], 10);

mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
$query_Recordset1 = "SELECT tentinhthanh, ID_tinhthanh FROM tinhthanh ORDER BY tentinhthanh";
$Recordset1 = mysql_query($query_Recordset1, $cnn_hoaly) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

//NeXTenesio3 Special List Recordset
$maxRows_rsquanhuyen1 = $_SESSION['max_rows_nav_listquanhuyen1'];
$pageNum_rsquanhuyen1 = 0;
if (isset($_GET['pageNum_rsquanhuyen1'])) {
  $pageNum_rsquanhuyen1 = $_GET['pageNum_rsquanhuyen1'];
}
$startRow_rsquanhuyen1 = $pageNum_rsquanhuyen1 * $maxRows_rsquanhuyen1;

// Defining List Recordset variable
$NXTFilter_rsquanhuyen1 = "1=1";
if (isset($_SESSION['filter_tfi_listquanhuyen1'])) {
  $NXTFilter_rsquanhuyen1 = $_SESSION['filter_tfi_listquanhuyen1'];
}
// Defining List Recordset variable
$NXTSort_rsquanhuyen1 = "quanhuyen.ID_tinhthanh";
if (isset($_SESSION['sorter_tso_listquanhuyen1'])) {
  $NXTSort_rsquanhuyen1 = $_SESSION['sorter_tso_listquanhuyen1'];
}
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

$query_rsquanhuyen1 = "SELECT tinhthanh.tentinhthanh AS ID_tinhthanh, quanhuyen.tenquanhuyen, quanhuyen.quanhuyenvisible, quanhuyen.ID_quanhuyen FROM quanhuyen LEFT JOIN tinhthanh ON quanhuyen.ID_tinhthanh = tinhthanh.ID_tinhthanh WHERE {$NXTFilter_rsquanhuyen1} ORDER BY {$NXTSort_rsquanhuyen1}";
$query_limit_rsquanhuyen1 = sprintf("%s LIMIT %d, %d", $query_rsquanhuyen1, $startRow_rsquanhuyen1, $maxRows_rsquanhuyen1);
$rsquanhuyen1 = mysql_query($query_limit_rsquanhuyen1, $cnn_hoaly) or die(mysql_error());
$row_rsquanhuyen1 = mysql_fetch_assoc($rsquanhuyen1);

if (isset($_GET['totalRows_rsquanhuyen1'])) {
  $totalRows_rsquanhuyen1 = $_GET['totalRows_rsquanhuyen1'];
} else {
  $all_rsquanhuyen1 = mysql_query($query_rsquanhuyen1);
  $totalRows_rsquanhuyen1 = mysql_num_rows($all_rsquanhuyen1);
}
$totalPages_rsquanhuyen1 = ceil($totalRows_rsquanhuyen1/$maxRows_rsquanhuyen1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listquanhuyen1->checkBoundries();
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
  .KT_col_ID_tinhthanh {width:100%; overflow:hidden;}
  .KT_col_tenquanhuyen {width:100%; overflow:hidden;}
  .KT_col_quanhuyenvisible {width:100%; overflow:hidden;}
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
        <div class="KT_tng" id="listquanhuyen1">
          <h1> Quản lý quận huyện
            <?php
  $nav_listquanhuyen1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
          </h1>
          <div class="KT_tnglist">
            <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
              <div class="KT_options"> <a href="<?php echo $nav_listquanhuyen1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
                <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listquanhuyen1'] == 1) {
?>
                  <?php echo $_SESSION['default_max_rows_nav_listquanhuyen1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listquanhuyen1'] == 1) {
?>
                  <a href="<?php echo $tfi_listquanhuyen1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listquanhuyen1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
              </div>
              <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                <thead>
                  <tr class="KT_row_order">
                    <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
                    </th>
                    <th id="ID_tinhthanh" class="KT_sorter KT_col_ID_tinhthanh <?php echo $tso_listquanhuyen1->getSortIcon('tinhthanh.tentinhthanh'); ?>"> <a href="<?php echo $tso_listquanhuyen1->getSortLink('tinhthanh.tentinhthanh'); ?>">Tỉnh thành</a> </th>
                    <th id="tenquanhuyen" class="KT_sorter KT_col_tenquanhuyen <?php echo $tso_listquanhuyen1->getSortIcon('quanhuyen.tenquanhuyen'); ?>"> <a href="<?php echo $tso_listquanhuyen1->getSortLink('quanhuyen.tenquanhuyen'); ?>">Quận huyện</a> </th>
                    <th id="quanhuyenvisible" class="KT_sorter KT_col_quanhuyenvisible <?php echo $tso_listquanhuyen1->getSortIcon('quanhuyen.quanhuyenvisible'); ?>"> <a href="<?php echo $tso_listquanhuyen1->getSortLink('quanhuyen.quanhuyenvisible'); ?>">Ẩn/Hiện</a> </th>
                    <th>&nbsp;</th>
                  </tr>
                  <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listquanhuyen1'] == 1) {
?>
                    <tr class="KT_row_filter">
                      <td>&nbsp;</td>
                      <td><select name="tfi_listquanhuyen1_ID_tinhthanh" id="tfi_listquanhuyen1_ID_tinhthanh">
                        <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listquanhuyen1_ID_tinhthanh']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                        <?php
do {  
?>
                        <option value="<?php echo $row_Recordset1['ID_tinhthanh']?>"<?php if (!(strcmp($row_Recordset1['ID_tinhthanh'], @$_SESSION['tfi_listquanhuyen1_ID_tinhthanh']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['tentinhthanh']?></option>
                        <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
                      </select></td>
                      <td><input type="text" name="tfi_listquanhuyen1_tenquanhuyen" id="tfi_listquanhuyen1_tenquanhuyen" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listquanhuyen1_tenquanhuyen']); ?>" size="20" maxlength="68" /></td>
                      <td><input type="text" name="tfi_listquanhuyen1_quanhuyenvisible" id="tfi_listquanhuyen1_quanhuyenvisible" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listquanhuyen1_quanhuyenvisible']); ?>" size="20" maxlength="100" /></td>
                      <td><input type="submit" name="tfi_listquanhuyen1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
                    </tr>
                    <?php } 
  // endif Conditional region3
?>
                </thead>
                <tbody>
                  <?php if ($totalRows_rsquanhuyen1 == 0) { // Show if recordset empty ?>
                    <tr>
                      <td colspan="5"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
                    </tr>
                    <?php } // Show if recordset empty ?>
                  <?php if ($totalRows_rsquanhuyen1 > 0) { // Show if recordset not empty ?>
                    <?php do { ?>
                      <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                        <td><input type="checkbox" name="kt_pk_quanhuyen" class="id_checkbox" value="<?php echo $row_rsquanhuyen1['ID_quanhuyen']; ?>" />
                          <input type="hidden" name="ID_quanhuyen" class="id_field" value="<?php echo $row_rsquanhuyen1['ID_quanhuyen']; ?>" /></td>
                        <td><div class="KT_col_ID_tinhthanh"><?php echo KT_FormatForList($row_rsquanhuyen1['ID_tinhthanh'], 36); ?></div></td>
                        <td><div class="KT_col_tenquanhuyen"><?php echo KT_FormatForList($row_rsquanhuyen1['tenquanhuyen'], 68); ?></div></td>
                        <td><div class="KT_col_quanhuyenvisible">
                          <?php 
							// Show IF Conditional region4 
							if (@$row_rsquanhuyen1['quanhuyenvisible'] == 1) {
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
<td><a class="KT_edit_link" href="form_quanhuyen.php?ID_quanhuyen=<?php echo $row_rsquanhuyen1['ID_quanhuyen']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a></td>
                      </tr>
                      <?php } while ($row_rsquanhuyen1 = mysql_fetch_assoc($rsquanhuyen1)); ?>
                    <?php } // Show if recordset not empty ?>
                </tbody>
              </table>
              <div class="KT_bottomnav">
                <div>
                  <?php
            $nav_listquanhuyen1->Prepare();
            require("../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
                </div>
              </div>
              <div class="KT_bottombuttons">
                <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a> </div>
                <span>&nbsp;</span>
                <select name="no_new" id="no_new">
                  <option value="1">1</option>
                  <option value="3">3</option>
                  <option value="6">6</option>
                </select>
                <a class="KT_additem_op_link" href="form_quanhuyen.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
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
mysql_free_result($Recordset1);
mysql_free_result($rsquanhuyen1);
?>