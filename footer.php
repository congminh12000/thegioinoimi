<?php session_start(); ?>
<footer class="bottom_tail">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 box_footer">
                <img src="images/logo-ora.png" alt="Công Ty TNHH Thương Mại Lyan" height="60px">
                <p>ORA Nails Eyelash Salon là salon nhượng quyền chuyên chăm sóc mi & móng đầu tiên ở Việt Nam của hệ thống salon ORA Taiwan.</p>
                <h4><a href="https://www.facebook.com/orasalon.vn/" target="_blank"><i class="fa fa-facebook-square fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<a href="mailto:hoalys.lyan@gmail.com"><i class="fa fa-google-plus-square fa-lg" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;<a href="https://www.youtube.com/channel/UCfVxSLLKyiyrQFCqg6IKOWQ/videos" target="_blank"><i class="fa fa-youtube-play fa-lg" aria-hidden="true"></i></a></h4>
                <div id="fb-root"></div>
                <script>(function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id))
                            return;
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.9&appId=883184878397689";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                <div class="fb-page" data-href="https://www.facebook.com/orasalon.vn" data-width="350" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/orasalon.vn/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/orasalon.vn/">ORA Salon</a></blockquote></div>
            </div> <!-- end box_footer-->
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 box_footer">
                <a href="index.php" target="_self"><img src="images/logo.png" alt="Công Ty TNHH Thương Mại Lyan" height="60px"></a>
                <p>Vẻ đẹp của bạn là niềm tự hào và động lực cho chúng tôi luôn cố gắng!</p>
                <h4><a href="https://www.facebook.com/hoaly.vn/" target="_blank"><i class="fa fa-facebook-square fa-lg" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;<a href="mailto:hoalys.lyan@gmail.com"><i class="fa fa-google-plus-square fa-lg" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;<a href="https://www.youtube.com/channel/UCfVxSLLKyiyrQFCqg6IKOWQ/videos" target="_blank"><i class="fa fa-youtube-play fa-lg" aria-hidden="true"></i></a></h4>
                <div id="fb-root"></div>
                <script>(function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id))
                            return;
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.9&appId=883184878397689";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                <div class="fb-page" data-href="https://www.facebook.com/hoaly.vn/" data-width="350" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/hoaly.vn/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/hoaly.vn/">HoaLy&#039;s Eyelash Nails</a></blockquote></div>
            </div> <!-- end box_footer-->
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 box_footer">
                <h3>Thông tin liên hệ</h3>
                <span class="line3"></span>
                <h4><i class="fa fa-globe" aria-hidden="true"></i> 365 Sư Vạn Hạnh, Phường 12, Quận 10, TP.HCM</h4>
                <h4><i class="fa fa-phone-square" aria-hidden="true"></i> Hotline: <a href="tel:0965777515">0965 777 515</a> - <i class="fa fa-phone-square" aria-hidden="true"></i> Tel: <a href="tel:0862822555">08 62 822 555</a></h4>
                <h4><i class="fa fa-envelope" aria-hidden="true"></i> Email: hoalys.lyan@gmail.com</h4><br>
                <h3>Chính sách</h3>
                <span class="line3"></span>
                <?php include("index_cs.php"); ?>
            </div> <!-- end box_footer-->
        </div> <!-- end row-->
    </div> <!-- end container-->
</footer> <!-- end footer-->
<div class="copyright">
    <div class="container">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            &copy; Copyright 2017 by Hoa Ly's Eyelash. All Rights Reserved. Designed by <a href="https://www.teamdnt.website" target="_blank">TeamDnT - WedDesign</a>.
        </div>
    </div> <!-- end container-->
</div> <!-- end copyright-->

