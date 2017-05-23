<?php require_once('../Connections/cnn_hoaly.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');
session_start();
?>
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

    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
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
$tor_listproduct2 = new TOR_SetOrder($conn_cnn_hoaly, 'product', 'ID_product', 'NUMERIC_TYPE', 'productorderlist', 'listproduct2_productorderlist_order');
$tor_listproduct2->Execute();

// Filter
$tfi_listproduct2 = new TFI_TableFilter($conn_cnn_hoaly, "tfi_listproduct2");
$tfi_listproduct2->addColumn("menubar1.ID_menubar1", "NUMERIC_TYPE", "ID_danhmuc1", "=");
$tfi_listproduct2->addColumn("menubar2.ID_menubar2", "NUMERIC_TYPE", "ID_danhmuc2", "=");
$tfi_listproduct2->addColumn("product.productname", "STRING_TYPE", "productname", "%");
$tfi_listproduct2->addColumn("product.productapproval", "NUMERIC_TYPE", "productapproval", "=");
$tfi_listproduct2->Execute();

// Sorter
$tso_listproduct2 = new TSO_TableSorter("rsproduct1", "tso_listproduct2");
$tso_listproduct2->addColumn("product.productorderlist"); // Order column
$tso_listproduct2->setDefault("product.productorderlist");
$tso_listproduct2->Execute();

// Navigation
$nav_listproduct2 = new NAV_Regular("nav_listproduct2", "rsproduct1", "../", $_SERVER['PHP_SELF'], 10);

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
$maxRows_rsproduct1 = $_SESSION['max_rows_nav_listproduct2'];
$pageNum_rsproduct1 = 0;
if (isset($_GET['pageNum_rsproduct1'])) {
    $pageNum_rsproduct1 = $_GET['pageNum_rsproduct1'];
}
$startRow_rsproduct1 = $pageNum_rsproduct1 * $maxRows_rsproduct1;

// Defining List Recordset variable
$NXTFilter_rsproduct1 = "1=1";
if (isset($_SESSION['filter_tfi_listproduct2'])) {
    $NXTFilter_rsproduct1 = $_SESSION['filter_tfi_listproduct2'];
}
// Defining List Recordset variable
$NXTSort_rsproduct1 = "product.productorderlist";
if (isset($_SESSION['sorter_tso_listproduct2'])) {
    $NXTSort_rsproduct1 = $_SESSION['sorter_tso_listproduct2'];
}
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

$query_rsproduct1 = "SELECT menubar1.menubar1name AS ID_danhmuc1, menubar2.menubar2name AS ID_danhmuc2, product.productname, product.productapproval, product.ID_product, product.productorderlist FROM (product LEFT JOIN menubar1 ON product.ID_danhmuc1 = menubar1.ID_menubar1) LEFT JOIN menubar2 ON product.ID_danhmuc2 = menubar2.ID_menubar2 WHERE {$NXTFilter_rsproduct1} ORDER BY {$NXTSort_rsproduct1}";
$query_limit_rsproduct1 = sprintf("%s LIMIT %d, %d", $query_rsproduct1, $startRow_rsproduct1, $maxRows_rsproduct1);
$rsproduct1 = mysql_query($query_limit_rsproduct1, $cnn_hoaly) or die(mysql_error());
$row_rsproduct1 = mysql_fetch_assoc($rsproduct1);

if (isset($_GET['totalRows_rsproduct1'])) {
    $totalRows_rsproduct1 = $_GET['totalRows_rsproduct1'];
} else {
    $all_rsproduct1 = mysql_query($query_rsproduct1);
    $totalRows_rsproduct1 = mysql_num_rows($all_rsproduct1);
}
$totalPages_rsproduct1 = ceil($totalRows_rsproduct1 / $maxRows_rsproduct1) - 1;
//End NeXTenesio3 Special List Recordset

