@extends('Frontend.layouts.master')
@section('title')
    Cart
@endsection
@section('body-content')
    <section class="wpo-page-title">
        <h2 class="d-none">Hide</h2>
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="wpo-breadcumb-wrap">
                        <ol class="wpo-breadcumb-wrap">
                            <li><a href="{{ route('index') }}">Home</a></li>
                            <li><a href="">Product Page</a></li>
                            <li>Cart</li>
                        </ol>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->

    <!-- cart-area-s2 start -->
    <div class="cart-area-s2 section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="single-page-title">
                        <h2>Your Cart</h2>
                        <p>There are {{ count($cart) }} products in this list</p>
                    </div>
                </div>
            </div>
            <div class="cart-wrapper">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <form action="#">
                            <div class="cart-item">
                                <table class="table-responsive cart-wrap">
                                    <thead>
                                        <tr>
                                            <th class="images images-b">Product</th>
                                            <th class="ptice">Price</th>
                                            <th class="stock">Quantity</th>
                                            <th class="ptice total">Subtotal</th>
                                            <th class="remove remove-b">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $subtotal = 0;
                                        @endphp
                                        @forelse ($cart as $key => $value)
                                            @php
                                                $product = App\Models\Product::find($value['product_id']);

                                                $inventory = App\Models\Inventory::where('product_id', $product->id)
                                                    ->where('color_id', $value['color_id'])
                                                    ->where('size_id', $value['size_id'])
                                                    ->first();
                                            @endphp
                                            <tr class="wishlist-item">
                                                <td class="product-item-wish">
                                                    <div class="check-box"><input type="checkbox"
                                                            class="myproject-checkbox">
                                                    </div>
                                                    <div class="images">
                                                        <span>
                                                            <img src="{{ asset($product->product_image) }}" alt="">
                                                        </span>
                                                    </div>
                                                    <div class="product">
                                                        <ul>
                                                            <li class="first-cart">{{ $product->product_name }}</li>
                                                            @if($product->product_type == 1)
                                                            <li>Color: {{ $inventory->color->color_name }}</li>
                                                            <li>Size: {{ $inventory->size->size_name }}</li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </td>
                                                @if ($product->product_type == 1)
                                                    <td class="ptice">৳ {{ $price = $inventory->price }}</td>
                                                @else
                                                    <td class="ptice">৳ {{ $price = $product->new_price }}</td>
                                                @endif
                                                <td class="td-quantity">
                                                    <div class="quantity cart-plus-minus">
                                                        <input class="text-value" type="text"
                                                            value="{{ $value['quantity'] }}">
                                                        <div class="dec qtybutton">-</div>
                                                        <div class="inc qtybutton">+</div>
                                                    </div>
                                                </td>
                                                <td class="ptice">৳ {{ $price * $value['quantity'] }}</td>
                                                <td class="action">
                                                    <ul>
                                                        <li class="w-btn">
                                                            <a href="{{ route('cart.remove', $key) }}"
                                                                data-bs-toggle="tooltip" data-bs-html="true" title=""
                                                                class="border-0" data-bs-original-title="Remove from Cart"
                                                                aria-label="Remove from Cart"><i
                                                                    class="fi ti-trash"></i></a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            @php
                                                $subtotal += $price * $value['quantity'];
                                            @endphp
                                        @empty
                                            <tr>
                                                <td colspan="5">
                                                    <h4 class="mt-2 text-center text-danger">No Products Cart</h4>
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>

                                </table>
                            </div>
                            <div class="cart-action">
                                {{-- <div class="apply-area">
                                    <input type="text" class="form-control" placeholder="Enter your coupon">
                                    <button class="theme-btn-s2" type="submit">Apply</button>
                                </div> --}}
                                <a class="theme-btn-s2" href="#"><i class="fi flaticon-refresh"></i> Update Cart</a>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 col-12">
                        <form action="{{ route('cart') }}" method="GET">
                            <div class="mb-4 apply-area">
                                <input type="text" name="coupon_name" value="{{ $coupon }}" class="form-control"
                                    placeholder="Enter your coupon">
                                {{ session(['S_coupon' => $coupon]) }}
                                <button class="theme-btn-s2" type="submit">Apply</button>
                            </div>
                            @if ($messg)
                                <div class="alert alert-danger">{{ $messg }}</div>
                            @endif
                        </form>
                        @php
                            $discount = 0;
                            $total_amount = $subtotal;
                            if ($type == 1) {
                                $discount = round(($subtotal * $amount) / 100);
                                $total_amount = $subtotal - $discount;
                            } else {
                                $discount = $amount;
                                $total_amount = $subtotal - $discount;
                            }
                        @endphp
                        <div class="cart-total-wrap">
                            <h3>Cart Totals</h3>
                            <div class="sub-total">
                                <h4>Subtotal</h4>
                                <span>৳ {{ $subtotal }}</span>
                                {{ session(['S_sub_total' => $subtotal]) }}
                            </div>
                            <div class="my-3 sub-total">
                                <h4>Discount</h4>
                                <span>৳ {{ $discount }}</span>
                                {{ session(['S_discount' => $discount]) }}
                            </div>
                            <div class="mb-3 total">
                                <h4>Total</h4>
                                <span>৳ {{ $total_amount }}</span>
                                {{ session(['S_total' => $total_amount]) }}
                            </div>
                            <a class="theme-btn-s2" href="{{ route('customer.checkout') }}">Proceed To CheckOut</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cart-prodact">
                <h2>You May be Interested in…</h2>
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="product-item">
                            <div class="image">
                                <img src="{{ asset('public/Frontend') }}/images/interest-product/1.png" alt="">
                                <div class="tag new">New</div>
                            </div>
                            <div class="text">
                                <h2><a href="product-single.html">Wireless Headphones</a></h2>
                                <div class="rating-product">
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <span>130</span>
                                </div>
                                <div class="price">
                                    <span class="present-price">$120.00</span>
                                    <del class="old-price">$200.00</del>
                                </div>
                                <div class="shop-btn">
                                    <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="product-item">
                            <div class="image">
                                <img src="assets/images/interest-product/2.png" alt="">
                                <div class="tag sale">Sale</div>
                            </div>
                            <div class="text">
                                <h2><a href="product-single.html">Blue Bag with Lock</a></h2>
                                <div class="rating-product">
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <span>120</span>
                                </div>
                                <div class="price">
                                    <span class="present-price">$160.00</span>
                                    <del class="old-price">$190.00</del>
                                </div>
                                <div class="shop-btn">
                                    <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="product-item">
                            <div class="image">
                                <img src="assets/images/interest-product/3.png" alt="">
                                <div class="tag new">New</div>
                            </div>
                            <div class="text">
                                <h2><a href="product-single.html">Stylish Pink Top</a></h2>
                                <div class="rating-product">
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <span>150</span>
                                </div>
                                <div class="price">
                                    <span class="present-price">$150.00</span>
                                    <del class="old-price">$200.00</del>
                                </div>
                                <div class="shop-btn">
                                    <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="product-item">
                            <div class="image">
                                <img src="assets/images/interest-product/4.png" alt="">
                                <div class="tag sale">Sale</div>
                            </div>
                            <div class="text">
                                <h2><a href="product-single.html">Brown Com Boots</a></h2>
                                <div class="rating-product">
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <i class="fi flaticon-star"></i>
                                    <span>120</span>
                                </div>
                                <div class="price">
                                    <span class="present-price">$120.00</span>
                                    <del class="old-price">$150.00</del>
                                </div>
                                <div class="shop-btn">
                                    <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- cart-area end -->
@endsection