<script>
    var userId = <?php echo (int) $_SESSION['user']['ID_account']; ?>;

    $(document).ready(function () {
        $('.btn-add-cart').click(function () {
            var that = $(this);

            if (userId == 0) {
                alert('Vui lòng đăng nhập trước khi mua hàng !');
                return false;
            }

            var productId = $(this).data('id');
            var isTypeMenubar2 = $(this).data('is-type-menubar2');
            if (typeof isTypeMenubar2 != 'undefined') {
                var typeMenubar2Id = $(this).data('type-menubar2');

                loadTypeMenubar2(that, productId, typeMenubar2Id);
            } else {
                var typeMenubar2Id = $('.type-menubar2').val();

                if (typeof typeMenubar2Id == 'undefined') {
                    typeMenubar2Id = 0;
                }

                ajaxHandleAddCart(that, productId, typeMenubar2Id)
            }

        });

        $('.btn-update-sl').click(function () {
            var that = $(this);
            var productId = $(this).data('id');
            var sl = $(this).closest('div').find('input.so-luong-sp').val();
            var price = $(this).data('price');
            var typeMenubar2Id = $(this).data('type-menubar2');
            if (productId == '' || productId == 0) {
                alert('Lỗi !');
                return false;
            }

            $.ajax({
                url: 'update_sl.php',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    productId: productId,
                    sl: sl,
                    typeMenubar2Id: typeMenubar2Id
                },
                success: function (result) {

                    if (!result.isError) {
                        var totalPriceProd = price * sl;
                        var oldSl = result.data.oldSl;
                        var oldPrice = oldSl * price;
                        var oldSumTotal = $('.sum-total').data('price');
                        var newSumTotal = oldSumTotal - oldPrice + totalPriceProd;
                        that.closest('.cart-product').find('.total-price').html(totalPriceProd + ' đ');
                        $('.sum-total').html(newSumTotal + ' đ');
                        $('.sum-total').data('price', newSumTotal);
                    } else {
//                    alert(result.message);
                    }
                }
            })
        });
        $('.btn-remove-prod').click(function () {
            var that = $(this);
            var productId = $(this).data('id');
            var typeMenubar2Id = $(this).data('type-menubar2');
            var price = $(this).data('price');
            if (productId == '' || productId == 0) {
                alert('Lỗi !');
                return false;
            }

            $.ajax({
                url: 'remove_product.php',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    productId: productId,
                    typeMenubar2Id: typeMenubar2Id
                },
                success: function (result) {

                    if (!result.isError) {
                        var sl = result.data.sl;
                        var totalPriceProd = price * sl;
                        var oldSumTotal = $('.sum-total').data('price');
                        var newSumTotal = oldSumTotal - totalPriceProd;
                        $('.sum-total').html(newSumTotal + ' đ');
                        $('.sum-total').data('price', newSumTotal);
                        that.closest('.cart-product').fadeOut(function () {
                            $(this).remove();
                        });
                    } else {
//                    alert(result.message);
                    }
                }
            })
        });
        function loadTypeMenubar2(that, productId, typeMenubar2Id) {

            $.ajax({
                url: 'get_type_menubar2.php',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    typeMenubar2Id: typeMenubar2Id
                },
                success: function (result) {

                    if (!result.isError) {
                        var arrType = result.data.arrType;
                        var _inputOptions = {};

                        $.each(arrType, function (k, v) {
                            _inputOptions[v.ID_type_menubar2] = v.tm2_name;
                        })

                        swal({
                            title: 'Vui lòng chọn loại sản phẩm ',
                            input: 'select',
                            inputOptions: _inputOptions,
                            inputValidator: function (value) {
                                return new Promise(function (resolve, reject) {

                                    ajaxHandleAddCart(that, productId, value);
                                    resolve()
                                })
                            },
                            showCloseButton: true,
                            showCancelButton: true
                        })
                    } else {
                        ajaxHandleAddCart(that, productId, 0);
                    }
                }
            });

        }

        function ajaxHandleAddCart(that, productId, typeMenubar2Id) {

            if (productId == '' || productId == 0) {
                alert('Lỗi !');
                return false;
            }

            $.ajax({
                url: 'handle_add_cart.php',
                type: 'GET',
                dataType: 'JSON',
                data: {
                    productId: productId,
                    typeMenubar2Id: typeMenubar2Id
                },
                success: function (result) {

                    if (!result.isError) {
                        var nums = result.data.nums;
                        var icon = '<i class="glyphicon glyphicon-ok"></i>';
                        $('.cart-nums').html(nums);
                        //show success
                        that.closest('div').find('.success-add-cart').show(function () {
                            var _that = $(this);

                            setTimeout(function () {
                                _that.hide();
                            }, 3000);
                        });
                    } else {
//                    alert(result.message);
                    }
                }
            })
        }
    });
</script>