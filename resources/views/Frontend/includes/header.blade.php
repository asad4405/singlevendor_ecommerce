@php
    $cart = session()->get('cart', []);
@endphp
<header id="header">
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="contact-intro">
                        <span>{{ $generalsetting->description }}</span>
                    </div>
                </div>
                <div class="col col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="contact-info">
                        <ul>
                            <li><a href="tel:{{ $contact->phone }}"><span>Need help? Call Us:
                                    </span>+88{{ $contact->phone }}</a></li>
                            <li>
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        English
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="#">English</a></li>
                                        <li><a class="dropdown-item" href="#">Bangla</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end topbar -->
    <!--  start header-middle -->
    <div class="header-middle">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="{{ route('index') }}"><img
                                src="{{ asset($generalsetting->dark_logo) }}" alt="logo" width="85"></a>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <form action="#" class="middle-box">
                        <div class="category">
                            <select name="service" class="form-control">
                                <option disabled="disabled" selected="">All Category</option>
                                @foreach ($categories as $value)
                                    <option>{{ $value->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="search-box">
                            <div class="input-group">
                                <input type="search" class="form-control" placeholder="Search Product ...">
                                <button class="search-btn" type="submit"> <i class="fi flaticon-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="middle-right">
                        <ul>
                            <li><a href="compare.html"><i
                                        class="fi flaticon-right-and-left"></i><span>Compare</span></a>
                            </li>
                            @auth('customer')
                                <li><a href="{{ route('customer.profile') }}"><i
                                            class="fi flaticon-user-profile"></i><span>Profile</span></a></li>
                            @else
                                <li><a href="{{ route('customer.login') }}"><i
                                            class="fi flaticon-user-profile"></i><span>Login</span></a></li>
                            @endauth
                            <li>
                                <div class="header-wishlist-form-wrapper">
                                    <button class="wishlist-toggle-btn"> <i class="fi flaticon-heart"></i>
                                        <span class="cart-count">3</span></button>
                                    <div class="mini-wislist-content">
                                        <button class="mini-cart-close"><i class="ti-close"></i></button>
                                        <div class="mini-cart-items">
                                            <div class="clearfix mini-cart-item">
                                                <div class="mini-cart-item-image">
                                                    <a href="product.html"><img
                                                            src="{{ asset('public/Frontend') }}/images/cart/img-1.jpg"
                                                            alt></a>
                                                </div>
                                                <div class="mini-cart-item-des">
                                                    <a href="product.html">Stylish Pink Coat</a>
                                                    <span class="mini-cart-item-price">$150</span>
                                                    <span class="mini-cart-item-quantity"><a href="#"><i
                                                                class="ti-close"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="clearfix mini-cart-item">
                                                <div class="mini-cart-item-image">
                                                    <a href="product.html"><img
                                                            src="{{ asset('public/Frontend') }}/images/cart/img-2.jpg"
                                                            alt></a>
                                                </div>
                                                <div class="mini-cart-item-des">
                                                    <a href="product.html">Blue Bag</a>
                                                    <span class="mini-cart-item-price">$120</span>
                                                    <span class="mini-cart-item-quantity"><a href="#"><i
                                                                class="ti-close"></i></a></span>
                                                </div>
                                            </div>
                                            <div class="clearfix mini-cart-item">
                                                <div class="mini-cart-item-image">
                                                    <a href="product.html"><img
                                                            src="{{ asset('public/Frontend') }}/images/cart/img-3.jpg"
                                                            alt></a>
                                                </div>
                                                <div class="mini-cart-item-des">
                                                    <a href="product.html">Kids Blue Shoes</a>
                                                    <span class="mini-cart-item-price">$120</span>
                                                    <span class="mini-cart-item-quantity"><a href="#"><i
                                                                class="ti-close"></i></a></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix mini-cart-action">
                                            <div class="mini-btn">
                                                <a href="wishlist.html" class="view-cart-btn">View Wishlist</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="mini-cart">
                                    <button class="cart-toggle-btn"> <i class="fi flaticon-add-to-cart"></i>
                                        <span class="cart-count">{{ count($cart) }}</span></button>
                                    <div class="mini-cart-content">
                                        <button class="mini-cart-close"><i class="ti-close"></i></button>
                                        <div class="mini-cart-items">
                                            @php
                                                $subtotal = 0;
                                            @endphp
                                            @foreach ($cart as $key => $value)
                                                    @php
                                                        $product = App\Models\Product::find($value['product_id']);

                                                        $inventory = App\Models\Inventory::where('product_id', $product->id)
                                                            ->where('color_id', $value['color_id'])
                                                            ->where('size_id', $value['size_id'])
                                                            ->first();
                                                    @endphp
                                                    <div class="clearfix mini-cart-item">
                                                            <div class=" mini-cart-item-image">
                                                        <a href="{{ route('product.details', $product->slug) }}"><img
                                                                src="{{ asset($product->product_image) }}" alt></a>
                                                    </div>
                                                    <div class="mini-cart-item-des">
                                                        <a
                                                            href="{{ route('product.details', $product->slug) }}">{{ $product->product_name }}</a>
                                                        <span class="mini-cart-item-price">
                                                            @if ($product->product_type == 1)
                                                                ৳{{ $price = $inventory->price }}
                                                            @else
                                                                ৳{{ $price = $product->new_price }}
                                                            @endif x {{ $value['quantity'] }}
                                                        </span>
                                                        @if($product->product_type == 1)
                                                            <span class="mini-cart-item-price">Color:
                                                                {{ $inventory->color->color_name }} Size:
                                                                {{ $inventory->size->size_name }}</span>
                                                        @endif
                                                        <span class="mini-cart-item-quantity"><a
                                                                href="{{ route('cart.remove', $key) }}"><i
                                                                    class="ti-close"></i></a></span>
                                                    </div>
                                                </div>
                                                @php
                                                    $subtotal += $price * $value['quantity'];
                                                @endphp
                                            @endforeach
                                    </div>
                                    <div class="clearfix mini-cart-action">
                                        <span class="mini-checkout-price">Subtotal:
                                            <span>৳ {{ $subtotal }}</span></span>
                                        <div class="mini-btn">
                                            <a href="{{ route('cart') }}" class="view-cart-btn">View Cart</a>
                                        </div>
                                    </div>
                                </div>
                    </div>
                    </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!--  end header-middle -->
    <div class="wpo-site-header">
        <nav class="navigation navbar navbar-expand-lg navbar-light">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-3 d-lg-none dl-block">
                        <div class="mobail-menu">
                            <button type="button" class="navbar-toggler open-btn">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar first-angle"></span>
                                <span class="icon-bar middle-angle"></span>
                                <span class="icon-bar last-angle"></span>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-6 col-sm-5 col-6 d-block d-lg-none">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="{{ route('index') }}"><img
                                    src="{{ asset($generalsetting->dark_logo) }}" alt="logo" width="85"></a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-3">
                        <div class="header-shop-item">
                            <button class="header-shop-toggle-btn"><span>Shop By Category</span> </button>
                            <div class="mini-shop-item">
                                <ul id="metis-menu">
                                    @foreach ($categories as $value)
                                        @php
                                            $subcategory = App\Models\Subcategory::where('category_id', $value->id)
                                                ->where('status', 1)
                                                ->first();
                                        @endphp
                                        <li class="header-catagory-item">
                                            <a @if ($subcategory) class="menu-down-arrow" @endif
                                                href="{{ route('category.product', $value->slug) }}">{{ $value->category_name }}</a>
                                            <ul class="header-catagory-single">
                                                @foreach ($value->subcategories as $subvalue)
                                                    <li><a
                                                            href="{{ route('subcategory.product', $subvalue->slug) }}">{{ $subvalue->subcategory_name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-1 col-1">
                        <div id="navbar" class="collapse navbar-collapse navigation-holder">
                            <button class="menu-close"><i class="ti-close"></i></button>
                            <ul class="mb-2 nav navbar-nav mb-lg-0">
                                <li class="d-lg-none"><a style="font-size: 10px"
                                        href="{{ route('index') }}">{{ $generalsetting->description }}</a></li>
                                <li class="menu-item-has-children">
                                    <a href="{{ route('index') }}">Home</a>
                                </li>
                                <li><a href="about.html">About</a></li>
                                <li class="menu-item-has-children">
                                    <a href="{{ route('shop') }}">Shop</a>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="#">FAQ</a>
                                </li>
                                <li><a href="{{ route('contact') }}">Contact</a></li>
                            </ul>

                        </div><!-- end of nav-collapse -->
                    </div>
                    <div class="col-lg-2 col-md-1 col-1">
                        <div class="header-right">
                            <a href="recent-view.html" class="recent-btn"><i class="fi flaticon-refresh"></i>
                                <span>Recently Viewed</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- end of container -->
        </nav>
    </div>
</header>
