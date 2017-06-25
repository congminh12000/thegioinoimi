<?php session_start(); ?>
<footer class="bottom_tail">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 box_footer">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <a href="index.php" target="_self"><img src="images/logo.png" alt="Công Ty TNHH Thương Mại Lyan" height="68px"></a>
                </div>
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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <img src="images/logo-ora.png" alt="Công Ty TNHH Thương Mại Lyan" height="60px">
                </div>
                <p>ORA Nails Eyelash Salon là salon nhượng quyền chuyên chăm sóc mi & móng đầu tiên ở Việt Nam của hệ thống salon ORA Taiwan.</p>
                <h4><a href="https://www.facebook.com/orasalon.vn/" target="_blank"><i class="fa fa-facebook-square fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;<a href="mailto:hoalys.lyan@gmail.com"><i class="fa fa-google-plus-square fa-lg" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;<a href="https://www.youtube.com/channel/UCfVxSLLKyiyrQFCqg6IKOWQ/videos" target="_blank"><i class="fa fa-youtube-play fa-lg" aria-hidden="true"></i></a></h4>
                <a href="https://www.youtube.com/channel/UCfVxSLLKyiyrQFCqg6IKOWQ/videos" target="_blank"><img src="images/footer-youtubeiframe.png" alt="Công Ty TNHH Thương Mại Lyan" class="img-responsive"></a>

            </div> <!-- end box_footer-->
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 box_footer">
                <h3>Thông tin liên hệ</h3>
                <span class="line3"></span>
                <h5><i class="fa fa-globe" aria-hidden="true"></i> 365 Sư Vạn Hạnh, Phường 12, Quận 10, TP.HCM</h4>
                    <h5><i class="fa fa-phone-square" aria-hidden="true"></i> Hotline: <a href="tel:0965777515">0965 777 515</a> - <i class="fa fa-phone-square" aria-hidden="true"></i> Tel: <a href="tel:0862822555">08 62 822 555</a></h4>
                        <h5><i class="fa fa-envelope" aria-hidden="true"></i> Email: hoalys.lyan@gmail.com</h4><br>
                            <h3><a href="page_cs.php" target="_self">Chính sách</a></h3>
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
                            <a href="#" class="scrollToTop"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>

                            <script>
                                var userId = <?php echo (int) $_SESSION['user']['ID_account']; ?>;

                                $(document).ready(function () {
                                    $(document).off('click', '.btn-add-cart').on('click', '.btn-add-cart', function (e) {

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

                                            var _html = '<div class="col-md-5"><label>Số lượng: </label></div><div class="col-md-6 text-left"><input id="swal-qty" type="number" class="" min="1" value="1"></div><br><br>';

                                            swal({
                                                title: '<label style="color: #7E3F98">Thông tin</label>',
                                                html: _html,
                                                allowOutsideClick: false,
                                                confirmButtonText: 'Hoàn tất',
                                                cancelButtonText: 'Hủy bỏ',
                                                preConfirm: function () {
                                                    return new Promise(function (resolve) {
                                                        var swalQty = $('#swal-qty').val();
                                                        var swalType = $('.swal-type');
                                                        var arrTypeChoose = [];
                                                        var isError = false;

                                                        if (typeof swalType != 'undefined') {

                                                            $.each(swalType, function (k, v) {

                                                                if ($(this).val() == 0) {
                                                                    isError = true;
                                                                }

                                                                arrTypeChoose.push($(this).val());
                                                            })
                                                        }

                                                        if (isError) {
                                                            reject('Vui lòng chọn đầy đủ loại !');
                                                            return false;
                                                        }

                                                        ajaxHandleAddCart(that, productId, typeMenubar2Id, swalQty)
                                                        resolve()
                                                    })
                                                },
                                                showCloseButton: true,
                                                showCancelButton: true
                                            })
                                        }
                                        e.preventDefault();
                                    });



                                    $('.btn-update-sl').click(function () {
                                        var that = $(this);
                                        var productId = $(this).data('id');
                                        var sl = $(this).closest('div').find('input.so-luong-sp').val();
                                        var price = $(this).data('price');
                                        var typeMenubar2Id = $(this).data('type-menubar2');
                                        var oldSumTotal = $('.sum-total').data('price');

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
                                                price: price,
                                                oldSumTotal: oldSumTotal,
                                                strTypeMenubar2Id: typeMenubar2Id
                                            },
                                            success: function (result) {

                                                if (!result.isError) {
                                                    var htmlTotalPriceProd = result.data.htmlTotalPriceProd;
                                                    var newSumTotal = result.data.newSumTotal;
                                                    var htmlNewSumTotal = result.data.htmlNewSumTotal;

                                                    that.closest('.cart-product').find('.total-price').html(htmlTotalPriceProd);
                                                    $('.sum-total').html(htmlNewSumTotal);
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
                                                strTypeMenubar2Id: typeMenubar2Id
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

                                    $('.btn-payment-cart').click(function () {

                                        $.ajax({
                                            url: 'check_payment_cart.php',
                                            type: 'GET',
                                            dataType: 'JSON',
                                            success: function (result) {

                                                if (!result.isError) {
                                                    var isPayment = result.data.isPayment;

                                                    if (isPayment) {
                                                        window.location = 'cart.php';
                                                    } else {
                                                        $('.btn-add-cart').trigger('click');
                                                    }

                                                } else {
                                                    //                    alert(result.message);
                                                }
                                            }
                                        })
                                    });


                                    function loadTypeMenubar2(that, productId, typeMenubar2Id) {
                                        console.log(typeMenubar2Id);
                                        $.ajax({
                                            url: 'get_type_menubar2.php',
                                            type: 'GET',
                                            dataType: 'JSON',
                                            data: {
                                                typeMenubar2Id: typeMenubar2Id
                                            },
                                            success: function (result) {

                                                var _html = '<div class="col-md-5"><label>Số lượng: </label></div><div class="col-md-6 text-left"><input id="swal-qty" type="number" class="" min="1" value="1"></div><br><br>';

                                                if (!result.isError) {
                                                    var arrType = result.data.arrType;
                                                    var arrTypeChild = result.data.arrTypeChild;

                                                    if (arrTypeChild != null) {
                                                        $.each(arrTypeChild, function (k, v) {

                                                            _html += '<div class="col-md-5"><label> ' + arrType[k].tm2_name + ': <label></div>';
                                                            _html += '<div class="col-md-6 text-left"><select class="swal-type" id="swal-type-' + arrType[k].tm2_name + '">';

                                                            var _inputOptions = '<option value="0">== Chọn ' + arrType[k].tm2_name + ' ==</option>';

                                                            $.each(v, function (_k, _v) {

                                                                _inputOptions += '<option value="' + _v.ID_type_menubar2 + '">' + _v.tm2_name + '</option>';
                                                            })

                                                            _html += _inputOptions;
                                                            _html += '</select></div><br><br>';
                                                        });
                                                    }

                                                } else {
                                                }

                                                swal({
                                                    title: '<label style="color: #7E3F98">Thông tin</label>',
                                                    html: _html,
                                                    allowOutsideClick: false,
                                                    confirmButtonText: 'Hoàn tất',
                                                    preConfirm: function () {
                                                        return new Promise(function (resolve, reject) {
                                                            var swalType = $('.swal-type');
                                                            var swalQty = $('#swal-qty').val();
                                                            var arrTypeChoose = [];
                                                            var isError = false;

                                                            if (typeof swalType != 'undefined') {

                                                                $.each(swalType, function (k, v) {

                                                                    if ($(this).val() == 0) {
                                                                        isError = true;
                                                                    }

                                                                    arrTypeChoose.push($(this).val());
                                                                })
                                                            }

                                                            if (isError) {
                                                                reject('Vui lòng chọn đầy đủ loại !');
                                                                return false;
                                                            }

                                                            ajaxHandleAddCart(that, productId, arrTypeChoose, swalQty);
                                                            resolve()
                                                        })
                                                    },
                                                    showCloseButton: true,
                                                    showCancelButton: false
                                                })
                                            }
                                        });

                                    }

                                    function ajaxHandleAddCart(that, productId, arrTypeChoose, qty) {

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
                                                arrTypeMenubar2Id: arrTypeChoose,
                                                qty: qty
                                            },
                                            success: function (result) {

                                                if (!result.isError) {
                                                    var nums = result.data.nums;
                                                    $('.cart-nums').html(nums);

                                                } else {
                                                    //                    alert(result.message);
                                                }
                                            }
                                        })
                                    }



                                });

