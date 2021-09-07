<!--===============================================================================================-->
<script src="/assets/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="/assets/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="/assets/bootstrap/js/popper.js"></script>
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="/assets/select2/select2.min.js"></script>
<script>
    $(".js-select2").each(function() {
        $(this).select2({
            minimumResultsForSearch: 20,
            dropdownParent: $(this).next('.dropDownSelect2')
        });
    })
</script>
<!--===============================================================================================-->
<script src="/assets/daterangepicker/moment.min.js"></script>
<script src="/assets/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="/assets/slick/slick.min.js"></script>
<script src="/js/slick-custom.js"></script>
<!--===============================================================================================-->
<script src="/assets/parallax100/parallax100.js"></script>
<script>
    $('.parallax100').parallax100();
</script>
<!--===============================================================================================-->
<script src="/assets/MagnificPopup/jquery.magnific-popup.min.js"></script>
<script>
    $('.gallery-lb').each(function() { // the containers for all your galleries
        $(this).magnificPopup({
            delegate: 'a', // the selector for gallery item
            type: 'image',
            gallery: {
                enabled: true
            },
            mainClass: 'mfp-fade'
        });
    });
</script>
<!--===============================================================================================-->
<script src="/assets/isotope/isotope.pkgd.min.js"></script>
<!--===============================================================================================-->
<script src="/assets/sweetalert/sweetalert.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('.js-addwish-b2').on('click', function(e) {
        e.preventDefault();
    });

    $('.js-addwish-b2').each(function() {
        var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
        $(this).on('click', function() {
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass('js-addedwish-b2');
            $(this).off('click');
        });
    });

    $('.js-addwish-detail').each(function() {
        var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

        $(this).on('click', function() {
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass('js-addedwish-detail');
            $(this).off('click');
        });
    });

    /*---------------------------------------------*/

    $('.js-addcart-detail').each(function() {
        $(this).on('click', function() {
            let id = $(this).parent().parent().parent().parent().find('.js-product-id').val();
            let name = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
            let numOrder = $(this).parent().find('.num-product').val();

            if (numOrder == 0) {
                Swal.fire({
                    title: `Invalid Order`,
                    text: 'Cannot place order with 0 quantity.',
                    icon: "warning",
                    customClass: {
                        container: 'myswal2'
                    },
                    timer: 1000,
                    timerProgressBar: true,
                });
                return;
            }

            Swal.fire({
                title: `Confirm Order?`,
                text: `${numOrder} of ${name}`,
                icon: 'question',
                customClass: {
                    container: 'myswal2'
                },
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Add",
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    let formdata = new FormData();
                    formdata.set('id', parseInt(id));
                    formdata.set('numOrder', parseInt(numOrder));

                    return fetch('/cart/add', {
                            method: "POST",
                            body: formdata,
                        })
                        .then((response) => {
                            if (!response.ok) {
                                throw new Error(response.statusText);
                            }
                            response.json().then(json => {
                                let cartIcon = document.querySelector('.js-show-cart');
                                let len = Object.keys(json).length;
                                cartIcon.setAttribute('data-notify', len);
                            })
                        })
                        .catch((error) => {
                            Swal.showValidationMessage(`Request failed: ${error}`);
                        });
                },
                backdrop: true,
                allowOutsideClick: () => !Swal.isLoading(),
            }).then(res => {
                if (res.isConfirmed) {
                    Swal.fire({
                            title: "Success!",
                            icon: "success",
                            timer: 1000,
                            timerProgressBar: true,
                            customClass: {
                                container: 'myswal2'
                            },
                        })
                        .then((res) => {
                            document.querySelector('.js-hide-modal1').click();
                        });
                }
            });
        });
    });
</script>
<!--===============================================================================================-->
<script src="/assets/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script>
    $('.js-pscroll').each(function() {
        $(this).css('position', 'relative');
        $(this).css('overflow', 'hidden');
        var ps = new PerfectScrollbar(this, {
            wheelSpeed: 1,
            scrollingThreshold: 1000,
            wheelPropagation: false,
        });

        $(window).on('resize', function() {
            ps.update();
        })
    });
</script>
<!--===============================================================================================-->
<script src="/js/main.js"></script>