<?php 
require_once('Connections/cnn_hoaly.php');
mysql_select_db($database_cnn_hoaly, $cnn_hoaly);

session_start();
$user = $_SESSION['user'];
$id_account = (int) $user['ID_account'];

if($id_account == 0){
    header('Location: dntgate.php');
}

//save order
if($_POST){
    $fullname = trim($_POST['fullname']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $note = $_POST['note'];
    
    $cart = $_SESSION['cart'][$id_account];

    if($cart){
        //get price access level
        require_once ('includes/my/price.php');
        $classPrice = new Price();
        $arrProdCart = $classPrice->productCartToAccessLevel();
        
        $grandTotal = 0;
//    echo '<pre>';print_r($cart);die;  
        foreach($arrProdCart as $prod){
            $grandTotal += $prod['price_access_level'] * $prod['qty_cart'];
        }
        
        //insert orders
        $strKeys = '`status`, total_qty, grand_total, receiver_name, receiver_phone, receiver_email, receiver_address, receiver_note, buyer_id';
        $strValuesOrder = "'pending', '{$cart['nums']}', '{$grandTotal}', '{$fullname}', '{$phone}', '{$email}', '{$address}', '{$note}', '{$id_account}'";
        
        $strQuery = "INSERT INTO orders({$strKeys}) VALUES({$strValuesOrder})";
        mysql_query($strQuery);
        
        $orderId = mysql_insert_id();
        
        //insert order_item
        $strKeys = 'ID_order, qty_ordered, ID_product, grand_total, price_access_level';
        
        $strValuesItem = '';
        foreach($arrProdCart as $prod){
            $grandTotal = $prod['price_access_level'] * $prod['qty_cart'];
            
            $strValuesItem .= "('{$orderId}', '{$prod['qty_cart']}', '{$prod['ID_product']}', '{$grandTotal}', {$prod['price_access_level']}),";
        }
        $strValuesItem = rtrim($strValuesItem, ',');
        
        $strQuery = "INSERT INTO order_item({$strKeys}) VALUES{$strValuesItem}";
        
        mysql_query($strQuery);
    }
}

//remove session cart
unset($_SESSION['cart'][$id_account]);
?>
<!DOCTYPE html>
<html>
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
<script src="build/mediaelement-and-player.min.js"></script><!-- Audio/Video Player jQuery -->
<script src="build/mep-feature-playlist.js"></script><!-- Playlist JavaSCript -->
<link rel="stylesheet" href="css/progression-player.css" /><!-- Default Player Styles -->	
<link rel="stylesheet" href="css/skin-default-dark.css" /><!-- Dark Skin -->
</head>

<body>
	<header class="top_header">
    	<div class="container">
        	<div class="row">
                <?php include("header.php");?>
            </div><br> <!--end row-->
        	<div class="row">
                <div class="col-xs-12 co-sm-12 col-md-12 col-lg-12">
                	<?php include("menubar.php");?>
                </div>
           	 </div> <!-- end row-->
        </div> <!-- end container-->
    </header> <!-- end header-->
    <div class="slideshow">
    	<div class="container-fluid">
   	   	 	<img src="images/demo-banner.png" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive">
        </div> <!-- end container-->
    </div> <!-- end slideshow-->
    <div class="intro">
    	<div class="container">
        	<div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 col-md-push-2 text-center">
            	<h2>CẢM ƠN QUÝ KHÁCH TIN TƯỞNG & CHỌN MUA SẢN PHẨM<br>TẠI HOA LY'S EYELASHES</h3>
                <a href="index.php" class="btn btn-info" role="button">TRANG CHỦ</a>
                </div> <!-- end col-->
            </div> <!-- end row-->
        </div> <!-- end container-->
    </div> <!-- end intro-->
    <?php include("footer.php");?>
</body>
</html>
