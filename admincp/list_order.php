<?php
require_once('../Connections/cnn_hoaly.php');
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

$strQuery = "SELECT * FROM orders as o LEFT JOIN account as a ON o.buyer_id = a.ID_account"
        . " WHERE o.deleted = 0";

if ($_GET && $_GET['isSearch']) {
    $fullname = trim($_GET['fullname']);
    $email = trim($_GET['email']);
    $from = trim($_GET['from']);
    $to = trim($_GET['to']);

    if ($fullname) {
        $strQuery .= ' AND a.fullname LIKE "%' . $fullname . '%"';
    }

    if ($email) {
        $strQuery .= ' AND a.email LIKE "%' . $email . '%"';
    }

    if ($from && $to) {
        $strQuery .= ' AND o.created_date BETWEEN "' . $from . ' 00:00:00" AND "' . $to . ' 23:59:59"';
    }
}

$strQuery .= ' ORDER BY ID_order DESC';

//class order
require_once('../includes/my/order.php');
$classOrder = new Order();

//class paginator
require_once('../includes/my/paginator.php');
$classPaginator = new Paginator($strQuery);

$limit = ( isset($_GET['limit']) ) ? $_GET['limit'] : 5;
$page = ( isset($_GET['page']) ) ? $_GET['page'] : 1;
$links = ( isset($_GET['links']) ) ? $_GET['links'] : 1;

$results = $classPaginator->getData($limit, $page);

//format price
require_once('../includes/my/format-price.php');
$formatPrice = new FormatPrice();
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
                            <h1> Danh sách đơn hàng
                            </h1>
                            <br>
                            <div class="KT_tnglist">
                                <form method="GET">
                                    <input type="hidden" name="isSearch" value="1" />
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td>Tên người tạo</td>
                                                <td>
                                                    <input type="text" class="form-control" name="fullname" value="<?php echo isset($_GET['fullname']) ? $_GET['fullname'] : '' ?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>
                                                    <input type="text" class="form-control" name="email" value="<?php echo isset($_GET['email']) ? $_GET['email'] : '' ?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Ngày tạo</td>
                                                <td>
                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control datepicker" name="from" value="<?php echo isset($_GET['from']) ? $_GET['from'] : '' ?>" readonly="" style="background: white" />
                                                    </div>

                                                    <div class="col-md-4">
                                                        <input type="text" class="form-control datepicker" name="to" value="<?php echo isset($_GET['to']) ? $_GET['to'] : '' ?>" readonly="" style="background: white" />
                                                    </div>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><button class="btn btn-success">Hoàn tất</button></td>
                                            </tr>
                                        </thead>
                                    </table>
                                </form>
                            </div>

                            <div class="KT_tnglist">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th>Tên người tạo</th>
                                            <th>Email</th>
                                            <th>Địa chỉ</th>
                                            <th>Ngày tạo</th>
                                            <th>Trạng thái</th>
                                            <th>Số lượng</th>
                                            <th>Tổng tiền</th>
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
                                                    <td><?php echo $row['fullname']; ?></td>
                                                    <td><?php echo $row['email']; ?></td>
                                                    <td><?php echo $row['address']; ?></td>
                                                    <td><?php echo $row['created_date']; ?></td>
                                                    <td><span class="label label-success"><?php echo $classOrder->getStatus($row['status']); ?></span></td>
                                                    <td><?php echo $row['total_qty']; ?></td>
                                                    <td><?php echo $formatPrice->format($row['grand_total']); ?></td>
                                                    <td class="text-center">
                                                        <a href="javascript:void(0);" class="btn-detail" data-id="<?php echo $row['ID_order']; ?>">
                                                            <i class="fa fa-plus" aria-hidden="true" style="color: #f9a020"></i>
                                                        </a>
                                                        <a href="javascript:void(0);" class="btn-detail-receiver"
                                                           data-receiver-name="<?php echo $row['receiver_name']; ?>"
                                                           data-receiver-phone="<?php echo $row['receiver_phone']; ?>"
                                                           data-receiver-email="<?php echo $row['receiver_email']; ?>"
                                                           data-receiver-address="<?php echo $row['receiver_address']; ?>"
                                                           data-receiver-note="<?php echo $row['receiver_note']; ?>">
                                                            <i class="fa fa-building-o" aria-hidden="true"></i>
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
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });

        $('.btn-detail-receiver').click(function () {
            var that = $(this);
            var receiverName = that.data('receiver-name');
            var receiverEmail = that.data('receiver-email');
            var receiverPhone = that.data('receiver-phone');
            var receiverAddress = that.data('receiver-address');
            var receiverNote = that.data('receiver-note');
            
            var html = '<table class="table table-striped table-hover" width="100%">';
            html += '<tr>\n\
                <td width="30%">\n\
                 Tên người nhận    \n\
                    </td>\n\
<td>\n\
                 '+ receiverName +'    \n\
                    </td></tr>\n\
<tr><td>\n\
                 Email người nhận    \n\
                    </td>\n\
<td> '+receiverEmail+'</td></tr>\n\
<tr><td>Sđt</td>\n\
<td>'+receiverPhone+'</td></tr>\n\
<tr><td>Địa chỉ</td>\n\
<td>'+receiverAddress+'</td></tr>\n\
<tr><td>Ghi chú</td>\n\
<td>'+receiverNote+'</td></tr>\n\
';
            html += '<table>';
        
            swal({
                title: '<span style="color: #ab47bc">Thông tin người nhận</span>',
                html: html,
            })
        });

        $('.btn-detail').click(function () {
            var that = $(this);
            var id = that.data('id');
            var eleDetail = $('tr.detail-' + id);

            //check visible element
            if (eleDetail.is(':visible')) {
                eleDetail.hide();
                return false;
            }

            //hide all detail
            $('tr.detail').hide();

            $.ajax({
                url: "detail_order.php",
                type: "GET",
                dataType: 'JSON',
                data: {
                    orderId: id
                },
                success: function (result) {

                    if (!result.isError) {
                        var detailHtml = result.data.detailHtml;

                        $('td.detail-content-' + id).html(detailHtml);
                        eleDetail.show();
                    } else {

                    }
                }
            });
        });
    });
</script>