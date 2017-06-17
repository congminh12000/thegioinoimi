<?php
require_once('Connections/cnn_hoaly.php');
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

session_start();
//unset($_SESSION['cart']);die;
$user = $_SESSION['user'];
$id_account = (int) $user['ID_account'];

if ($id_account == 0) {
    header('Location: index.php');
}

$arrError = [];

if ($_POST) {
    $userName = trim($_POST['username']);
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $cmnd = trim($_POST['cmnd']);
    $cityId = (int) $_POST['city'];
    $districtId = (int) $_POST['district'];
    $oldPassword = trim($_POST['old-password']);
    $newPassword = trim($_POST['new-password']);
    $rePassword = trim($_POST['re-password']);

    if ($userName == '') {
        $arrError[] = 'Tên tài khoản không được bỏ trống';
    } else {

        if (strlen($userName) < 3) {
            $arrError[] = 'Tên tài khoản phải lớn hơn 3 ký tự !';
        } else {

            $strQuery = "SELECT * FROM account WHERE ID_account != {$id_account} AND username = '{$userName}'";
            $query = mysql_query($strQuery);
            $count = mysql_num_rows($query);

            if ($count > 0) {
                $arrError[] = 'Tên tài khoản này đã tồn tại !';
            }
        }
    }

    if ($email == '') {
        $arrError[] = 'Email không được bỏ trống';
    } else {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $arrError[] = 'Email không hợp lệ !';
        } else {

            $strQuery = "SELECT * FROM account WHERE ID_account != {$id_account} AND email = '{$email}'";
            $query = mysql_query($strQuery);
            $count = mysql_num_rows($query);

            if ($count > 0) {
                $arrError[] = 'Email này đã tồn tại !';
            }
        }
    }

    if ($oldPassword) {

        $pass = md5($oldPassword);
        $strQuery = "SELECT * FROM account WHERE ID_account != {$id_account} AND password = '{$pass}'";
        $query = mysql_query($strQuery);
        $count = mysql_num_rows($query);

        if ($count == 0) {

            $arrError[] = 'Mật khẩu cũ không đúng !';
        } else {

            if ($newPassword == '') {
                $arrError[] = 'Vui lòng nhập mật khẩu mới !';
            } else {

                if (strlen($newPassword) < 6) {
                    $arrError[] = 'Mật khẩu mới phải lớn hơn 6 ký tự !';
                } else {

                    if ($rePassword != $newPassword) {
                        $arrError[] = 'Mật khẩu nhập lại không trùng khớp !';
                    }
                }
            }
        }
    }

    if (empty($arrError)) {

        //update
        $strQuery = "UPDATE account SET username = '{$userName}', fullname = '{$fullname}',"
                . " email = '{$email}', address = '{$address}', phone = '{$phone}', cmnd = '{$cmnd}', city_id = '{$cityId}', district_id = '{$districtId}'";

        if ($oldPassword && $newPassword == $rePassword) {
            $strQuery .= ", password = '" . md5($newPassword) . "'";
        }

        $strQuery .= " WHERE ID_account = {$id_account}";

        $result = mysql_query($strQuery);

        if ($result) {
            $strQuery = "SELECT * FROM account WHERE ID_account = {$id_account}";
            
            $result = mysql_query($strQuery);
            $account = mysql_fetch_assoc($result);
            
            $_SESSION['user'] = $account;
            
            header('Location: index.php');
        }
    }
}

//get user
$strQuery = "SELECT * FROM account WHERE ID_account = {$id_account}";
$query = mysql_query($strQuery);

$userDetail = mysql_fetch_assoc($query);

//get city
$strQuery = "SELECT * FROM tinhthanh WHERE tinhthanhvisible = 1";
$query = mysql_query($strQuery);

while ($row = mysql_fetch_assoc($query)) {
    $arrCity[] = $row;
}

//get district
$strQuery = "SELECT * FROM quanhuyen WHERE ID_tinhthanh = {$userDetail['city_id']} AND quanhuyenvisible = 1";
$query = mysql_query($strQuery);

