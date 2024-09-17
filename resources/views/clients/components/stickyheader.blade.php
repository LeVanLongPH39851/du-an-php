<!--sticky header area start-->
<div class="sticky_header_area sticky-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3">
                <div class="logo">
                    <a href="{{route('client.index')}}"><img src="assets/img/logo/logo-lelong.png" alt=""></a>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="sticky_header_right menu_position">
                    <div class="main_menu">
                        <nav>
                            <ul>
                                <li><a class="{{ request()->routeIs('client.index') ? 'active' : '' }}" href="{{route('client.index')}}">Trang Chủ</a>
                                </li>
                                <li><a class="{{ request()->routeIs('client.shop') ? 'active' : '' }}" href="{{route('client.shop')}}">Cửa Hàng</a>
                                </li>
                                <li><a class="{{ request()->routeIs('client.blog') ? 'active' : '' }}" href="{{route('client.blog')}}">Bài Viết</a>
                                </li>
                                <li><a class="{{ request()->routeIs('client.about') ? 'active' : '' }}" href="{{route('client.about')}}">Về Chúng Tôi</a>
                                </li>
                                <li><a class="{{ request()->routeIs('client.contact') ? 'active' : '' }}" href="{{route('client.contact')}}">Liên Hệ</a></li>
                            </ul>
                        </nav>
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
                                        <a href="{{route('client.show', $value->id)}}"><img src="{{'.'.Storage::url($value->anh_san_pham)}}" alt=""></a>
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
                                        <span>Tổng Tiền:</span>
                                        <span class="price">{{number_format($tongTien, 0, '', '.')}} VNĐ</span>
                                    </div>
                                    <div class="cart_total mt-10">
                                        <span>Tổng Cộng:</span>
                                        <span class="text-primary price">{{number_format($tongTien, 0, '', '.')}} VNĐ</span>
                                    </div>
                                </div>

                                <div class="mini_cart_footer">
                                    <div class="cart_button">
                                        <a href="{{route('client.cart')}}">Xem Giỏ Hàng</a>
                                    </div>
                                    <div class="cart_button">
                                        <a href="checkout.html">Thanh Toán</a>
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
<!--sticky header area end-->