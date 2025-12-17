function showToast(type, message) {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    });

    Toast.fire({
        icon: type,   // success, error, warning, info
        title: message
    });
}





$(document).on('click', '.addToCartBtn', function (e) {
    e.preventDefault();
    // console.log('heeeee');

    let product_id = $(this).data('id');
       let price = $(this).data('price');
    // optional: let qty = parseInt($(this).closest('.product').find('.qty-input').val()) || 1;
    let qty = 1;

    $.ajax({
        url: CART_ROUTE,
        method: "POST",
        data: {
            product_id: product_id,
            qty: qty,  
            price: price,            // match controller validation key          
            _token: CSRF_TOKEN
        },
        success: function (res) {

            console.log(res);

            if(res.status === 'success') {
                showToast('success', res.message);
                $('#cart-count').text(res.count);
            } else {
                showToast('error', res.message || 'Something went wrong!');
            }
        },
        error: function (xhr) {
            // Better error handling: show server message if present
            let msg = 'Something went wrong!';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            } else if (xhr.responseText) {
                msg = xhr.responseText;
            }
             console.error('Add to cart error:', xhr);
            showToast('error', msg);
           
        }
    });
});



// get all cart product 

function loadAllCartItems() {

    $.ajax({
        url: "/cart",
        method: "GET",

        success: function (res) {

            if(res.status){
                let html = '';
                let htmlnew = '';
                let htmlcheck ='';
                let htmlhai ='';
               

                res.cart.forEach(function(item) {

                    let name = item.product?.name ?? item.name;
                    let price = item.product?.price ?? item.price;
                    let qty = item.qty;
                    let image = item.product?.image ?? item.image ?? "/default.png";
                    let total = price * qty;

                    html += `
                    <tr class="cart__table--body__items">

                        <td class="cart__table--body__list">
                            <div class="cart__product d-flex align-items-center">

                            <button 
                            class="cart__remove--btn removeCartItem" 
                            data-id="{{ $item->product_id }}" 
                            data-url="{{ route('cart.remove') }}"
                        >
                        
                        </button>



                                    <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" 
                                        viewBox="0 0 24 24" width="16px" height="16px">
                                        <path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 
                                        L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 
                                        L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 
                                        L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 
                                        L 12 10.585938 L 4.7070312 3.2929688 z" />
                                    </svg>
                                </button>

                                <div class="cart__thumbnail">
                                    <img class="border-radius-5" src="${image}" alt="${name}">
                                </div>

                                <div class="cart__content">
                                    <h4 class="cart__content--title">${name}</h4>
                                    <span class="cart__content--variant">QTY: ${qty}</span>
                                </div>

                            </div>
                        </td>

                        <td class="cart__table--body__list">
                            <span class="cart__price">₹${price}</span>
                        </td>

                        <td class="cart__table--body__list">
                            <div class="quantity__box">

                                <button type="button" 
                                    class="quantity__value decrease updateQty" 
                                    data-id="${item.id ?? item.product_id}"
                                    data-type="minus">-</button>

                                <label>
                                    <input type="number" 
                                        class="quantity__number" 
                                        value="${qty}" disabled />
                                </label>

                                <button type="button" 
                                    class="quantity__value increase updateQty" 
                                    data-id="${item.id ?? item.product_id}"
                                    data-type="plus">+</button>

                            </div>
                        </td>

                        <td class="cart__table--body__list">
                            <span class="cart__price end">₹${total}</span>
                        </td>
                    </tr>
                    `;

                    htmlnew += `
<div class="minicart__product--items d-flex">

    <div class="minicart__thumb">
        <a href="#">
            <img src="${image}" alt="${name}">
        </a>
    </div>

    <div class="minicart__text">

        <h3 class="minicart__subtitle h4">
            <a href="#">${name}</a>
        </h3>

        <span class="color__variant">
            <b>Qty:</b> ${qty}
        </span>

        <div class="minicart__price">
            <span class="current__price">₹${price}</span>
        </div>

        <div class="minicart__text--footer d-flex align-items-center">

            <div class="quantity__box minicart__quantity">

                <button type="button" 
                    class="quantity__value decrease updateQty"
                    data-id="${item.id ?? item.product_id}"
                    data-type="minus">-</button>

                <label>
                    <input type="number" 
                           class="quantity__number" 
                           value="${qty}" 
                           disabled />
                </label>

                <button type="button" 
                    class="quantity__value increase updateQty"
                    data-id="${item.id ?? item.product_id}"
                    data-type="plus">+</button>

            </div>

            <button class="minicart__product--remove removeCartItem"
                data-id="${item.id ?? item.product_id}"
                data-url="/cart/remove">
                Remove
            </button>

        </div>

    </div>
</div>
`;

 htmlcheck += `
<tr class="summary__table--items">
    
    <td class="summary__table--list">
        <div class="product__image two d-flex align-items-center">

            <div class="product__thumbnail border-radius-5">
                <a href="/product/${item.slug}">
                    <img class="border-radius-5" src="${image}" alt="${name}">
                </a>
                <span class="product__thumbnail--quantity">${qty}</span>
            </div>

            <div class="product__description">
                <h3 class="product__description--name h4">
                    <a href="/product/${item.slug}">${name}</a>
                </h3>

                <span class="product__description--variant">
                    ${item.variant ?? 'No Variant'}
                </span>
            </div>

        </div>
    </td>

    <td class="summary__table--list">
        <span class="cart__price">₹${price}</span>
    </td>

</tr>
`;


htmlhai += `
<tr class="cart__table--body__items">
    
    <td class="cart__table--body__list">
        <div class="product__image two d-flex align-items-center">
            
            <div class="product__thumbnail border-radius-5">
                <a href="/product/${item.slug}">
                    <img class="border-radius-5" src="${image}" alt="${name}">
                </a>
                <span class="product__thumbnail--quantity">${qty}</span>
            </div>

            <div class="product__description">
                <h3 class="product__description--name h4">
                    <a href="/product/${item.slug}">${name}</a>
                </h3>
                <span class="product__description--variant">
                    variant
                </span>
            </div>

        </div>
    </td>

    <td class="cart__table--body__list">
        <span class="cart__price">₹${price}</span>
    </td>

</tr>
`;




                });

                $(".cart-items-box").html(html);
                $(".minicart").html(htmlnew);
                $(".checkoutbody").html(htmlcheck);
                $(".newcheckbody").html(htmlhai);
                updateCartCount();
                loadAllCartItems();
                totalAmount();
            }
        }
    });

}

