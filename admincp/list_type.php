<?php
require_once('../Connections/cnn_hoaly.php');
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

$strQuery = "SELECT * FROM type_menubar2"
        . " WHERE tm2_deleted = 0 ORDER BY parent_id ASC";

//class paginator
require_once('../includes/my/paginator.php');
$classPaginator = new Paginator($strQuery);

$limit = ( isset($_GET['limit']) ) ? $_GET['limit'] : 20;
$page = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
$links = ( isset($_GET['links']) ) ? $_GET['links'] : 1;

$results = $classPaginator->getData($limit, $page);

foreach ($results->data as $item) {

    $arrParentType[$item['ID_type_menubar2']] = $item;
}

//get menubar2
$strQuery = "SELECT * FROM menubar2 WHERE menubar2visible = 1";
$query = mysql_query($strQuery);
while ($row = mysql_fetch_assoc($query)) {
    $arrMenubar2[$row['ID_menubar2']] = $row;
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
                            <h1> Danh sách loại mi
                                <button class="btn btn-success btn-add-type" style="float:right">Thêm loại mi</button>
                            </h1>
                            <br>
                            <div class="KT_tnglist">

                            </div>

                            <div class="KT_tnglist">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th>Tên loại</th>
                                            <th>Loại cha</th>
                                            <th>Danh mục</th>
                                            <th>Trạng thái</th>
                                            <th class="text-center">Chức năng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($results->total):
                                            $stt = 1;
                                            foreach ($results->data as $row):
//                                                var_dump($row);die;
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $stt; ?></td>
                                                    <td><?php echo $row['tm2_name']; ?></td>
                                                    <td><?php echo $arrParentType[$row['parent_id']]['tm2_name']; ?></td>
                                                    <td><?php echo $arrMenubar2[$row['ID_menubar2']]['menubar2name']; ?></td>
                                                    <td><?php echo $row['tm2_status'] ? '<span style="color:green">Kích hoạt</span>' : '<span style="color:red">Chưa kích hoạt</span>'; ?></td>
                                                    <td class="text-center">
                                                        <a href="edit_type.php?id=<?php echo $row['ID_type_menubar2'] ?>" class="btn-edit">
                                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                                        </a>
                                                        <a href="javascript:void(0);" class="btn-remove" data-id="<?php echo $row['ID_type_menubar2']; ?>">
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr class="detail detail-<?php echo $row['ID_order']; ?>" style="display: none">
                                                    <td></td>
                                                    <td colspan="7" class="detail-content-<?php echo $row['ID_order']; ?>" ></td>
                                                    <td></td>
                                                </tr>
                                                <?php
                                                $stt++;
                                            endforeach;
                                        else:
                                            ?>
                                            <tr>
                                                <td colspan="100" class="text-center">Không có dữ liệu nào !</td>
                                            </tr>
                                        <?php
                                        endif;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php if ($results->total): ?>
                                <div class="paginator text-center">
                                    <?php echo $classPaginator->createLinks($links, 'pagination pagination-sm'); ?> 
                                </div>
                            <?php endif; ?>

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

        $('.btn-add-type').click(function () {
            window.location = 'add_type.php';

        });

        $('.btn-remove').click(function () {
            var id = $(this).data('id');

            swal({
                title: 'Xóa',
                text: 'Bạn có muốn xóa loại này ko ?',
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'Hủy bỏ',
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve, reject) {

                        $.ajax({
                            url: 'remove_type.php',
                            type: 'GET',
                            dataType: 'JSON',
                            data: {
                                id: id
                            },
                            success: function (result) {

                                if (!result.isError) {
                                    window.location = window.location.href;
                                } else {
                                    swal('Lỗi !', result.message, 'error');
                                }
                            }
                        })
                    })
                }
            })


        });
    });
</script>