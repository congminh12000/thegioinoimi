<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">TRANG CHỦ</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">GIỚI THIỆU <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="intro_ora.php">ORA Salon</a></li>
                        <li><a href="intro_hoaly.php">Đào tạo Hoa Ly's</a></li>
                        <li><a href="intro_eyelash.php">Sản phẩm nối mi</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" id="menu_general_product" class="dropdown-toggle" data-toggle="dropdown">SẢN PHẨM <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="product.php">Tất cả sản phẩm</a></li>
                        <?php include("inc_menubarproduct.php"); ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">ĐÀO TẠO <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="page_kh.php">Khóa học</a></li>
                        <li><a href="page_lh.php">Lịch học</a></li>
                        <li><a href="#">Tài liệu</a></li>
                    </ul>
                </li>
                <li><a href="page_cnv.php">CÂY NHÍP VÀNG</a></li>
                <li><a href="page_sk.php">SỰ KIỆN</a></li>
                <li><a href="page_ktcm.php">KIẾN THỨC CHUYÊN MÔN</a></li>
                <li><a href="page_cs.php">CHÍNH SÁCH</a></li>
                <li><a href="contact.php">LIÊN HỆ</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div>
</nav>

<script>
//    $(document).ready(function () {
//        $('#menu_general_product').click(function () {
//            
//            window.location = 'product.php';
//        });
//    });
</script>