$nav_listproduct2->checkBoundries();
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width">
        <title>Công Ty TNHH Thương Mại Lyan</title>
        <script type="text/javascript" src="p7ehc/p7EHCscripts.js"></script>
        <link href="../vendor/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="../css/bootstrap-toggle.min.css" rel="stylesheet" type="text/css">
        <link href="p7csspbm2/p7csspbm2_12.css" rel="stylesheet" type="text/css">
        <link href="../css/my/style.css" rel="stylesheet" type="text/css">
        <link href="p7csspbm2/p7csspbm2_print.css" rel="stylesheet" type="text/css" media="print">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="../vendor/font-awesome/css/font-awesome.min.css">
        <script src="../vendor/jquery.min.js" type="text/javascript"></script>
        <script src="../vendor/bootstrap.js" type="text/javascript"></script>
        <script src="../js/bootstrap-toggle.min.js" type="text/javascript"></script>
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
            .KT_col_ID_danhmuc1 {width:100%; overflow:hidden;}
            .KT_col_ID_danhmuc2 {width:100%; overflow:hidden;}
            .KT_col_productname {width:100%; overflow:hidden;}
            .KT_col_productapproval {width:100%; overflow:hidden;}
        </style>
        <?php echo $tor_listproduct2->scriptDefinition(); ?>

        <style>
            .toggle{ left:70% }
        </style>
    </head>

    <body>
        <div id="loading-mask" style="left: -2px; top: 0px; width: 100%; height: 100%; display: none;">
            <p id="loading_mask_loader" class="loader">
                <img alt="Loading..." src="../images/loading.gif">
                <br>Vui lòng chờ...</p>
        </div>
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
                        <div class="KT_tng" id="listproduct2">
                            <h1> Quản lý sản phẩm
                                <?php
                                $nav_listproduct2->Prepare();
                                require("../includes/nav/NAV_Text_Statistics.inc.php");
                                ?>
                            </h1>

                            <div class="panel panel-success"> 
                                <div class="panel-heading">
                                    <h3 class="panel-title">Ẩn / hiện giá công khai tất cả sản phẩm
                                        <input type="checkbox" id="btn-hidden-price" checked data-toggle="toggle" data-on="Bật" data-off="Tắt">
                                    </h3>
                                </div> 
                            </div>

                            <div class="KT_tnglist">
                                <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
                                    <div class="KT_options"> <a href="<?php echo $nav_listproduct2->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
                                            <?php
                                            // Show IF Conditional region1
                                            if (@$_GET['show_all_nav_listproduct2'] == 1) {
                                                ?>
                                                <?php echo $_SESSION['default_max_rows_nav_listproduct2']; ?>
                                                <?php
                                                // else Conditional region1
                                            } else {
                                                ?>
                                                <?php echo NXT_getResource("all"); ?>
                                                <?php
                                            }
                                            // endif Conditional region1
                                            ?>
                                            <?php echo NXT_getResource("records"); ?></a> &nbsp;
                                        &nbsp;
                                        <?php
                                        // Show IF Conditional region2
                                        if (@$_SESSION['has_filter_tfi_listproduct2'] == 1) {
                                            ?>
                                            <a href="<?php echo $tfi_listproduct2->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
                                            <?php
                                            // else Conditional region2
                                        } else {
                                            ?>
                                            <a href="<?php echo $tfi_listproduct2->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
                                            <?php
                                        }
// endif Conditional region2
                                        ?>
                                    </div>
                                    <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                                        <thead>
                                            <tr class="KT_row_order">
                                                <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
                                                </th>
                                                <th id="ID_danhmuc1" class="KT_col_ID_danhmuc1">Danh mục 1</th>
                                                <th id="ID_danhmuc2" class="KT_col_ID_danhmuc2">Danh mục 2</th>
                                                <th id="productname" class="KT_col_productname">Sản phẩm</th>
                                                <th id="productapproval" class="KT_col_productapproval">Duyệt</th>
                                                <th id="productorderlist" class="KT_sorter <?php echo $tso_listproduct2->getSortIcon('product.productorderlist'); ?> KT_order"> <a href="<?php echo $tso_listproduct2->getSortLink('product.productorderlist'); ?>"><?php echo NXT_getResource("Order"); ?></a> <a class="KT_move_op_link" href="#" onclick="nxt_list_move_link_form(this); return false;"><?php echo NXT_getResource("save"); ?></a> </th>
                                                <th>&nbsp;</th>
                                            </tr>
                                            <?php
