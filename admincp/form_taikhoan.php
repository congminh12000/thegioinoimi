<?php require_once('../Connections/cnn_hoaly.php'); ?>
<?php
// Load the common classes
require_once('../includes/common/KT_common.php');
session_start();
?>
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

//start Trigger_CheckPasswords trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckPasswords(&$tNG) {
    $myThrowError = new tNG_ThrowError($tNG);
    $myThrowError->setErrorMsg("Could not create account.");
    $myThrowError->setField("password");
    $myThrowError->setFieldErrorMsg("The two passwords do not match.");
    return $myThrowError->Execute();
}

//end Trigger_CheckPasswords trigger
//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileDelete(&$tNG) {
    $deleteObj = new tNG_FileDelete($tNG);
    $deleteObj->setFolder("../images/avatar/");
    $deleteObj->setDbFieldName("avatar");
    return $deleteObj->Execute();
}

//end Trigger_FileDelete trigger
//start Trigger_FileUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileUpload(&$tNG) {
    $uploadObj = new tNG_FileUpload($tNG);
    $uploadObj->setFormFieldName("avatar");
    $uploadObj->setDbFieldName("avatar");
    $uploadObj->setFolder("../images/avatar/");
    $uploadObj->setMaxSize(1000);
    $uploadObj->setAllowedExtensions("png, jpg");
    $uploadObj->setRename("auto");
    return $uploadObj->Execute();
}

//end Trigger_FileUpload trigger
// Start trigger
$formValidation = new tNG_FormValidation();
$formValidation->addField("username", true, "text", "", "", "", "");
$formValidation->addField("password", true, "text", "", "", "", "");
$formValidation->addField("email", true, "text", "email", "", "", "");
$tNGs->prepareValidation($formValidation);

// End trigger
//start Trigger_CheckOldPassword trigger
//remove this line if you want to edit the code by hand
function Trigger_CheckOldPassword(&$tNG) {
    return Trigger_UpdatePassword_CheckOldPassword($tNG);
}