$(document).ready(function() {
    loadAllCartItems();
    // totalAmount();
});

$(document).on('click', '.removeCartItem', function (e) {
    e.preventDefault();
    let product_id = $(this).data('id');
    let url = $(this).data('url'); // ← NOW URL IS CORRECT

    $.ajax({
        url: url,
        method: "POST",
        data: {
            product_id: product_id,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            loadAllCartItems();
        }
    });
});


function updateCartCount() {
     let url = $('.cart_item').data('cart-url');

    $.ajax({
        url: url,
        method: "GET",
        success: function(res) {
            $('.cart_item').text(res.count);
                },
        error: function(xhr) {
        }
    });
}

function totalAmount() {
    let url = $('.totalAmount').data('cart-url');

    $.ajax({  
        url: url,
        method: "GET",
        success: function(res) {
            // console.log(res);
           
            $('.cartTotalAmount').text(res.total_amount); // 👈 NEW
        },
        error: function(xhr) {
            // console.log(xhr);
        }
    });
}

$(document).on('click', '.view_modal', function (e) {
    e.preventDefault();

    let product_id = $(this).data('id');

    $.ajax({
        url: '/modaldata',
        method: "GET",
        data: { product_id: product_id },

        success: function (res) {

            let html = `
            <div class="modal-dialog quickview__main--wrapper">
                <header class="modal-header quickview__header">
                    <button class="close-modal quickview__close--btn" aria-label="close modal" data-close>
                        <svg xmlns="http://www.w3.org/2000/svg" width="28.163" height="28.163" viewBox="0 0 28.163 28.163">
                            <path d="M17.252,14.69l10.3-10.3a1.811,1.811,0,1,0-2.56-2.56l-10.3,10.3L4.4,1.823A1.811,1.811,0,0,0,1.837,4.383l10.3,10.3-10.3,10.3a1.811,1.811,0,1,0,2.56,2.56l10.3-10.3,10.3,10.3a1.811,1.811,0,0,0,2.56-2.56Z" transform="translate(0 -0.293)" fill="currentColor"/>
                        </svg>
                    </button>
                </header>

                <div class="quickview__inner">

                    <div class="row row-cols-lg-2 row-cols-md-2">

                        <!-- Product Image -->
                        <div class="col">
                            <div class="quickview__details--media mb-30">
                                <div class="quickview__media--preview swiper">
                                    <div class="swiper-wrapper">

                                        <div class="swiper-slide">
                                            <div class="product__media--preview__items">
                                                <img class="product__media--preview__items--img"
                                                     src="/uploads/products/${res.image}" 
                                                     alt="${res.name}">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="quickview__media--nav swiper">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="product__media--nav__items">
                                                <img class="product__media--nav__items--img"
                                                     src="/uploads/products/${res.image}" 
                                                     alt="${res.name}">
                                            </div>
                                        </div>

                                        ${res.images ? res.images.map(img => `
                                        <div class="swiper-slide">
                                            <div class="product__media--nav__items">
                                                <img class="product__media--nav__items--img"
                                                     src="/uploads/products/${img}" 
                                                     alt="${res.name}">
                                            </div>
                                        </div>`).join('') : ''}
                                    </div>
                                </div>

                            </div>
                        </div>


                        <!-- Product Details -->
                        <div class="col">
                            <div class="quickview__info">
                                
                                <h2 class="quickview__title mb-15">${res.name}</h2>

                                <div class="quickview__price mb-10">
                                    <span class="current__price">₹${res.price}</span>
                                    <span class="old__price">₹${res.dp_price}</span>
                                </div>

                                <div class="quickview__rating d-flex align-items-center mb-15">
                                    <ul class="rating d-flex">
                                        <li class="rating__list">
                                            <span class="rating__icon">
                                                ★★★★☆
                                            </span>
                                        </li>
                                    </ul>
                                    <span class="quickview__review--text">( 32 reviews )</span>
                                </div>

                                <p class="quickview__desc mb-15">
                                    ${res.description}
                                </p>

                                <div class="quickview__variant">

                                    <!-- SIZE -->
                                    <div class="product__variant--list mb-20">
                                        <fieldset class="variant__input--fieldset">
                                            <legend class="product__variant--title mb-8">Size :</legend>

                                            ${res.sizes ? res.sizes.map((size, i) => `
                                                <div class="variant__input--item">
                                                    <input id="size_${i}" name="size" type="radio" ${i === 0 ? 'checked' : ''}>
                                                    <label for="size_${i}" class="variant__size--value border-radius-5">${size}</label>
                                                </div>
                                            `).join('') : `
                                                <p>No sizes available</p>
                                            `}

                                        </fieldset>
                                    </div>

                                    <!-- QTY -->
                                    <div class="product__variant--list mb-15">
                                        <div class="quantity__box">
                                            <button class="quantity__value decrease">−</button>
                                            <input class="quantity__number" type="number" min="1" value="1">
                                            <button class="quantity__value increase">+</button>
                                        </div>
                                    </div>

                                    <!-- BUTTON -->
                                    <div class="quickview__variant--btn d-flex align-items-center mb-20">
                                        <button class="primary__btn btn__style3 addToCartBtn"
                                                data-id="${res.id}">
                                            Add To Cart
                                        </button>
                                    </div>

                                </div>

                                <div class="product__details--info__meta">
                                    <p class="product__details--meta"><strong>Category :</strong> 
                                        ${res.category_name}
                                    </p>
                                    <p class="product__details--meta"><strong>SKU :</strong> 
                                        ${res.sku ?? 'N/A'}
                                    </p>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            `;

            $(".modal-data").html(html);
        }
    });
});



