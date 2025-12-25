@extends('theme.layouts.app')

@section('content')


<main class="main__content_wrapper">

    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title text-white mb-25">My Account</h1>
                        <ul class="breadcrumb__content--menu d-flex justify-content-center">
                            <li class="breadcrumb__content--menu__items"><a class="text-white" href="index.html">Home</a></li>
                            <li class="breadcrumb__content--menu__items"><span class="text-white">My Account</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- my account section start -->
    <section class="my__account--section section--padding">
        <div class="container">
            <p class="account__welcome--text">Hello, {{ auth()->user()->name }}
                welcome to your dashboard!</p>
            <div class="my__account--section__inner border-radius-10 d-flex">
                <div class="account__left--sidebar">
                    <h2 class="account__content--title h3 mb-20">My Profile</h2>
                    <ul class="account__menu">
                        <li class="account__menu--list active"><a href="{{route('user.account')}}">Dashboard</a></li>
                        <!-- <li class="account__menu--list"><a href="my-account-2.html">Addresses</a></li> -->
                        <li class="account__menu--list"><a href="{{ route('wishlist') }}">Wishlist</a></li>
                        <li class="account__menu--list"><a href="{{ route('logout') }}">Log Out</a></li>
                    </ul>
                </div>
                <div class="account__wrapper">
                    <div class="account__content">
                        <h2 class="account__content--title h3 mb-20">Orders History</h2>
                        <div class="account__table--area">
                            <table class="account__table">
                                <thead class="account__table--header">
                                    <tr class="account__table--header__child">
                                        <th class="account__table--header__child--items">Order</th>
                                        <th class="account__table--header__child--items">Date</th>
                                        <th class="account__table--header__child--items">Payment Status</th>
                                        <th class="account__table--header__child--items">Fulfillment Status</th>
                                        <th class="account__table--header__child--items">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="account__table--body mobile__none">
                                    @foreach($orders as $order)
                                    <tr class="account__table--body__child">
                                        <td class="account__table--body__child--items">#{{ $order->order_number }}</td>
                                        <td class="account__table--body__child--items">
                                            {{ $order->created_at->format('F d, Y') }}
                                        </td>
                                        <td class="account__table--body__child--items">
                                            {{ ucfirst($order->payment_status) }}
                                        </td>
                                        <td class="account__table--body__child--items">
                                            {{ ucfirst($order->order_status) }}
                                        </td>
                                        <td class="account__table--body__child--items">
                                            ${{ number_format($order->total_amount, 2) }} USD
                                        </td>
                                    </tr>
                                    @endforeach


                                </tbody>
                                <tbody class="account__table--body mobile__block">
                                     @foreach($orders as $order)
                                    <tr class="account__table--body__child">
                                        <td class="account__table--body__child--items">
                                            <strong>Order</strong>
                                            <span>#{{ $order->order_number }}</span>
                                        </td>
                                        <td class="account__table--body__child--items">
                                            <strong>Date</strong>
                                            <span>  {{ $order->created_at->format('F d, Y') }}</span>
                                        </td>
                                        <td class="account__table--body__child--items">
                                            <strong>Payment Status</strong>
                                            <span>{{ ucfirst($order->payment_status) }}</span>
                                        </td>
                                        <td class="account__table--body__child--items">
                                            <strong>Fulfillment Status</strong>
                                            <span> {{ ucfirst($order->order_status) }}</span>
                                        </td>
                                        <td class="account__table--body__child--items">
                                            <strong>Total</strong>
                                            <span>${{ number_format($order->total_amount, 2) }}  USD</span>
                                        </td>
                                    </tr>
                                         @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- my account section end -->

</main>

@endsection