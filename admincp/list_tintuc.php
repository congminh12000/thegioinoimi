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
$tfi_listnews1 = new TFI_TableFilter($conn_cnn_hoaly, "tfi_listnews1");
$tfi_listnews1->addColumn("menubar1.ID_menubar1", "NUMERIC_TYPE", "ID_menubar1", "=");
$tfi_listnews1->addColumn("menubar2.ID_menubar2", "NUMERIC_TYPE", "ID_menubar2", "=");
$tfi_listnews1->addColumn("news.newstitle", "STRING_TYPE", "newstitle", "%");
$tfi_listnews1->addColumn("news.newsapproval", "NUMERIC_TYPE", "newsapproval", "=");
$tfi_listnews1->addColumn("news.newsdate", "DATE_TYPE", "newsdate", "=");
$tfi_listnews1->Execute();

// Sorter
$tso_listnews1 = new TSO_TableSorter("rsnews1", "tso_listnews1");
$tso_listnews1->addColumn("menubar1.menubar1name");
$tso_listnews1->addColumn("menubar2.menubar2name");
$tso_listnews1->addColumn("news.newstitle");
$tso_listnews1->addColumn("news.newsapproval");
$tso_listnews1->addColumn("news.newsdate");
$tso_listnews1->setDefault("news.newsdate DESC");
$tso_listnews1->Execute();

// Navigation
$nav_listnews1 = new NAV_Regular("nav_listnews1", "rsnews1", "../", $_SERVER['PHP_SELF'], 10);

mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
$query_Recordset1 = "SELECT menubar1name, ID_menubar1 FROM menubar1 ORDER BY menubar1name";
$Recordset1 = mysql_query($query_Recordset1, $cnn_hoaly) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
$query_Recordset2 = "SELECT menubar2name, ID_menubar2 FROM menubar2 ORDER BY menubar2name";
$Recordset2 = mysql_query($query_Recordset2, $cnn_hoaly) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

//NeXTenesio3 Special List Recordset
$maxRows_rsnews1 = $_SESSION['max_rows_nav_listnews1'];
$pageNum_rsnews1 = 0;
if (isset($_GET['pageNum_rsnews1'])) {
  $pageNum_rsnews1 = $_GET['pageNum_rsnews1'];
}
$startRow_rsnews1 = $pageNum_rsnews1 * $maxRows_rsnews1;

// Defining List Recordset variable
$NXTFilter_rsnews1 = "1=1";
if (isset($_SESSION['filter_tfi_listnews1'])) {
  $NXTFilter_rsnews1 = $_SESSION['filter_tfi_listnews1'];
}
// Defining List Recordset variable
$NXTSort_rsnews1 = "news.newsdate DESC";
if (isset($_SESSION['sorter_tso_listnews1'])) {
  $NXTSort_rsnews1 = $_SESSION['sorter_tso_listnews1'];
}
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

$query_rsnews1 = "SELECT menubar1.menubar1name AS ID_menubar1, menubar2.menubar2name AS ID_menubar2, news.newstitle, news.newsapproval, news.newsdate, news.ID_news FROM (news LEFT JOIN menubar1 ON news.ID_menubar1 = menubar1.ID_menubar1) LEFT JOIN menubar2 ON news.ID_menubar2 = menubar2.ID_menubar2 WHERE {$NXTFilter_rsnews1} ORDER BY {$NXTSort_rsnews1}";
$query_limit_rsnews1 = sprintf("%s LIMIT %d, %d", $query_rsnews1, $startRow_rsnews1, $maxRows_rsnews1);
$rsnews1 = mysql_query($query_limit_rsnews1, $cnn_hoaly) or die(mysql_error());
$row_rsnews1 = mysql_fetch_assoc($rsnews1);