$(document).on('click', '.decrease', function () {
    let product_id = $(this).data('id');

    $.post('/cart/decrease', {
        product_id: product_id,
        _token: $('meta[name="csrf-token"]').attr('content')
    }, function () {
        loadAllCartItems();
    });
});


$(document).on('click', '.increase', function () {
    let product_id = $(this).data('id');

    $.post('/cart/increase', {
        product_id: product_id,
        _token: $('meta[name="csrf-token"]').attr('content')
    }, function () {
        loadAllCartItems();
    });
});




$(document).on('click', '.addToWish', function (e) {
    e.preventDefault();

    let product_id = $(this).data('id');
    let price = $(this).data('price');
    // optional: let qty = parseInt($(this).closest('.product').find('.qty-input').val()) || 1;
    let qty = 1;

    $.ajax({
        url: CART_ROUTE,
        method: "POST",
        data: {
            product_id: product_id,
            qty: qty, 
            price:price,            // match controller validation key
           
            _token: CSRF_TOKEN
        },
        success: function (res) {

            // console.log(res);

            if(res.status === 'success') {
                showToast('success', res.message);
                $('#cart-count').text(res.count);
            } else {
                showToast('error', res.message || 'Something went wrong!');
            }
        },
        error: function (xhr) {
            // Better error handling: show server message if present
            let msg = 'Something went wrong!';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            } else if (xhr.responseText) {
                msg = xhr.responseText;
            }
            showToast('error', msg);
            // console.error('Add to Wishlist error:', xhr);
        }
    });
});


