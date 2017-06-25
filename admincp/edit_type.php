<?php
require_once('../Connections/cnn_hoaly.php');
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

$id = (int) $_GET['id'];

if (!$id) {
    header('Location: list_type.php');
}

//get menubar2
$strQuery = "SELECT * FROM type_menubar2 WHERE tm2_deleted = 0 AND ID_type_menubar2 = {$id}";
$query = mysql_query($strQuery);
$typeMenuDetail = mysql_fetch_assoc($query);

if (empty($typeMenuDetail)) {
    header('Location: list_type.php');
}

//get menubar2 parent
$strQuery = "SELECT * FROM type_menubar2 WHERE tm2_status = 1 AND tm2_deleted = 0 AND parent_id = 0";
$query = mysql_query($strQuery);
while ($row = mysql_fetch_assoc($query)) {
    $arrParentType[] = $row;
}

//get menubar2
$strQuery = "SELECT * FROM menubar2 WHERE menubar2visible = 1";
$query = mysql_query($strQuery);
while ($row = mysql_fetch_assoc($query)) {
    $arrMenubar2[] = $row;
}

if ($_POST) {
    $arrError = [];
//var_dump($_POST);die;
    $tm2Name = trim($_POST['tm2_name']);
    $tm2Status = (int) $_POST['tm2_status'];
    $parentId = (int) $_POST['parent_id'];
    $IDmenubar2 = (int) $_POST['ID_menubar2'];
    
    if (empty($tm2Name)) {
        $arrError[] = 'Vui lòng điền tên loại !';
    } else {

        $strQuery = "SELECT * FROM type_menubar2 WHERE tm2_deleted = 0 AND ID_type_menubar2 != {$id} AND tm2_name = '{$tm2Name}'";
        $query = mysql_query($strQuery);

        if (mysql_num_rows($query)) {
            $arrError[] = 'Tên trùng, vui lòng nhập tên khác !';
        }
    }

    if (empty($arrError)) {

        $strQuery = "UPDATE type_menubar2 SET ID_menubar2 = {$IDmenubar2}, tm2_name = '{$tm2Name}', tm2_status = {$tm2Status}, parent_id = {$parentId}"
        . " WHERE ID_type_menubar2 = {$id}";
        $query = mysql_query($strQuery);

        if ($query) {
            header('Location: list_type.php');
        } else {
            $arrError[] = 'Lưu thất bại, vui lòng thử lại !';
        }
    }
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width">
        <title>Công Ty TNHH Thương Mại Lyan</title>
        <link rel="stylesheet" href="../vendor/bootstrap.css">
        <link rel="stylesheet" href="../css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="../css/sweet-alert-2.min.css">
        <script type="text/javascript" src="p7ehc/p7EHCscripts.js"></script>
        <link href="p7csspbm2/p7csspbm2_12.css" rel="stylesheet" type="text/css">
        <link href="p7csspbm2/p7csspbm2_print.css" rel="stylesheet" type="text/css" media="print">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="../vendor/font-awesome/css/font-awesome.min.css">
        <script src="../vendor/jquery.min.js" type="text/javascript"></script>
        <script src="../vendor/bootstrap.js" type="text/javascript"></script>
        <script src="../js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="../js/sweet-alert-2.min.js" type="text/javascript"></script>
        <link rel="shortcut icon" href="../images/favicon.ico">


    </head>

    <body>
        <div class="content-wrapper">
            <div class="masthead">
                <?php
                require(basename("admincp_header.php"));
                ?>
            </div> <!-- end masthead -->
            <div class="columns-wrapper">
                <div class="sidebar">
                    <div class="content p7ehc-1">
                        <?php
                        require(basename("admincp_menu.php"));
                        ?>
                    </div>
                </div> <!-- end sidebar -->
                <div class="main-content">

                    <div class="content p7ehc-1">
                        <div class="KT_tng" id="listproduct2">
                            <h1> Sửa loại mi
                            </h1>
                            <br>

                            <?php if ($arrError): ?>
                                <?php foreach ($arrError as $error): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $error . PHP_EOL; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <div class="KT_tnglist">
                                <form class="form-horizontal" action="" method="POST">

                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Tên</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="tm2_name" value="<?php echo $typeMenuDetail['tm2_name'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Trạng thái</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="tm2_status">
                                                <option value="1" <?php echo $typeMenuDetail['tm2_status'] ? 'selected="selected"' : ''; ?>>Kích hoạt</option>
                                                <option value="0" <?php echo $typeMenuDetail['tm2_status'] == false ? 'selected="selected"' : ''; ?>>Không kích hoạt</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Loại mi cha</label>
                                        <div class="col-sm-10">
                                            <select class="form-control select-parent" name="parent_id">
                                                <option value="">== Chọn loại mi cha ==</option>
                                                <?php foreach ($arrParentType as $type): ?>
                                                    <option value="<?php echo $type['ID_type_menubar2']; ?>" 
                                                            <?php echo $typeMenuDetail['parent_id'] == $type['ID_type_menubar2'] ? 'selected="selected"' : ''; ?>>
                                                                <?php echo $type['tm2_name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group select-menubar2">
                                        <label for="" class="col-sm-2 control-label">Danh mục</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="ID_menubar2">
                                                <option value="">== Chọn danh mục ==</option>
                                                <?php foreach ($arrMenubar2 as $item): ?>
                                                    <option value="<?php echo $item['ID_menubar2']; ?>"
                                                            <?php echo $typeMenuDetail['ID_menubar2'] == $item['ID_menubar2'] ? 'selected="selected"' : ''; ?> >
                                                                <?php echo $item['menubar2name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-success">Hoàn tất</button>
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
            require(basename("admincp_footer.php"));
            ?>
        </div> <!-- end content-wrapper -->
    </body>
</html>


<script>
    $(document).ready(function () {

        $('.select-parent').change(function () {
            var parentId = $(this).val();

            if (parentId) {
                $('.select-menubar2').hide();
                $('.select-menubar2').find('select').removeAttr('name');
            } else {
                $('.select-menubar2').show();
                $('.select-menubar2').find('select').attr('name', 'ID_menubar2');
            }
        });
        
        $('.select-parent').trigger('change');

    });
</script>