while ($row = mysql_fetch_assoc($query)) {
    $arrDistrict[] = $row;
}


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Công Ty TNHH Thương ại Lyan</title>
        <meta name="title" content="Công Ty TNHH Thương Mại Lyan">
        <meta name="description" content="Công Ty TNHH Thương Mại Lyan">
        <meta name="keywords" content="Lyan, noi mi, nối mi, Hoa Ly, Hoa Lý">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="vendor/bootstrap.css">
        <link rel="stylesheet" href="vendor/font-awesome.css">
        <link rel="stylesheet" href="style-primary.css">
        <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link rel="icon" href="images/favicon.ico" type="image/ico" sizes="32x32">
        <script src="vendor/jquery.min.js" type="text/javascript"></script>
        <script src="vendor/bootstrap.js" type="text/javascript"></script>
        <script src="build/mediaelement-and-player.min.js"></script><!-- Audio/Video Player jQuery -->
        <script src="build/mep-feature-playlist.js"></script><!-- Playlist JavaSCript -->
        <link rel="stylesheet" href="css/progression-player.css" /><!-- Default Player Styles -->	
        <link rel="stylesheet" href="css/skin-default-dark.css" /><!-- Dark Skin -->
    </head>

    <body>
        <header class="top_header">
            <div class="container">
                <div class="row">
                    <?php include("header.php"); ?>
                </div><br> <!--end row-->
                <div class="row">
                    <div class="col-xs-12 co-sm-12 col-md-12 col-lg-12">
                        <?php include("menubar.php"); ?>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end container-->
        </header> <!-- end header-->
        <div class="slideshow">
            <div class="container-fluid">
                <img src="images/demo-banner.png" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive">
            </div> <!-- end container-->
        </div> <!-- end slideshow-->
        <div class="product">
            <div class="container">
                <div class="row">
                    <?php if ($arrError): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($arrError as $error): ?>
                                <?php echo '- ' . $error . '<br>'; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 cartbox">
                        <form method="POST" action="">
                            <div class="row receiveinfo">
                                <h3>Thông tin tài khoản</h3>
                                <span class="line3"></span>
                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

                                    <label>Tài khoản đăng nhập</label>
                                    <input type="text" name="username" placeholder="Tài khoản đăng nhập" value="<?php echo isset($_POST['username']) ? $_POST['username'] : $userDetail['username']; ?>"><br>

                                    <label>Họ và tên</label>
                                    <input type="text" name="fullname" placeholder="Họ tên" value="<?php echo isset($_POST['fullname']) ? $_POST['fullname'] : $userDetail['fullname']; ?>"><br>

                                    <label>Email</label>
                                    <input type="text" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : $userDetail['email']; ?>" width="350px"><br>

                                    <label>Địa chỉ</label>
                                    <input type="text" name="address" placeholder="Địa chỉ" value="<?php echo isset($_POST['address']) ? $_POST['address'] : $userDetail['address']; ?>"><br> 

                                    <label>Sđt : </label>
                                    <input type="text" name="phone" placeholder="Điện thoại" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : $userDetail['phone']; ?>"><br>

                                    <label>Cmnd : </label>
                                    <input type="text" name="cmnd" placeholder="Cmnd" value="<?php echo isset($_POST['cmnd']) ? $_POST['cmnd'] : $userDetail['cmnd']; ?>"><br>

                                    <label>Mật khẩu cũ : </label>
                                    <input type="password" name="old-password" placeholder="Mật khẩu cũ" value=""><br>

                                    <label>Mật khẩu mới : </label>
                                    <input type="password" name="new-password" placeholder="Mật khẩu mới" value=""><br>

                                    <label>Nhập lại mật khẩu mới : </label>
                                    <input type="password" name="re-password" placeholder="Mật khẩu mới" value=""><br>

                                    <label>Thành phố : </label>
                                    <select name="city" class="city">
                                        <option value="">== Vui lòng chọn thành phố ==</option>
                                        <?php foreach ($arrCity as $city): ?>
                                            <option value="<?php echo $city['ID_tinhthanh']; ?>" <?php echo $userDetail['city_id'] == $city['ID_tinhthanh'] ? 'selected="selected"' : ''; ?>>
                                                <?php echo $city['tentinhthanh']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <br>

                                    <label>Quận : </label>
                                    <select name="district" class="district">
                                        <option value="">== Vui lòng chọn quận ==</option>
                                        <?php foreach ($arrDistrict as $district): ?>
                                            <option value="<?php echo $district['ID_quanhuyen']; ?>"><?php echo $district['tenquanhuyen']; ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <br>

                                    <button type="submit" class="btn btn-info">Hoàn tất</button>
                                </div>
                            </div> <!-- end row receive-info-->
                        </form>
                    </div> <!-- end col -->
                    <div class="hidden-xs hidden-sm col-md-3 col-lg-3">
                        <img src="images/advertising-280x360.png" class="img-responsive">
                    </div> 
                    <!-- end col -->
                </div> <!-- end row-->
            </div> <!-- end container-->
        </div> <!-- end intro-->
        <?php include("footer.php"); ?>
    </body>
</html>

<script>
    $(document).ready(function () {
        var districtId = <?php echo (int) $userDetail['district_id']; ?>;

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

        $('select.city').trigger('change');
    });
</script>