if (isset($_GET['totalRows_rsnews1'])) {
  $totalRows_rsnews1 = $_GET['totalRows_rsnews1'];
} else {
  $all_rsnews1 = mysql_query($query_rsnews1);
  $totalRows_rsnews1 = mysql_num_rows($all_rsnews1);
}
$totalPages_rsnews1 = ceil($totalRows_rsnews1/$maxRows_rsnews1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listnews1->checkBoundries();
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
  .KT_col_ID_menubar1 {width:100%; overflow:hidden;}
  .KT_col_ID_menubar2 {width:100%; overflow:hidden;}
  .KT_col_newstitle {width:100%; overflow:hidden;}
  .KT_col_newsapproval {width:100%; overflow:hidden;}
  .KT_col_newsdate {width:100%; overflow:hidden;}
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
        <div class="KT_tng" id="listnews1">
          <h1> Quản lý tin tức
            <?php
  $nav_listnews1->Prepare();
  require("../includes/nav/NAV_Text_Statistics.inc.php");
?>
          </h1>
          <div class="KT_tnglist">
            <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
              <div class="KT_options"> <a href="<?php echo $nav_listnews1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
                <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listnews1'] == 1) {
?>
                  <?php echo $_SESSION['default_max_rows_nav_listnews1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listnews1'] == 1) {
?>
                  <a href="<?php echo $tfi_listnews1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                  <?php 
  // else Conditional region2
  } else { ?>
                  <a href="<?php echo $tfi_listnews1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                  <?php } 
  // endif Conditional region2
?>
              </div>
              <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                <thead>
                  <tr class="KT_row_order">
                    <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
                    </th>
                    <th id="ID_menubar1" class="KT_sorter KT_col_ID_menubar1 <?php echo $tso_listnews1->getSortIcon('menubar1.menubar1name'); ?>"> <a href="<?php echo $tso_listnews1->getSortLink('menubar1.menubar1name'); ?>">Danh mục 1</a> </th>
                    <th id="ID_menubar2" class="KT_sorter KT_col_ID_menubar2 <?php echo $tso_listnews1->getSortIcon('menubar2.menubar2name'); ?>"> <a href="<?php echo $tso_listnews1->getSortLink('menubar2.menubar2name'); ?>">Danh mục 2</a> </th>
                    <th id="newstitle" class="KT_sorter KT_col_newstitle <?php echo $tso_listnews1->getSortIcon('news.newstitle'); ?>"> <a href="<?php echo $tso_listnews1->getSortLink('news.newstitle'); ?>">Tiêu đề</a> </th>
                    <th id="newsapproval" class="KT_sorter KT_col_newsapproval <?php echo $tso_listnews1->getSortIcon('news.newsapproval'); ?>"> <a href="<?php echo $tso_listnews1->getSortLink('news.newsapproval'); ?>">Duyệt</a> </th>
                    <th id="newsdate" class="KT_sorter KT_col_newsdate <?php echo $tso_listnews1->getSortIcon('news.newsdate'); ?>"> <a href="<?php echo $tso_listnews1->getSortLink('news.newsdate'); ?>">Ngày đăng</a> </th>
                    <th>&nbsp;</th>
                  </tr>
                  <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listnews1'] == 1) {
?>
                    <tr class="KT_row_filter">
                      <td>&nbsp;</td>
                      <td><select name="tfi_listnews1_ID_menubar1" id="tfi_listnews1_ID_menubar1">
                        <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listnews1_ID_menubar1']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                        <?php
do {  
?>
                        <option value="<?php echo $row_Recordset1['ID_menubar1']?>"<?php if (!(strcmp($row_Recordset1['ID_menubar1'], @$_SESSION['tfi_listnews1_ID_menubar1']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['menubar1name']?></option>
                        <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
                      </select></td>
                      <td><select name="tfi_listnews1_ID_menubar2" id="tfi_listnews1_ID_menubar2">
                        <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listnews1_ID_menubar2']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                        <?php
do {  
?>
                        <option value="<?php echo $row_Recordset2['ID_menubar2']?>"<?php if (!(strcmp($row_Recordset2['ID_menubar2'], @$_SESSION['tfi_listnews1_ID_menubar2']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['menubar2name']?></option>
                        <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
                      </select></td>
                      <td><input type="text" name="tfi_listnews1_newstitle" id="tfi_listnews1_newstitle" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listnews1_newstitle']); ?>" size="20" maxlength="168" /></td>
                      <td><input type="text" name="tfi_listnews1_newsapproval" id="tfi_listnews1_newsapproval" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listnews1_newsapproval']); ?>" size="20" maxlength="100" /></td>
                      <td><input type="text" name="tfi_listnews1_newsdate" id="tfi_listnews1_newsdate" value="<?php echo @$_SESSION['tfi_listnews1_newsdate']; ?>" size="10" maxlength="22" /></td>
                      <td><input type="submit" name="tfi_listnews1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
                    </tr>
                    <?php } 
  // endif Conditional region3
?>
                </thead>
                <tbody>
                  <?php if ($totalRows_rsnews1 == 0) { // Show if recordset empty ?>
                    <tr>
                      <td colspan="7"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
                    </tr>
                    <?php } // Show if recordset empty ?>
                  <?php if ($totalRows_rsnews1 > 0) { // Show if recordset not empty ?>
                    <?php do { ?>
                      <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                        <td><input type="checkbox" name="kt_pk_news" class="id_checkbox" value="<?php echo $row_rsnews1['ID_news']; ?>" />
                          <input type="hidden" name="ID_news" class="id_field" value="<?php echo $row_rsnews1['ID_news']; ?>" /></td>
                        <td><div class="KT_col_ID_menubar1"><?php echo KT_FormatForList($row_rsnews1['ID_menubar1'], 26); ?></div></td>
                        <td><div class="KT_col_ID_menubar2"><?php echo KT_FormatForList($row_rsnews1['ID_menubar2'], 26); ?></div></td>
                        <td><div class="KT_col_newstitle"><?php echo KT_FormatForList($row_rsnews1['newstitle'], 36); ?></div></td>
                        <td><div class="KT_col_newsapproval">
                          <?php 
							// Show IF Conditional region4 
							if (@$row_rsnews1['newsapproval'] == 1) {
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
                        <td><div class="KT_col_newsdate"><?php echo KT_formatDate($row_rsnews1['newsdate']); ?></div></td>
<td><a class="KT_edit_link" href="form_tintuc.php?ID_news=<?php echo $row_rsnews1['ID_news']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a></td>
                      </tr>
                      <?php } while ($row_rsnews1 = mysql_fetch_assoc($rsnews1)); ?>
                    <?php } // Show if recordset not empty ?>
                </tbody>
              </table>
              <div class="KT_bottomnav">
                <div>
                  <?php
            $nav_listnews1->Prepare();
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
                <a class="KT_additem_op_link" href="form_tintuc.php?KT_back=1" onClick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
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
mysql_free_result($Recordset2);
mysql_free_result($rsnews1);
?>