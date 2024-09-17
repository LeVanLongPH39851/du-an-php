<!--header area start-->

    <!--Offcanvas menu area start-->
    <div class="off_canvars_overlay">

    </div>
    <div class="Offcanvas_menu">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="canvas_open">
                        <a href="javascript:void(0)"><i class="ion-navicon"></i></a>
                    </div>
                    <div class="Offcanvas_menu_wrapper">
                        <div class="canvas_close">
                            <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                        </div>
                        <div class="support_info">
                            <p>Số Điện Thoại: <a href="tel:0388205794">0388205794</a></p>
                        </div>
                        <div class="top_right text-end">
                            <ul>
                                @if (Auth::check())
                                    <div style="display: flex; justify-content: center">
                                        <a href="{{route('client.info.user')}}" style="display: flex; align-items: center">
                                            <div>
                                                <img style="width: 30px; aspect-ratio: 1/1; object-fit: cover; border-radius: 50%"
                                            src="{{Auth::user()->anh_dai_dien === NULL ? "./storage/uploads/khachhang/avatar.png" : ".".Storage::url(Auth::user()->anh_dai_dien)}}" alt="">
                                            </div>
                                            <p style="font-size: 12px; margin-bottom: 0; margin-left: 5px">{{Auth::user()->name}}</p>
                                        </a>
                                    </div>
                                    @else
                                <li><a href="{{route('client.form.login')}}"> Đăng Ký </a></li>
                                <li><a href="{{route('client.form.signin')}}"> Đăng Nhập </a></li>
                                @endif
                            </ul>
                        </div>
                        <div class="search_container">
                            <form action="{{route('client.shop')}}" method="get" id="myFormHeaderMobile">
                                <div class="hover_category">
                                    <select class="select_option" name="category" onchange="submitFormHeaderMobile()">
                                        <option value="0">Danh Mục</option>
                                        @php
                                        function printCategoryRowAltMobile($danhMuc, $level = 0, $category) {
                                            echo '<option '.((isset($category) && $category == $danhMuc->id) ? "selected" : "").' value="'.$danhMuc->id.'">'.str_repeat('--', $level).' '.$danhMuc->ten_danh_muc.'</option>';
                                            if ($danhMuc->children->count() > 0) {
                                                foreach ($danhMuc->children as $child) {
                                                    printCategoryRowAltMobile($child, $level + 1, $category);
                                                }
                                            }
                                        }
                                        @endphp
                                        @if (isset($category))
                                        @php
                                            $categoryIsset = $category;
                                        @endphp
                                        @else
                                        @php
                                            $categoryIsset = NULL;
                                        @endphp
                                        @endif
                                        @foreach ($listDanhMuc as $danhMuc)
                                        @if ($danhMuc->danh_muc_cha_id == null) <!-- Chỉ hiển thị danh mục cha -->
                                            @php printCategoryRowAltMobile($danhMuc, 0, $categoryIsset); @endphp
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="search_box">
                                    <input placeholder="Tên sản phẩm..." type="text">
                                    <button type="submit">Tìm Kiếm</button>
                                </div>
                            </form>
                            <script>
                              function submitFormHeaderMobile() {
                                    document.getElementById('myFormHeaderMobile').submit();
                                    }
                            </script>
                        </div>

                        <div class="middel_right_info">
                            <div class="header_wishlist">
                                <a href="{{route('client.wishlist')}}"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                <span class="wishlist_quantity">{{$countSanPhamYeuThich}}</span>
                            </div>
                            <?php 
                                $tongTien = 0;
                                foreach ($listCart as $key => $value) {
                                    $tongTien += $value->gia * $value->so_luong;
                                }
                            ?>
                            <div class="mini_cart_wrapper">
                                <a href="javascript:void(0)" style="font-size: 12px; text-transform: none"><i class="fa fa-shopping-bag"
                                        aria-hidden="true"></i>{{number_format($tongTien, 0, '', '.')}}{{$tongTien==0 ? ' vnđ' : 'đ'}} <i class="fa fa-angle-down"></i></a>
                                <span class="cart_quantity">{{count($listCart)}}</span>
                                <!--mini cart-->
                                <div class="mini_cart">
                                    @forelse ($listCart as $key => $value)
                                    <div class="cart_item align-items-center">
                                        <div class="cart_img me-1" style="width: 50px">
                                            <a href="{{route('client.show', $value->id)}}" class="d-flex align-items-center" style="aspect-ratio: 1/1; overflow: hidden"><div><img src="{{'.'.Storage::url($value->anh_san_pham)}}" alt=""></div></a>
                                        </div>
                                        <div class="cart_info">
                                            <a href="{{route('client.show', $value->id)}}" class="mb-1" style="font-size: 12px">{{$value->ten_san_pham}}</a>
                                            <p style="font-size: 11px">{{$value->so_luong}} X <span> {{number_format($value->gia, 0, '', '.')}} VNĐ </span></p>
                                        </div>
                                        <div class="cart_remove">
                                            <a href="{{route('client.remove.cart', $value->id_ctgh)}}"><i class="ion-android-close"></i></a>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center">Chưa có sản phẩm nào</div>
                                    @endforelse
                                    @if (Auth::id() && count($listCart) > 0)
                                    <div class="mini_cart_table">
                                        <div class="cart_total">
                                            <span>Tổng tiền:</span>
                                            <span class="price" style="font-size: 12px">{{number_format($tongTien, 0, '', '.')}} VNĐ</span>
                                        </div>
                                        <div class="cart_total mt-10">
                                            <span>Tổng cộng:</span>
                                            <span class="price text-primary" style="font-size: 12px">{{number_format($tongTien, 0, '', '.')}} VNĐ</span>
                                        </div>
                                    </div>

                                    <div class="mini_cart_footer">
                                        <div class="cart_button">
                                            <a href="{{route('client.cart')}}">Xem giỏ hàng</a>
                                        </div>
                                        <div class="cart_button">
                                            <a href="{{route('client.checkout')}}">Thanh toán</a>
                                        </div>

                                    </div>
                                    @endif

                                </div>
                                <!--mini cart end-->
                            </div>
                        </div>
                        <div id="menu" class="text-start ">
                            <ul class="offcanvas_main_menu">
                                <li class="menu-item-has-children {{ request()->routeIs('client.index') ? 'active' : '' }}">
                                    <a href="{{route('client.index')}}">Trang Chủ</a>
                                </li>
                                <li class="menu-item-has-children {{ request()->routeIs('client.shop') ? 'active' : '' }}">
                                    <a href="{{route('client.shop')}}">Cửa Hàng</a>
                                </li>
                                <li class="menu-item-has-children {{ request()->routeIs('client.blog') ? 'active' : '' }}">
                                    <a href="{{route("client.blog")}}">Bài Viết</a>
                                </li>
                                <li class="menu-item-has-children {{ request()->routeIs('client.about') ? 'active' : '' }}">
                                    <a href="{{route('client.about')}}">Về Chúng Tôi</a>
                                </li>
                                <li class="menu-item-has-children {{ request()->routeIs('client.contact') ? 'active' : '' }}">
                                    <a href="{{route('client.contact')}}">Liên Hệ</a>
                                </li>
                            </ul>
                        </div>

                        <div class="Offcanvas_footer">
                            <span><a href="#"><i class="fa fa-envelope-o"></i> le7929590@gmail.com</a></span>
                            <ul>
                                <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li class="pinterest"><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Offcanvas menu area end-->

    <header>
        <div class="main_header">
            <!--header top start-->
            <div class="header_top">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6">
                            <div class="support_info">
                                <p>Số Điện Thoại: <a href="tel:0388205794">0388205794</a></p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="top_right text-end">
                                <ul>
                                    @if (Auth::check())
                                    <div style="display: flex; justify-content: end">
                                        <a href="{{route('client.info.user')}}" style="display: flex; align-items: center">
                                            <div>
                                                <img style="width: 30px; aspect-ratio: 1/1; object-fit: cover; border-radius: 50%"
                                            src="{{Auth::user()->anh_dai_dien === NULL ? "./storage/uploads/khachhang/avatar.png" : ".".Storage::url(Auth::user()->anh_dai_dien)}}" alt="">
                                            </div>
                                            <p style="font-size: 12px; margin-bottom: 0; margin-left: 5px">{{Auth::user()->name}}</p>
                                        </a>
                                    </div>
                                    @else
                                    <li><a href="{{route('client.form.signin')}}"> Đăng Ký </a></li>
                                    <li><a href="{{route('client.form.login')}}"> Đăng Nhập </a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--header top start-->
            <!--header middel start-->
            <div class="header_middle">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-6">
                            <div class="logo">
                                <a href="{{route('client.index')}}"><img src="assets/img/logo/logo-lelong.png" alt=""></a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-6">
                            <div class="middel_right">
                                <div class="search_container">
                                    <form action="{{route('client.shop')}}" method="get" id="myFormHeader">
                                        <div class="hover_category" style="z-index: 100">
                                            <select class="select_option" name="category" onchange="submitFormHeader()">
                                                <option value="0">Danh Mục</option>
                                                @php
                                                function printCategoryRowAlt($danhMuc, $level = 0, $category) {
                                                    echo '<option '.((isset($category) && $category == $danhMuc->id) ? "selected" : "").' value="'.$danhMuc->id.'">'.str_repeat('--', $level).' '.$danhMuc->ten_danh_muc.'</option>';
                                                    if ($danhMuc->children->count() > 0) {
                                                        foreach ($danhMuc->children as $child) {
                                                            printCategoryRowAlt($child, $level + 1, $category);
                                                        }
                                                    }
                                                }
                                                @endphp
                                                @if (isset($category))
                                                @php
                                                    $categoryIsset = $category;
                                                @endphp
                                                @else
                                                @php
                                                    $categoryIsset = NULL;
                                                @endphp
                                                @endif
                                                @foreach ($listDanhMuc as $danhMuc)
                                                @if ($danhMuc->danh_muc_cha_id == null) <!-- Chỉ hiển thị danh mục cha -->
                                                    @php printCategoryRowAlt($danhMuc, 0, $categoryIsset); @endphp
                                                @endif
                                                @endforeach
                                                {{-- @foreach ($listDanhMuc as $key => $value)
                                                <option {{isset($category) && $category == $value->id ? "selected" : ''}} value="{{$value->id}}">{{$value->ten_danh_muc}}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <div class="search_box">
                                            <input placeholder="Tên sản phẩm..." value="{{isset($search) ? $search : ''}}" type="text" name="search">
                                            <button type="submit">Tìm Kiếm</button>
                                        </div>
                                    </form>
                                    <script>
                                        function submitFormHeader() {
                                              document.getElementById('myFormHeader').submit();
                                              }
                                      </script>
                                </div>
                                <div class="middel_right_info">
                                    <div class="header_wishlist">
                                        <a href="{{route('client.wishlist')}}"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                        <span class="wishlist_quantity">{{$countSanPhamYeuThich}}</span>
                                    </div>
                                    <?php 
                                        $tongTien = 0;
                                        foreach ($listCart as $key => $value) {
                                            $tongTien += $value->gia * $value->so_luong;
                                        }
                                    ?>
                                    <div class="mini_cart_wrapper">
                                        <a href="javascript:void(0)" style="font-size: 12px;"><i class="fa fa-shopping-bag text-nowrap"
                                                aria-hidden="true"></i>{{number_format($tongTien, 0, '', '.')}} VNĐ <i class="fa fa-angle-down"></i></a>
                                        <span class="cart_quantity">{{count($listCart)}}</span>
                                        <!--mini cart-->
                                        <div class="mini_cart">
                                            @forelse ($listCart as $key => $value)
                                            <div class="cart_item align-items-center">
                                                <div class="cart_img me-1" style="width: 70px">
                                                    <a href="{{route('client.show', $value->id)}}" class="d-flex align-items-center" style="aspect-ratio: 1/1; overflow: hidden"><div><img src="{{'.'.Storage::url($value->anh_san_pham)}}" alt=""></div></a>
                                                </div>
                                                <div class="cart_info">
                                                    <a href="{{route('client.show', $value->id)}}">{{$value->ten_san_pham}}{{($value->ten_gia_tri_thuoc_tinh_bt!==NULL) ? ' ('.$value->ten_gia_tri_thuoc_tinh_bt.')' : "" }}</a>
                                                    <p>{{$value->so_luong}} X <span> {{number_format($value->gia, 0, '', '.')}} VNĐ </span></p>
                                                </div>
                                                <div class="cart_remove">
                                                    <a href="{{route('client.remove.cart', $value->id_ctgh)}}"><i class="ion-android-close"></i></a>
                                                </div>
                                            </div>
                                            @empty
                                            <div class="text-center">Bạn chưa có sản phẩm nào trong giỏ hàng</div>
                                            @endforelse
                                            @if (Auth::id() && count($listCart) > 0)
                                            <div class="mini_cart_table">
                                                <div class="cart_total">
                                                    <span>Tổng tiền:</span>
                                                    <span class="price">{{number_format($tongTien, 0, '', '.')}} VNĐ</span>
                                                </div>
                                                <div class="cart_total mt-10">
                                                    <span>Tổng cộng:</span>
                                                    <span class="text-primary price">{{number_format($tongTien, 0, '', '.')}} VNĐ</span>
                                                </div>
                                            </div>

                                            <div class="mini_cart_footer">
                                                <div class="cart_button">
                                                    <a href="{{route('client.cart')}}">Xem Giỏ Hàng</a>
                                                </div>
                                                <div class="cart_button">
                                                    <a href="{{route('client.checkout')}}">Thanh Toán</a>
                                                </div>

                                            </div>
                                            @endif
                                        </div>
                                        <!--mini cart end-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--header middel end-->
            <!--header bottom satrt-->
            <div class="main_menu_area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-12">
                            <div class="categories_menu">
                                <div class="categories_title">
                                    <h2 class="categori_toggle">DANH MỤC</h2>
                                </div>
                                <div class="categories_menu_toggle">
                                    <ul>
                                        @php
                                        function printCategoryRow($danhMuc, $level = 0) {
                                            $imageSize = 30 - ($level * 5);
                                            $textSize = 14 - ($level * 1);
                                            if ($imageSize < 15) {
                                                $imageSize = 15;
                                            }
                                            echo '<li><a style="font-size: '.$textSize.'px" href="'.route('client.shop').'?category='.$danhMuc->id.'">'.str_repeat('--', $level).' <img class="me-2" src=".'.Storage::url($danhMuc->anh_danh_muc).'" style="width: '.$imageSize.'px; aspect-ratio: 1/1; object-fit: cover" alt="">'.$danhMuc->ten_danh_muc.'</a></li>';
                                            if ($danhMuc->children->count() > 0) {
                                                foreach ($danhMuc->children as $child) {
                                                    printCategoryRow($child, $level + 1);
                                                }
                                            }
                                        }
                                        @endphp
                                        @foreach ($listDanhMuc as $danhMuc)
                                        @if ($danhMuc->danh_muc_cha_id == null)
                                            @php printCategoryRow($danhMuc); @endphp
                                        @endif
                                        @endforeach
                                        {{-- @foreach ($listDanhMuc as $key => $value)
                                               <li><a href="{{route('client.shop').'?category='.$value->id}}">--<img class="me-2" src="{{".".Storage::url($value->anh_danh_muc)}}" style="width: 30px; aspect-ratio: 1/1; object-fit: cover" alt="">{{$value->ten_danh_muc}}</a></li>
                                                @endforeach --}}
                                            {{-- <li class="menu_item_children"><a href="#">Turbo System <i
                                                    class="fa fa-angle-right"></i></a>
                                            <ul class="categories_mega_menu column_2">
                                                <li class="menu_item_children"><a href="#">Check Trousers</a>
                                                    <ul class="categorie_sub_menu">
                                                        <li><a href="#">Building</a></li>
                                                        <li><a href="#">Electronics</a></li>
                                                        <li><a href="#">action figures </a></li>
                                                        <li><a href="#">specialty & boutique toy</a></li>
                                                    </ul>
                                                </li>
                                                <li class="menu_item_children"><a href="#">Calculators</a>
                                                    <ul class="categorie_sub_menu">
                                                        <li><a href="#">Dolls for Girls</a></li>
                                                        <li><a href="#">Girls' Learning Toys</a></li>
                                                        <li><a href="#">Arts and Crafts for Girls</a></li>
                                                        <li><a href="#">Video Games for Girls</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                            </li> --}}
                                        {{-- <li id="cat_toggle" class="has-sub"><a href="#"> More Categories</a>
                                            <ul class="categorie_sub">
                                                <li><a href="#">Hide Categories</a></li>
                                            </ul>

                                        </li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-12">
                            <div class="main_menu menu_position">
                                <nav>
                                    <ul>
                                        <li><a class="{{ request()->routeIs('client.index') ? 'active' : '' }}" href="{{route('client.index')}}">Trang Chủ</a>
                                        </li>
                                        <li><a class="{{ request()->routeIs('client.shop') ? 'active' : '' }}" href="{{route('client.shop')}}">Cửa Hàng</a>
                                        </li>
                                        <li><a class="{{ request()->routeIs('client.blog') ? 'active' : '' }}" href="{{route('client.blog')}}">Bài Viết</a>
                                        </li>
                                        <li><a class="{{ request()->routeIs('client.about') ? 'active' : '' }}" href="{{route('client.about')}}">Về Chúng Tôi</a></li>
                                        <li><a class="{{ request()->routeIs('client.contact') ? 'active' : '' }}" href="{{route('client.contact')}}">Liên Hệ</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--header bottom end-->
        </div>
    </header>
    <!--header area end-->