// Show IF Conditional region3
                                            if (@$_SESSION['has_filter_tfi_listproduct2'] == 1) {
                                                ?>
                                                <tr class="KT_row_filter">
                                                    <td>&nbsp;</td>
                                                    <td><select name="tfi_listproduct2_ID_danhmuc1" id="tfi_listproduct2_ID_danhmuc1">
                                                            <option value="" <?php
                                                            if (!(strcmp("", @$_SESSION['tfi_listproduct2_ID_danhmuc1']))) {
                                                                echo "SELECTED";
                                                            }
                                                            ?>><?php echo NXT_getResource("None"); ?></option>
                                                                    <?php
                                                                    do {
                                                                        ?>
                                                                <option value="<?php echo $row_Recordset1['ID_menubar1'] ?>"<?php
                                                                if (!(strcmp($row_Recordset1['ID_menubar1'], @$_SESSION['tfi_listproduct2_ID_danhmuc1']))) {
                                                                    echo "SELECTED";
                                                                }
                                                                ?>><?php echo $row_Recordset1['menubar1name'] ?></option>
                                                                        <?php
                                                                    } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
                                                                    $rows = mysql_num_rows($Recordset1);
                                                                    if ($rows > 0) {
                                                                        mysql_data_seek($Recordset1, 0);
                                                                        $row_Recordset1 = mysql_fetch_assoc($Recordset1);
                                                                    }
                                                                    ?>
                                                        </select></td>
                                                    <td><select name="tfi_listproduct2_ID_danhmuc2" id="tfi_listproduct2_ID_danhmuc2">
                                                            <option value="" <?php
                                                            if (!(strcmp("", @$_SESSION['tfi_listproduct2_ID_danhmuc2']))) {
                                                                echo "SELECTED";
                                                            }
                                                            ?>><?php echo NXT_getResource("None"); ?></option>
                                                                    <?php
                                                                    do {
                                                                        ?>
                                                                <option value="<?php echo $row_Recordset2['ID_menubar2'] ?>"<?php
                                                                if (!(strcmp($row_Recordset2['ID_menubar2'], @$_SESSION['tfi_listproduct2_ID_danhmuc2']))) {
                                                                    echo "SELECTED";
                                                                }
                                                                ?>><?php echo $row_Recordset2['menubar2name'] ?></option>
                                                                        <?php
                                                                    } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
                                                                    $rows = mysql_num_rows($Recordset2);
                                                                    if ($rows > 0) {
                                                                        mysql_data_seek($Recordset2, 0);
                                                                        $row_Recordset2 = mysql_fetch_assoc($Recordset2);
                                                                    }
                                                                    ?>
                                                        </select></td>
                                                    <td><input type="text" name="tfi_listproduct2_productname" id="tfi_listproduct2_productname" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listproduct2_productname']); ?>" size="20" maxlength="68" /></td>
                                                    <td><input type="text" name="tfi_listproduct2_productapproval" id="tfi_listproduct2_productapproval" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listproduct2_productapproval']); ?>" size="20" maxlength="100" /></td>
                                                    <td>&nbsp;</td>
                                                    <td><input type="submit" name="tfi_listproduct2" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
                                                </tr>
                                                <?php
                                            }
// endif Conditional region3
                                            ?>
                                        </thead>
                                        <tbody>
                                            <?php if ($totalRows_rsproduct1 == 0) { // Show if recordset empty   ?>
                                                <tr>
                                                    <td colspan="7"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
                                                </tr>
                                            <?php } // Show if recordset empty  ?>
                                            <?php if ($totalRows_rsproduct1 > 0) { // Show if recordset not empty   ?>
                                                <?php do { ?>
                                                    <tr class="<?php echo @$cnt1++ % 2 == 0 ? "" : "KT_even"; ?>">
                                                        <td><input type="checkbox" name="kt_pk_product" class="id_checkbox" value="<?php echo $row_rsproduct1['ID_product']; ?>" />
                                                            <input type="hidden" name="ID_product" class="id_field" value="<?php echo $row_rsproduct1['ID_product']; ?>" /></td>
                                                        <td><div class="KT_col_ID_danhmuc1"><?php echo KT_FormatForList($row_rsproduct1['ID_danhmuc1'], 26); ?></div></td>
                                                        <td><div class="KT_col_ID_danhmuc2"><?php echo KT_FormatForList($row_rsproduct1['ID_danhmuc2'], 26); ?></div></td>
                                                        <td><div class="KT_col_productname"><?php echo KT_FormatForList($row_rsproduct1['productname'], 36); ?></div></td>
                                                        <td><div class="KT_col_productapproval"><?php echo KT_FormatForList($row_rsproduct1['productapproval'], 20); ?></div></td>
                                                        <td class="KT_order"><input type="hidden" class="KT_orderhidden" name="<?php echo $tor_listproduct2->getOrderFieldName() ?>" value="<?php echo $tor_listproduct2->getOrderFieldValue($row_rsproduct1) ?>" />
                                                            <a class="KT_movedown_link" href="#move_down">v</a> <a class="KT_moveup_link" href="#move_up">^</a></td>
                                                        <td><a class="KT_edit_link" href="form_sanpham.php?ID_product=<?php echo $row_rsproduct1['ID_product']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a></td>
                                                    </tr>
                                                <?php } while ($row_rsproduct1 = mysql_fetch_assoc($rsproduct1)); ?>
                                            <?php } // Show if recordset not empty  ?>
                                        </tbody>
                                    </table>
                                    <div class="KT_bottomnav">
                                        <div>
                                            <?php
                                            $nav_listproduct2->Prepare();
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
                                        <a class="KT_additem_op_link" href="form_sanpham.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a> </div>
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
mysql_free_result($rsproduct1);
?>
<script>
    $(document).ready(function () {
        $('#btn-hidden-price').change(function () {
            var isCheck = $(this).prop('checked');
            $.ajax({
                url: 'handle_hidden_all_price.php',
                type: 'GET',
                data: {
                    isCheck: isCheck
                },
                dataType: 'JSON',
                beforeSend: function () {
//                    $('#loading-mask').show();
                },
                success: function (result) {
//                    $('#loading-mask').hide();
                }
            })
        })
    });
</script>