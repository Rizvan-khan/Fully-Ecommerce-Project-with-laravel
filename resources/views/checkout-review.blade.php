@extends('theme.layouts.app')

@section('content')

<!-- Start checkout page area -->
<div class="checkout__page--area">
    <div class="container">
        <div class="checkout__page--inner d-flex">
            <div class="main checkout__mian">
                <header class="main__header checkout__mian--header mb-30">
                    <h1 class="main__logo--title"><a class="logo logo__left mb-20" href="index.html"><img src="assets/img/logo/nav-log.png" alt="logo"></a></h1>
                    <details class="order__summary--mobile__version">
                        <summary class="order__summary--toggle border-radius-5">
                            <span class="order__summary--toggle__inner">
                                <span class="order__summary--toggle__icon">
                                    <svg width="20" height="19" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.178 13.088H5.453c-.454 0-.91-.364-.91-.818L3.727 1.818H0V0h4.544c.455 0 .91.364.91.818l.09 1.272h13.45c.274 0 .547.09.73.364.18.182.27.454.18.727l-1.817 9.18c-.09.455-.455.728-.91.728zM6.27 11.27h10.09l1.454-7.362H5.634l.637 7.362zm.092 7.715c1.004 0 1.818-.813 1.818-1.817s-.814-1.818-1.818-1.818-1.818.814-1.818 1.818.814 1.817 1.818 1.817zm9.18 0c1.004 0 1.817-.813 1.817-1.817s-.814-1.818-1.818-1.818-1.818.814-1.818 1.818.814 1.817 1.818 1.817z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <span class="order__summary--toggle__text show">
                                    <span>Show order summary</span>
                                    <svg width="11" height="6" xmlns="http://www.w3.org/2000/svg" class="order-summary-toggle__dropdown" fill="currentColor">
                                        <path d="M.504 1.813l4.358 3.845.496.438.496-.438 4.642-4.096L9.504.438 4.862 4.534h.992L1.496.69.504 1.812z"></path>
                                    </svg>
                                </span>
                                <span class="order__summary--final__price">$227.70</span>
                            </span>
                        </summary>
                        <div class="order__summary--section">
                            <div class="cart__table checkout__product--table">
                                <table class="summary__table">
                                    <tbody class="summary__table--body checkoutbody">
                                       

                                    </tbody>
                                </table>
                            </div>
                            <div class="checkout__discount--code">
                                <form class="d-flex" action="#">
                                    <label>
                                        <input class="checkout__discount--code__input--field border-radius-5" placeholder="Gift card or discount code" type="text">
                                    </label>
                                    <button class="checkout__discount--code__btn primary__btn border-radius-5" type="submit">Apply</button>
                                </form>
                            </div>
                            <div class="checkout__total">
                                <table class="checkout__total--table">
                                    <tbody class="checkout__total--body">
                                        <tr class="checkout__total--items">
                                            <td class="checkout__total--title text-left">Subtotal </td>
                                            <td class="checkout__total--amount text-right">$860.00</td>
                                        </tr>
                                        <tr class="checkout__total--items">
                                            <td class="checkout__total--title text-left">Shipping</td>
                                            <td class="checkout__total--calculated__text text-right">Calculated at next step</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="checkout__total--footer">
                                        <tr class="checkout__total--footer__items">
                                            <td class="checkout__total--footer__title checkout__total--footer__list text-left">Total </td>
                                            <td class="checkout__total--footer__amount checkout__total--footer__list text-right">$860.00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </details>
                    <nav>
                        <ol class="breadcrumb checkout__breadcrumb d-flex">
                            <li class="breadcrumb__item breadcrumb__item--completed d-flex align-items-center">
                                <a class="breadcrumb__link" href="cart.html">Cart</a>
                                <svg class="readcrumb__chevron-icon" xmlns="http://www.w3.org/2000/svg" width="17.007" height="16.831" viewBox="0 0 512 512">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M184 112l144 144-144 144"></path>
                                </svg>
                            </li>
                            <li class="breadcrumb__item breadcrumb__item--current d-flex align-items-center">
                                <a class="breadcrumb__link" href="cart.html">Information</a>
                                <svg class="readcrumb__chevron-icon" xmlns="http://www.w3.org/2000/svg" width="17.007" height="16.831" viewBox="0 0 512 512">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M184 112l144 144-144 144"></path>
                                </svg>
                            </li>
                            <li class="breadcrumb__item breadcrumb__item--blank d-flex align-items-center">
                                <a class="breadcrumb__link" href="cart.html">Shipping</a>
                                <svg class="readcrumb__chevron-icon" xmlns="http://www.w3.org/2000/svg" width="17.007" height="16.831" viewBox="0 0 512 512">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M184 112l144 144-144 144"></path>
                                </svg>
                            </li>
                            <li class="breadcrumb__item breadcrumb__item--blank">
                                <span class="breadcrumb__text current">Payment</span>
                            </li>
                        </ol>
                    </nav>
                </header>
                <main class="main__content_wrapper">
                    <form id="changeDetail">
                        <div class="checkout__content--step checkout__contact--information2 border-radius-5">
                            <div class="checkout__review d-flex justify-content-between align-items-center">
                                <div class="checkout__review--inner d-flex align-items-center">
                                    <label class="checkout__review--label">Contact</label>
                                    <span class="checkout__review--content">{{ $user->email }},{{ $user->mobile }}</span>
                                </div>
                                <div class="checkout__review--link">
                                    <button class="checkout__review--link__text" type="button">Change</button>
                                </div>
                            </div>
                            <div class="checkout__review d-flex justify-content-between align-items-center">
                                <div class="checkout__review--inner d-flex align-items-center">
                                    <label class="checkout__review--label"> Ship to</label>
                                    <span class="checkout__review--content"> {{ $user->detail->district ?? '' }},{{ $user->detail->state ?? '' }},{{ $user->detail->country ?? '' }},{{ $user->detail->pin_code ?? '' }}</span>
                                </div>
                                <div class="checkout__review--link">
                                    <button class="checkout__review--link__text" type="button">Change</button>
                                </div>
                            </div>

                        </div>

                        <div class="checkout__content--step section__shipping--address pt-15">
                            <div class="section__header mb-25">
                                <h3 class="section__header--title">Billing address</h3>
                                <p class="section__header--desc">Select the address that matches your card or payment method.</p>
                            </div>
                            <div class="checkout__content--step__inner3 border-radius-5">
                                <div class="checkout__address--content__header">
                                    <!-- <div class="shipping__contact--box__list">
                                        <div class="shipping__radio--input">
                                            <input class="shipping__radio--input__field" id="radiobox" name="checkmethod" type="radio">
                                        </div>
                                        <label class="shipping__radio--label" for="radiobox">
                                            <span class="shipping__radio--label__primary">Same as shipping address</span>
                                        </label>
                                    </div> -->
                                    <!-- <div class="shipping__contact--box__list">
                                        <div class="shipping__radio--input">
                                            <input class="shipping__radio--input__field" id="radiobox2" name="checkmethod" type="radio">
                                        </div>
                                        <label class="shipping__radio--label" for="radiobox2">
                                            <span class="shipping__radio--label__primary">Use a different billing address</span>
                                        </label>
                                    </div> -->
                                </div>
                                <div class="checkout__content--input__box--wrapper ">
                                    <div class="row">

                                        <div class="col-lg-12 mb-12">
                                            <div class="checkout__input--list">
                                                <label>
                                                    <input name="name" value="{{$user->name}}" class="checkout__input--field border-radius-5" placeholder="Full name" type="text">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-12">
                                            <div class="checkout__input--list">
                                                <label>
                                                    <input name="address" value="{{ $user->detail->address ?? '' }}" class="checkout__input--field border-radius-5" placeholder="Address1" type="text">
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-12">
                                            <div class="checkout__input--list">
                                                <label>
                                                    <input name="district" value="{{ $user->detail->district ?? '' }}" class="checkout__input--field border-radius-5" placeholder="City" type="text">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-12">
                                            <div class="checkout__input--list checkout__input--select select">
                                                <label class="checkout__select--label" for="country">Country/region</label>
                                                @php
                                                $countries = ['India', 'United States', 'Netherlands'];
                                                @endphp

                                                <select name="country" class="checkout__input--select__field border-radius-5">

                                                    @foreach($countries as $country)
                                                    <option value="{{ $country }}"
                                                        {{ optional($user->detail)->country == $country ? 'selected' : '' }}>
                                                        {{ $country }}
                                                    </option>
                                                    @endforeach

                                                </select>

                                                <small class="text-danger error-text country_error"></small>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-12">
                                            <div class="checkout__input--list">
                                                <label>
                                                    <input name="pin_code" value="{{ $user->detail->pin_code ?? '' }}" class="checkout__input--field border-radius-5" placeholder="Postal code" type="text">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="checkout__content--step__footer d-flex align-items-center">
                           
                        <a class="continue__shipping--btn primary__btn border-radius-5" href="paypal">Pay now</a>
                            <a class="previous__link--content" href="shop.html">Return to shipping</a>
                        </div>
                    </form>
                </main>
                <footer class="main__footer checkout__footer">
                    <p class="copyright__content">Copyright © 2022 <a class="copyright__content--link text__primary" href="index.html">Suruchi</a> . All Rights Reserved.Design By Suruchi</p>
                </footer>
            </div>
            <aside class="checkout__sidebar sidebar">
                <div class="cart__table checkout__product--table">
                    <table class="cart__table--inner">
                        <tbody class="cart__table--body newcheckbody">
                           
                           
                        </tbody>
                    </table>
                </div>
                <div class="checkout__discount--code">
                    <form class="d-flex" action="#">
                        <label>
                            <input class="checkout__discount--code__input--field border-radius-5" placeholder="Gift card or discount code" type="text">
                        </label>
                        <button class="checkout__discount--code__btn primary__btn border-radius-5" type="submit">Apply</button>
                    </form>
                </div>
                <div class="checkout__total">
                    <table class="checkout__total--table">
                        <tbody class="checkout__total--body">
                            <tr class="checkout__total--items">
                                <td class="checkout__total--title text-left">Subtotal </td>
                                <td class="checkout__total--amount text-right">$860.00</td>
                            </tr>
                            <tr class="checkout__total--items">
                                <td class="checkout__total--title text-left">Shipping</td>
                                <td class="checkout__total--calculated__text text-right">Calculated at next step</td>
                            </tr>
                        </tbody>
                        <tfoot class="checkout__total--footer">
                            <tr class="checkout__total--footer__items">
                                <td class="checkout__total--footer__title checkout__total--footer__list text-left">Total </td>
                                <td class="checkout__total--footer__amount checkout__total--footer__list text-right">$860.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </aside>
        </div>
    </div>
</div>
<!-- End checkout page area -->

<!-- Scroll top bar -->
<button id="scroll__top"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M112 244l144-144 144 144M256 120v292" />
    </svg></button>


@endsection