function wishlistcount() {
     let url = $('.wishlist_item').data('cart-url');

    $.ajax({
        url: url,
        method: "GET",
        success: function(res) {
            $('.wishlist_item').text(res.count);
                },
        error: function(xhr) {
        }
    });
}
wishlistcount();

function loadAllWishlistItems() {

    $.ajax({
        url: "/wishlistproduct",
        method: "GET",

        success: function (res) {

            // console.log(res);

            if(res.status){
                let html = '';
                           
                res.wishlist.forEach(function(item) {

                    let name  = item.product?.name ?? item.name;
                    let price = item.product?.price ?? item.price;
                    let qty   = item.qty ?? 1;

                    let image = item.product?.image ?? item.image ?? "/default.png";

                    let stock = item.product?.stock ?? item.stock ?? 0;

                    let productUrl = item.slug 
                        ? `/product/${item.slug}` 
                        : 'javascript:void(0)';

                    let removeUrl = "/wishlist/remove"; // apna route

                    let color  = item.color ?? null;
                    let weight = item.weight ?? null;

                    html += `
<tr class="cart__table--body__items">

    <td class="cart__table--body__list">
        <div class="cart__product d-flex align-items-center">

            <button 
                class="cart__remove--btn removeWishlistItem" 
                data-id="${item.id}"
                data-url="${removeUrl}"
                type="button"
            >
                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" 
                    viewBox="0 0 24 24" width="16px" height="16px">
                    <path d="M4.707 3.293L3.293 4.707 10.586 12 3.293 19.293 
                    4.707 20.707 12 13.414 19.293 20.707 20.707 19.293 
                    13.414 12 20.707 4.707 19.293 3.293 12 10.586z"/>
                </svg>
            </button>

            <div class="cart__thumbnail">
                <a href="${productUrl}">
                    <img class="border-radius-5" src="${image}" alt="${name}">
                </a>
            </div>

            <div class="cart__content">
                <h4 class="cart__content--title">
                    <a href="${productUrl}">${name}</a>
                </h4>
            </div>

        </div>
    </td>

    <td class="cart__table--body__list">
        <span class="cart__price">₹${price}</span>
    </td>

    <td class="cart__table--body__list text-center">
        <span class="in__stock text__secondary">
            ${stock > 0 ? 'In Stock' : 'Out of Stock'}
        </span>
    </td>

    <td class="cart__table--body__list text-right">
        <a 
            class="wishlist__cart--btn primary__btn addToCart"
            data-id="${item.product_id}"
            href="javascript:void(0)"
        >
            Add To Cart
        </a>
    </td>

</tr>
`;



                });

                $(".wishbody").html(html);
                
                // updateCartCount();
                // loadAllCartItems();
                // totalAmount();
            }
        }
    });

}

loadAllWishlistItems();


$(document).on("click", ".removeWishlistItem", function () {

    let button = $(this);
    let id = button.data("id");
    let url = button.data("url");

    $.ajax({
        url: url,
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: id
        },
        success: function (res) {

            if (res.status) {
                // row remove (smooth UX)
                button.closest("tr").fadeOut(300, function () {
                    $(this).remove();
                });

                // optional
                loadAllWishlistItems();
                updateWishlistCount();
            } else {
               showToast('error', 'ittem not removed');
            }
        },
        error: function () {
            showToast('error', 'something went wrong');
        }
    });
});



$("#checkoutForm").on("submit", function(e) {
    e.preventDefault();
    
    let url = $(this).data("action");

    // clear old errors
    $(".error-text").text("");

    $.ajax({
        url: url,
        type: "POST",
        data: $(this).serialize(),

        success: function(res) {
            if (res.status) {
                window.location.href = res.redirect;
            }
        },

        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                $.each(errors, function(field, message) {
                    $('.' + field + '_error').text(message[0]);
                });
            }
        }
    });
});





  // page load pe update
  







