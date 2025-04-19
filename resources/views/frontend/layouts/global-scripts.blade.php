<script>
    /** Show sweetalert confirm **/
    $('body').on('click', '.delete-item', function(e) {
        e.preventDefault();

        let url = $(this).attr('href');
        Swal.fire({
            title: "Confirm Delete",
            text: "Are you sure you want to delete this slider?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'DELETE',
                    url: url,
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            window.location.reload();
                        } else {
                            if (response.status === 'error') {
                                toastr.error(response.message);
                            }
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                })
            }
        })
    });


    // Show loader
    function showLoader() {
        $('.overlay').addClass('active');
    }

    // Hide loader
    function hideLoader() {
        $('.overlay').removeClass('active');
    }

    /** Load product modal**/
    function loadProductModal(productId) {
        $.ajax({
            method: 'GET',
            url: "{{ route('product.modal', ':productId') }}".replace(":productId", productId),
            beforeSend: function() {
                $('.overlay-container').removeClass('d-none')
                $('.overlay').addClass('active');
            },
            success: function(response) {
                $(".load_product_modal_body").html(response);
                $("#loadCartModal").modal('show');
            },
            error: function(xhr, status, error) {
                console.error(error);
            },
            complete: function() {
                $('.overlay').removeClass('active');
                $('.overlay-container').addClass('d-none')
            }
        })
    }

    /** Add product to wishlist**/
    function addToWishlist(productId) {
        $.ajax({
            method: 'GET',
            url: "{{ route('wishlist.store', ':productId') }}".replace(":productId", productId),
            beforeSend: function() {
                showLoader()
            },
            success: function(response) {
                toastr.success(response.message);
            },
            error: function(xhr, status, error) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(index, value){
                    toastr.error(value);
                })
                hideLoader();
            },
            complete: function() {
                hideLoader();
            }
        })
    }

    // Update Sidebar Cart
    function updateSidebarCart(callback = null) {
        $.ajax({
            method: 'GET',
            url: "{{ route('get-cart-product') }}",
            success: function(response) {
                $('.cart_contents').html(response);
                let cartTotal = $('#cart_total').val();
                let cartCount = $('#cart_product_count').val();
                $('.cart_subtotal').text("{{ currencyPosition(':cartTotal') }}".replace(':cartTotal',
                    cartTotal));
                $('.cart_count').text(cartCount);

                if (callback && typeof callback === 'function') {
                    callback();
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        })
    }

    // Function to remove a product from the sidebar cart.
    function removeProductFromSidebar($rowId) {
        $.ajax({
            method: 'GET',
            url: '{{ route('cart-product-remove', ':rowId') }}'.replace(":rowId", $rowId),
            beforeSend: function() {
                $('.overlay').addClass('active');
            },
            success: function(response) {
                if (response.status === 'success') {
                    updateSidebarCart(function() {
                        toastr.success(response.message);
                        $('.overlay').removeClass('active');
                    });
                }
            },
            error: function(xhr, status, error) {
                let errorMessage = xhr.responseJSON.message;
                toastr.error(errorMessage);
            }
        })
    }

    // get current cart total amount.
    function getCartTotal() {
        return parseInt("{{ cartTotalPrice() }}")
    }
</script>