//end Trigger_CheckOldPassword trigger
// Make an insert transaction instance
$ins_account = new tNG_multipleInsert($conn_cnn_hoaly);
$tNGs->addTransaction($ins_account);
// Register triggers
$ins_account->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_account->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_account->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$ins_account->registerConditionalTrigger("{POST.password} != {POST.re_password}", "BEFORE", "Trigger_CheckPasswords", 50);
$ins_account->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$ins_account->setTable("account");
$ins_account->addColumn("username", "STRING_TYPE", "POST", "username");
$ins_account->addColumn("password", "STRING_TYPE", "POST", "password");
$ins_account->addColumn("fullname", "STRING_TYPE", "POST", "fullname");
$ins_account->addColumn("avatar", "FILE_TYPE", "FILES", "avatar");
$ins_account->addColumn("email", "STRING_TYPE", "POST", "email");
$ins_account->addColumn("address", "STRING_TYPE", "POST", "address");
$ins_account->addColumn("phone", "STRING_TYPE", "POST", "phone");
$ins_account->addColumn("cmnd", "STRING_TYPE", "POST", "cmnd");
$ins_account->addColumn("accesslevel", "NUMERIC_TYPE", "POST", "accesslevel");
$ins_account->addColumn("district_id", "NUMERIC_TYPE", "POST", "district_id");
$ins_account->addColumn("city_id", "NUMERIC_TYPE", "POST", "city_id");
$ins_account->addColumn("registereddate", "DATE_TYPE", "VALUE", "");
$ins_account->setPrimaryKey("ID_account", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_account = new tNG_multipleUpdate($conn_cnn_hoaly);
$tNGs->addTransaction($upd_account);
// Register triggers
$upd_account->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_account->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_account->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$upd_account->registerConditionalTrigger("{POST.password} != {POST.re_password}", "BEFORE", "Trigger_CheckPasswords", 50);
$upd_account->registerTrigger("BEFORE", "Trigger_CheckOldPassword", 60);
$upd_account->registerTrigger("AFTER", "Trigger_FileUpload", 97);
// Add columns
$upd_account->setTable("account");
$upd_account->addColumn("username", "STRING_TYPE", "POST", "username");
$upd_account->addColumn("password", "STRING_TYPE", "POST", "password");
$upd_account->addColumn("fullname", "STRING_TYPE", "POST", "fullname");
$upd_account->addColumn("avatar", "FILE_TYPE", "FILES", "avatar");
$upd_account->addColumn("email", "STRING_TYPE", "POST", "email");
$upd_account->addColumn("address", "STRING_TYPE", "POST", "address");
$upd_account->addColumn("phone", "STRING_TYPE", "POST", "phone");
$upd_account->addColumn("cmnd", "STRING_TYPE", "POST", "cmnd");
$upd_account->addColumn("accesslevel", "NUMERIC_TYPE", "POST", "accesslevel");
$upd_account->addColumn("district_id", "NUMERIC_TYPE", "POST", "district_id");
$upd_account->addColumn("city_id", "NUMERIC_TYPE", "POST", "city_id");
$upd_account->addColumn("registereddate", "DATE_TYPE", "CURRVAL", "");
$upd_account->setPrimaryKey("ID_account", "NUMERIC_TYPE", "GET", "ID_account");

// Make an instance of the transaction object
$del_account = new tNG_multipleDelete($conn_cnn_hoaly);
$tNGs->addTransaction($del_account);
// Register triggers
$del_account->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_account->registerTrigger("END", "Trigger_Default_Redirect", 99, "../includes/nxt/back.php");
$del_account->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_account->setTable("account");
$del_account->setPrimaryKey("ID_account", "NUMERIC_TYPE", "GET", "ID_account");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsaccount = $tNGs->getRecordset("account");
$row_rsaccount = mysql_fetch_assoc($rsaccount);
$totalRows_rsaccount = mysql_num_rows($rsaccount);

//select db
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

//get list accesslevel
$strQueryAccessLevel = 'SELECT * FROM accesslevel WHERE deleted = 0 AND status = 1';
$queryAccessLevel = mysql_query($strQueryAccessLevel);

//get list city
$strQueryCity = 'SELECT * FROM tinhthanh WHERE tinhthanhvisible = 1';
$queryCity = mysql_query($strQueryCity);
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
        <?php echo $tNGs->displayValidationRules(); ?>
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
                                if (@$_GET['ID_account'] == "") {
                                    ?>
                                    <?php echo NXT_getResource("Insert_FH"); ?>
                                    <?php
// else Conditional region1
                                } else {
                                    ?>
                                    <?php echo NXT_getResource("Update_FH"); ?>
                                    <?php
                                }
// endif Conditional region1
                                ?>
                                Chi tiết tài khoản </h1>
                            <div class="KT_tngform">
                                <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
                                    <?php $cnt1 = 0; ?>
                                    <?php do { ?>
                                        <?php $cnt1++; ?>
                                        <?php
// Show IF Conditional region1 
                                        if (@$totalRows_rsaccount > 1) {
                                            ?>
                                            <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
                                            <?php
                                        }
// endif Conditional region1
                                        ?>
                                        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
                                            <tr>
                                                <td width="29%" class="KT_th"><label for="username_<?php echo $cnt1; ?>">Username:</label></td>
                                                <td colspan="2"><input type="text" name="username_<?php echo $cnt1; ?>" id="username_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsaccount['username']); ?>" size="32" maxlength="68" />
                                                    <?php echo $tNGs->displayFieldHint("username"); ?> <?php echo $tNGs->displayFieldError("account", "username", $cnt1); ?></td>
                                            </tr>
                                            <?php
// Show IF Conditional show_old_password_on_update_only 
                                            if (@$_GET['ID_account'] != "") {
                                                ?>
                                                <tr>
                                                    <td class="KT_th"><label for="old_password_<?php echo $cnt1; ?>">Old Password:</label></td>
                                                    <td colspan="2"><input type="password" name="old_password_<?php echo $cnt1; ?>" id="old_password_<?php echo $cnt1; ?>" value="" size="32" maxlength="68" />
                                                        <?php echo $tNGs->displayFieldError("account", "old_password", $cnt1); ?></td>
                                                </tr>
                                                <?php
                                            }
// endif Conditional show_old_password_on_update_only
                                            ?>
                                            <tr>
                                                <td class="KT_th"><label for="password_<?php echo $cnt1; ?>">Password:</label></td>
                                                <td colspan="2"><input type="password" name="password_<?php echo $cnt1; ?>" id="password_<?php echo $cnt1; ?>" value="" size="32" maxlength="68" />
                                                    <?php echo $tNGs->displayFieldHint("password"); ?> <?php echo $tNGs->displayFieldError("account", "password", $cnt1); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="KT_th"><label for="re_password_<?php echo $cnt1; ?>">Re-type Password:</label></td>
                                                <td colspan="2"><input type="password" name="re_password_<?php echo $cnt1; ?>" id="re_password_<?php echo $cnt1; ?>" value="" size="32" maxlength="68" /></td>
                                            </tr>
                                            <tr>
                                                <td class="KT_th"><label for="fullname_<?php echo $cnt1; ?>">Họ tên:</label></td>
                                                <td colspan="2"><input type="text" name="fullname_<?php echo $cnt1; ?>" id="fullname_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsaccount['fullname']); ?>" size="32" maxlength="168" />
                                                    <?php echo $tNGs->displayFieldHint("fullname"); ?> <?php echo $tNGs->displayFieldError("account", "fullname", $cnt1); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="KT_th"><label for="avatar_<?php echo $cnt1; ?>">Ảnh đại diện:</label>
                                                    <br>(150x150 pixels)</td>
                                                <td width="37%"><input type="file" name="avatar_<?php echo $cnt1; ?>" id="avatar_<?php echo $cnt1; ?>" size="32" />
                                                    <?php echo $tNGs->displayFieldError("account", "avatar", $cnt1); ?></td>
                                                <td width="34%"><?php
                                                    // Show If File Exists (region5)
                                                    if (tNG_fileExists("../images/avatar/", "{rsaccount.avatar}")) {
                                                        ?>
                                                        <img src="<?php echo tNG_showDynamicImage("../", "../images/avatar/", "{rsaccount.avatar}"); ?>" />
                                                        <?php
                                                        // else File Exists (region5)
                                                    } else {
                                                        ?>
                                                        <img src="p7csspbm2/img/avatar.png" width="150" height="150">
                                                        <?php
                                                    }
                                                    // EndIf File Exists (region5)
                                                    ?></td>
                                            </tr>
                                            <tr>
                                                <td class="KT_th"><label for="email_<?php echo $cnt1; ?>">Email:</label></td>
                                                <td colspan="2"><input type="text" name="email_<?php echo $cnt1; ?>" id="email_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsaccount['email']); ?>" size="32" maxlength="168" />
                                                    <?php echo $tNGs->displayFieldHint("email"); ?> <?php echo $tNGs->displayFieldError("account", "email", $cnt1); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="KT_th"><label for="address_<?php echo $cnt1; ?>">Địa chỉ:</label></td>
                                                <td colspan="2"><input type="text" name="address_<?php echo $cnt1; ?>" id="address_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsaccount['address']); ?>" size="32" maxlength="208" />
                                                    <?php echo $tNGs->displayFieldHint("address"); ?> <?php echo $tNGs->displayFieldError("account", "address", $cnt1); ?></td>
                                            </tr>

                                            <tr>
                                                <td class="KT_th"><label for="city_id_<?php echo $cnt1; ?>">Thành phố:</label></td>
                                                <td colspan="2">
                                                    <select name="city_id_<?php echo $cnt1; ?>" class="city" id="city_id_<?php echo $cnt1; ?>">
                                                        <option value="">== Vui lòng chọn thành phố ==</option>
                                                        <?php while ($row = mysql_fetch_assoc($queryCity)): ?>
                                                            <option value="<?php echo $row['ID_tinhthanh']; ?>" <?php echo $row['ID_tinhthanh'] == KT_escapeAttribute($row_rsaccount['city_id']) ? 'selected="selected"' : ''; ?>><?php echo $row['tentinhthanh']; ?></option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                    <?php echo $tNGs->displayFieldError("account", "city_id", $cnt1); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="KT_th"><label for="district_id_<?php echo $cnt1; ?>">Quận:</label></td>
                                                <td colspan="2">
                                                    <select name="district_id_<?php echo $cnt1; ?>" class="district" id="district_id_<?php echo $cnt1; ?>">
                                                        <option value="">== Vui lòng chọn quận ==</option>
                                                    </select>
                                                    <input type="hidden" class="hidden_district_id" value="<?php echo (int) KT_escapeAttribute($row_rsaccount['district_id']); ?>" />
                                                    <?php echo $tNGs->displayFieldError("account", "district_id", $cnt1); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="KT_th"><label for="phone_<?php echo $cnt1; ?>">Sđt:</label></td>
                                                <td colspan="2"><input type="text" name="phone_<?php echo $cnt1; ?>" id="phone_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsaccount['phone']); ?>" size="32" maxlength="208" />
                                                    <?php echo $tNGs->displayFieldHint("phone"); ?> <?php echo $tNGs->displayFieldError("account", "phone", $cnt1); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="KT_th"><label for="cmnd_<?php echo $cnt1; ?>">Cmnd:</label></td>
                                                <td colspan="2"><input type="text" name="cmnd_<?php echo $cnt1; ?>" id="cmnd_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsaccount['cmnd']); ?>" size="32" maxlength="208" />
                                                    <?php echo $tNGs->displayFieldHint("cmnd"); ?> <?php echo $tNGs->displayFieldError("account", "cmnd", $cnt1); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="KT_th"><label for="accesslevel_<?php echo $cnt1; ?>">Quyền:</label></td>
                                                <td colspan="2">
                                                    <select name="accesslevel_<?php echo $cnt1; ?>" id="accesslevel_<?php echo $cnt1; ?>">
                                                        <?php while ($row = mysql_fetch_assoc($queryAccessLevel)): ?>
                                                            <option value="<?php echo $row['ID_accesslevel']; ?>" <?php echo $row['ID_accesslevel'] == KT_escapeAttribute($row_rsaccount['accesslevel']) ? 'selected="selected"' : ''; ?>><?php echo $row['name']; ?></option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                    <?php echo $tNGs->displayFieldError("account", "accesslevel", $cnt1); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="KT_th">Ngày ĐK:</td>
                                                <td colspan="2"><?php echo KT_formatDate($row_rsaccount['registereddate']); ?></td>
                                            </tr>
                                        </table>
                                        <input type="hidden" name="kt_pk_account_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsaccount['kt_pk_account']); ?>" />
                                    <?php } while ($row_rsaccount = mysql_fetch_assoc($rsaccount)); ?>
                                    <div class="KT_bottombuttons">
                                        <div>
                                            <?php
                                            // Show IF Conditional region1
                                            if (@$_GET['ID_account'] == "") {
                                                ?>
                                                <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
                                                <?php
                                                // else Conditional region1
                                            } else {
                                                ?>
                                                <div class="KT_operations">
                                                    <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'ID_account')" />
                                                </div>
                                                <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" />
                                                <input type="submit" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" onclick="return confirm('<?php echo NXT_getResource("Are you sure?"); ?>');" />
                                                <?php
                                            }
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

<script>
    $(document).ready(function () {
        var idAccount = <?php echo (int) $_GET['ID_account']; ?>;
        var districtId = $('.hidden_district_id').val();

        $('select.city').change(function () {
            var cityId = $(this).val();

            $.ajax({
                url: "get_list_district.php",
                type: "GET",
                dataType: 'JSON',
                data: {
                    cityId: cityId
                },
                success: function (result) {

                    var xHtml = '<option value="">== Vui lòng chọn quận ==</option>';

                    if (!result.isError) {
                        var arrDistrict = result.data.arrDistrict;

                        $.each(arrDistrict, function (k, v) {

                            var selected = '';

                            if (districtId == v.ID_quanhuyen) {
                                selected = 'selected="selected"';
                            }

                            xHtml += '<option value="' + v.ID_quanhuyen + '" ' + selected + '>' + v.tenquanhuyen + '</option>';
                        })

                    } else {

                    }

                    $('select.district').html(xHtml);
                }
            });
        });

        if (idAccount > 0) {
            $('select.city').trigger('change');
        }
    });
</script>