<?php
require_once('Connections/cnn_hoaly.php');
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <title>Công Ty TNHH Thương Mại Lyan</title>
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
    <link href="includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
    <script src="includes/common/js/base.js" type="text/javascript"></script>
    <script src="includes/common/js/utility.js" type="text/javascript"></script>
    <script src="includes/skins/style.js" type="text/javascript"></script>
    <?php // echo $tNGs->displayValidationRules();  ?>
</head>

<?php
if ($_POST) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $rePassword = trim($_POST['re-password']);
    $fullname = trim($_POST['fullname']);
    $phonenumber = trim($_POST['phonenumber']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $cmnd = trim($_POST['cmnd']);
    $cityId = (int) $_POST['city'];
    $districtId = (int) $_POST['district'];

    $arrError = [];

    //valid
    if (empty($username)) {
        $arrError['username'] = 'Vui lòng điền tên đăng nhập !';
    } else {

        if (strlen($username) <= 3) {
            $arrError['username'] = 'Tên đăng nhập phải hơn 3 ký tự !';
        } else {
            $strQuery = "SELECT * FROM account WHERE username = '{$username}'";
            $query = mysql_query($strQuery);

            if (mysql_num_rows($query)) {
                $arrError['username'] = 'Tên đăng nhập đã tồn tại, vui lòng điền tên khác !';
            }
        }
    }

    if (empty($email)) {
        $arrError['email'] = 'Vui lòng điền email !';
    } else {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $arrError['email'] = 'Email không hợp lệ !';
        } else {
            $strQuery = "SELECT * FROM account WHERE email = '{$email}'";
            $query = mysql_query($strQuery);

            if (mysql_num_rows($query)) {
                $arrError['email'] = 'Email đã tồn tại, vui lòng điền email khác !';
            }
        }
    }

    if (empty($password)) {
        $arrError['password'] = 'Vui lòng điền mật khẩu !';
    } else {

        if (strlen($password) < 6) {
            $arrError['password'] = 'Mật khẩu phải hơn 5 ký tự !';
        } else if ($rePassword != $password) {
            $arrError['password'] = 'Nhập lại mật khẩu không trùng khớp !';
        }
    }

    if (empty($arrError)) {

        //insert
        $password = md5($password);
        $registereddate = date('Y-m-d', time());
        $strQuery = "INSERT INTO account(username,password,accesslevel,fullname,email,address,registereddate,phone,cmnd,city_id,district_id) "
                . "VALUES('{$username}','{$password}', '7', '{$fullname}', '{$email}', '{$address}',"
                . " '{$registereddate}', '{$phonenumber}','{$cmnd}', '{$cityId}', '{$districtId}')";
        $query = mysql_query($strQuery);

        if (!$query) {
            $arrError['insert'] = 'Lỗi hệ thống, không thể đăng ký được !';
        } else {
            header('Location: registration_thanks.php');
        }
    }
}

//get city
$strQuery = "SELECT * FROM tinhthanh WHERE tinhthanhvisible = 1";
$query = mysql_query($strQuery);

while ($row = mysql_fetch_assoc($query)) {
    $arrCity[] = $row;
}
?>

<body><header class="top_header">
        <div class="container">
            <div class="row">
                <?php include('header.php'); ?>
            </div><br>
            <div class="row">
                <div class="col-xs-12 co-sm-12 col-md-12 col-lg-12">
                    <?php include("menubar.php"); ?>
                </div> <!-- end col-->
            </div> <!-- end row-->
        </div> <!-- end container-->
    </header> <!-- end header-->
    <div class="product">
        <div class="container">
            <div class="col-xs-12 co-sm-12 col-md-10 col-lg-10 col-md-push-1 text-center" data-sb="fadeInUp">

                <?php if ($arrError): ?>
                    <div class="alert alert-danger">
                        <?php
                        foreach ($arrError as $error):
                            echo $error . '<br>';
                        endforeach;
                        ?>
                    </div>
                <?php endif; ?>

                <h4>ĐĂNG KÝ TÀI KHOẢN</h4>
                <span class="line1"></span>
            </div> <!-- end col-->
            <div class="col-xs-12 co-sm-12 col-md-6 col-lg-6 col-md-push-3" data-sb="fadeInUp">
                <form method="POST" action="">
                    <input type="text" name="username" placeholder="Tên đăng nhập (*)" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>"><br>
                    <input type="password" name="password" placeholder="Mật khẩu (*)" value=""><br>                  
                    <input type="password" name="re-password" placeholder="Nhập lại mật khẩu (*)" value=""><br>                  
                    <input type="text" name="fullname" placeholder="Họ tên" value="<?php echo isset($_POST['fullname']) ? $_POST['fullname'] : ''; ?>"><br>
                    <input type="text" name="phonenumber" placeholder="Điện thoại" value="<?php echo isset($_POST['phonenumber']) ? $_POST['phonenumber'] : ''; ?>"><br>
                    <input type="text" name="email" placeholder="Email (*)" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"><br> 
                    <input type="text" name="cmnd" placeholder="Cmnd" value="<?php echo isset($_POST['cmnd']) ? $_POST['cmnd'] : ''; ?>"><br> 
                    <input type="text" name="address" placeholder="Địa chỉ" value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>"><br> 

                    <select name="city" class="city">
                        <option value="">== Vui lòng chọn thành phố ==</option>
                        <?php foreach ($arrCity as $city): ?>
                            <option value="<?php echo $city['ID_tinhthanh']; ?>" <?php echo $userDetail['city_id'] == $city['ID_tinhthanh'] ? 'selected="selected"' : ''; ?>>
                                <?php echo $city['tentinhthanh']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <br><br>

                    <select name="district" class="district">
                        <option value="">== Vui lòng chọn quận ==</option>
                        <?php foreach ($arrDistrict as $district): ?>
                            <option value="<?php echo $district['ID_quanhuyen']; ?>"><?php echo $district['tenquanhuyen']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <br>

                    <button type="submit" class="btn btn-info">Đăng ký</button>
                </form>
            </div> <!-- end col-->
            <p>&nbsp;</p>
        </div> <!-- end container-->
    </div> <!-- end login-->
    <?php include("footer.php"); ?>
</body>
</html>

<script>
    $(document).ready(function () {

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

                            xHtml += '<option value="' + v.ID_quanhuyen + '">' + v.tenquanhuyen + '</option>';
                        })

                    } else {

                    }

                    $('select.district').html(xHtml);
                }
            });
        });
    });
</script>