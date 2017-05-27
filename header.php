<?php 
session_start();

$user = $_SESSION['user'];
$id_account = (int) $user['ID_account'];

$cart = $_SESSION['cart'][$id_account];
$cart_nums = (int) $cart['nums'];
?>

<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                	<h4><b>Công ty TNHH Thương mại Lyan</b></h4>
                    <h4>365 Sư Vạn Hạnh, Phường 12, Quận 10, TP.HCM</h4>
                	<h4><a href="tel:0965777515">Hotline: 0965 777 515</a> - <a href="tel:0862822555">Tel: 08 62 822 555</a></h4>
                    <h4>Email: <a href="mailto:hoalys.lyan@gmail.com">hoalys.lyan@gmail.com</a></h4>
                </div> <!--end col-->
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-center">
                	<a href="index.php" target="_self"><img src="images/logo2.png" alt="Công Ty TNHH Thương Mại Lyan" width="200px"></a>
                </div> <!--end col-->
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right">
                	<div class="row language_box">
                    	<span class="submenu">
                       		<a href="#" target="_self"><img src="images/vietnameseflag.png">&nbsp;&nbsp;Việt Nam</a>&nbsp;&nbsp;|&nbsp;&nbsp; 
                        </span>
                         <span class="submenu">
                        	<a href="#" target="_self"><img src="images/englishflag.png">&nbsp;&nbsp;English</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                        </span>
                         <span class="submenu">
                        	<a href="#" target="_self"><img src="images/taiwanflag.png">&nbsp;&nbsp;中文 (中国)</a> 
                        </span> 
                    </div> <!--end row-->
                	<div class="row language_box">
                            <?php
                                if($user):
                                    echo '<span class="submenu">Xin chào, ' . ucfirst($user['fullname']) . '</span> | ';
                                    echo '<span class="submenu"><a href="logout.php">Đăng xuất</a></span> |';
                                else:
                                    ?>
                                    <span class="submenu"><a href="dntgate.php" target="_self">Đăng nhập&nbsp;&nbsp;</a></span> |
                            <?php
                                endif;
                            ?>
                       
                        <span class="submenu">
                        	<a href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Giỏ hàng <span class="badge cart-nums"><?php echo $cart_nums; ?></span></a>
                        </span>
                    </div> <!--end row-->
                </div> <!--end col-->