//                                var bottom = document.getElementsByClassName('bottom_tail')[0];
//                                var bottomPosition = bottom.getBoundingClientRect().top;
                                var showStaticMenuBar = false;
                                var showStaticMenuMenu = false;

                                $(window).scroll(function () {

                                    var min = 420;
                                    var max = 1500;

                                    //if the static menu is not yet visible...
                                    if (showStaticMenuBar == false) {
                                        //if I scroll more than 200px, I show it 
                                        if ($(window).scrollTop() >= min && $(window).scrollTop() <= max) {
                                            //showing the static menu
                                            $('#banner-scroll').addClass('fixed');

                                            showStaticMenuBar = true;

                                        }

                                    }
                                    //if the static menu is already visible...
                                    else {


                                        if ($(window).scrollTop() < min || $(window).scrollTop() > max) {
                                            $('#banner-scroll').removeClass('fixed');

                                            //I define it as hidden
                                            showStaticMenuBar = false;
                                        }
                                    }

                                    if (showStaticMenuMenu == false) {
                                        //if I scroll more than 200px, I show it 
                                        if ($(window).scrollTop() >= 200) {
                                            //showing the static menu
                                            $('#menu-scroll').addClass('fixed');

                                            showStaticMenuMenu = true;

                                        }

                                    }
                                    //if the static menu is already visible...
                                    else {


                                        if ($(window).scrollTop() < 200) {
                                            $('#menu-scroll').removeClass('fixed');

                                            //I define it as hidden
                                            showStaticMenuMenu = false;
                                        }
                                    }
                                });
                            </script>