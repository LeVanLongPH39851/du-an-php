<!--featured product area start-->
<section class="featured_product_area mb-70">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_title">
                    <h2>Sản Phẩm Nổi Bật</h2>
                </div>
            </div>
        </div>
        <div class="row featured_container featured_column3">
            @foreach ($sanPhamNoiBat as $key => $value)
            <div class="col-lg-4">
                <form action="{{route('client.addtocart', $value->id)}}" method="post">
                @csrf
                <article class="single_product">
                    <figure>
                        <div class="product_thumb pe-0">
                            <a class="primary_img" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden" href="{{route('client.show', $value->id)}}"><img
                                    src="{{'.'.Storage::url($value->anh_san_pham)}}" style="width: 100%;" alt=""></a>
                                @if($value->duong_dan_anh !== NULL)
                            <a class="secondary_img" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden" href="{{route('client.show', $value->id)}}"><img
                                    src="{{'.'.Storage::url($value->duong_dan_anh)}}" style="width: 100%" alt=""></a>
                                @endif
                                @if ($value->gia_khuyen_mai!=NULL)
                                <div class="label_product">
                                    <span class="label_sale">-{{round(($value->gia - $value->gia_khuyen_mai) / $value->gia * 100)}}%</span>
                                </div>
                                @endif
                        </div>
                        <figcaption class="product_content" style="padding-left: 15px; position: relative">
                                <div class="price_box">
                                    @if($value->gia_khuyen_mai !== NULL)
                                    <span class="old_price" style="font-size: 12px">{{number_format($value->gia, 0, '', '.')}}đ</span>
                                    <span class="current_price" style="font-size: 12px">{{number_format($value->gia_khuyen_mai, 0, '', '.')}}đ</span>
                                    @else
                                    <span class="current_price" style="font-size: 12px">{{$value->gia == NULL ? number_format($value->gia_min, 0, '', '.').'đ - '. number_format($value->gia_max, 0, '', '.') : number_format($value->gia, 0, '', '.')}}đ</span>
                                    @endif
                                </div>
                                <h3 class="product_name"><a style="font-size: 12px" href="{{route('client.show', $value->id)}}">{{$value->ten_san_pham}}</a></h3>
                                <div class="action_links" style="opacity: 1; visibility: visible; position: inherit; left: 0; top: 0">
                                    <ul class="d-flex mt-2">
                                        <li class="wishlist mb-0">
                                            @php
                                            $love = false;
                                            @endphp
        
                                            @foreach ($checkSanPhamYeuThichNoiBat as $valueYeuThich)
                                            @if ($valueYeuThich['id_san_pham'] == $value->id)
                                                <a href="javascript:void(0)" title="Yêu thích" style="width: 25px; height: 25px; line-height: 0px; display: flex; justify-content: center; align-items: center" class="me-1"><i class="fa fa-heart" style="font-size: 12px" aria-hidden="true"></i></a>
                                                @php
                                                    $love = true;
                                                @endphp
                                                @break
                                            @endif
                                            @endforeach
        
                                            @if (!$love)
                                            <a href="{{ route('client.favorite', $value->id) }}" title="Yêu thích" style="width: 25px; height: 25px; line-height: 0px; display: flex; justify-content: center; align-items: center" class="me-1"><i style="font-size: 12px" class="fa fa-heart-o" aria-hidden="true"></i></a>
                                            @endif
                                            </li>
                                        <li class="quick_button"><a href="#" style="width: 25px; height: 25px; display: flex; justify-content: center; align-items: center" data-bs-toggle="modal" data-bs-target="#modal_box_noi_bat_{{$value->id}}"
                                                title="Xem nhanh"> <span class="ion-ios-search-strong" style="font-size: 12px"></span></a></li>
                                    </ul>
                                </div>
                                @if ($value->gia_khuyen_mai != NULL && $value->ngay_ket_thuc_km != NULL)
                                    <div class="product_timing">
                                        @php
                                            $timestamp = strtotime($value->ngay_ket_thuc_km);
                                            $newTimestamp = strtotime('+1 day', $timestamp);
                                            $promotionEndDate = date('Y-m-d', $newTimestamp);
                                        @endphp
                                    <div data-countdown="{{$promotionEndDate}}"></div>
                                    </div>
                                @endif
                                <div class="add_to_cart">
                                    @if($value->kieu_san_pham == 1)
                                    @if ($value->so_luong > 0)
                                    <button type="submit" title="Thêm giỏ hàng" style="border: none; width: 100%;">Thêm Giỏ Hàng</button>
                                    @else
                                    <button disabled title="Hết hàng" style="border: none; width: 100%; cursor: not-allowed">Hết Hàng</button>
                                    @endif
                                    @else
                                    @if ($value->sum_so_luong > 0)
                                    <a href="{{route('client.show', $value->id)}}" title="Xem tùy chọn">Xem Tùy Chọn</a>
                                    @else
                                    <button disabled title="Hết hàng" style="border: none; width: 100%; cursor: not-allowed">Hết Hàng</button>
                                    @endif
                                    @endif
                                </div>
                        </figcaption>
                    </figure>
                </article>
                </form>
            </div>
            @endforeach
            {{-- <div class="col-lg-4">
                <article class="single_product">
                    <figure>
                        <div class="product_thumb">
                            <a class="primary_img" href="product-details.html"><img
                                    src="assets/img/product/product15.jpg" alt=""></a>
                            <a class="secondary_img" href="product-details.html"><img
                                    src="assets/img/product/product16.jpg" alt=""></a>
                        </div>
                        <figcaption class="product_content">
                            <div class="price_box">
                                <span class="old_price">$86.00</span>
                                <span class="current_price">$79.00</span>
                            </div>
                            <h3 class="product_name"><a href="product-details.html">Auctor gravida enim pellentesque
                                    quam</a></h3>
                            <div class="add_to_cart">
                                <a href="cart.html" title="add to cart">Add to cart</a>
                            </div>
                        </figcaption>
                    </figure>
                </article>
            </div>
            <div class="col-lg-4">
                <article class="single_product">
                    <figure>
                        <div class="product_thumb">
                            <a class="primary_img" href="product-details.html"><img
                                    src="assets/img/product/product17.jpg" alt=""></a>
                            <a class="secondary_img" href="product-details.html"><img
                                    src="assets/img/product/product18.jpg" alt=""></a>
                            <div class="label_product">
                                <span class="label_sale">sale</span>
                            </div>
                        </div>
                        <figcaption class="product_content">
                            <div class="price_box">
                                <span class="old_price">$86.00</span>
                                <span class="current_price">$79.00</span>
                            </div>
                            <h3 class="product_name"><a href="product-details.html">Kaoreet lobortis sagittis
                                    pellentesque</a></h3>
                            <div class="add_to_cart">
                                <a href="cart.html" title="add to cart">Add to cart</a>
                            </div>
                        </figcaption>
                    </figure>
                </article>
            </div>
            <div class="col-lg-4">
                <article class="single_product">
                    <figure>
                        <div class="product_thumb">
                            <a class="primary_img" href="product-details.html"><img
                                    src="assets/img/product/product19.jpg" alt=""></a>
                            <a class="secondary_img" href="product-details.html"><img
                                    src="assets/img/product/product20.jpg" alt=""></a>
                            <div class="label_product">
                                <span class="label_sale">sale</span>
                            </div>
                        </div>
                        <figcaption class="product_content">
                            <div class="price_box">
                                <span class="old_price">$86.00</span>
                                <span class="current_price">$79.00</span>
                            </div>
                            <h3 class="product_name"><a href="product-details.html">Cras neque honcus consectetur
                                    magna</a></h3>
                            <div class="add_to_cart">
                                <a href="cart.html" title="add to cart">Add to cart</a>
                            </div>
                        </figcaption>
                    </figure>
                </article>
            </div>
            <div class="col-lg-4">
                <article class="single_product">
                    <figure>
                        <div class="product_thumb">
                            <a class="primary_img" href="product-details.html"><img
                                    src="assets/img/product/product21.jpg" alt=""></a>
                            <a class="secondary_img" href="product-details.html"><img
                                    src="assets/img/product/product22.jpg" alt=""></a>
                        </div>
                        <figcaption class="product_content">
                            <div class="price_box">
                                <span class="current_price">$79.00</span>
                            </div>
                            <h3 class="product_name"><a href="product-details.html">Duis pulvinar obortis eleifend
                                    elementum</a></h3>
                            <div class="add_to_cart">
                                <a href="cart.html" title="add to cart">Add to cart</a>
                            </div>
                        </figcaption>
                    </figure>
                </article>
            </div>
            <div class="col-lg-4">
                <article class="single_product">
                    <figure>
                        <div class="product_thumb">
                            <a class="primary_img" href="product-details.html"><img
                                    src="assets/img/product/product23.jpg" alt=""></a>
                            <a class="secondary_img" href="product-details.html"><img
                                    src="assets/img/product/product24.jpg" alt=""></a>
                        </div>
                        <figcaption class="product_content">
                            <div class="price_box">
                                <span class="old_price">$86.00</span>
                                <span class="current_price">$79.00</span>
                            </div>
                            <h3 class="product_name"><a href="product-details.html">Fusce ultricies dolor vitae
                                    tristique suscipit</a></h3>
                            <div class="add_to_cart">
                                <a href="cart.html" title="add to cart">Add to cart</a>
                            </div>
                        </figcaption>
                    </figure>
                </article>
            </div>
            <div class="col-lg-4">
                <article class="single_product">
                    <figure>
                        <div class="product_thumb">
                            <a class="primary_img" href="product-details.html"><img
                                    src="assets/img/product/product15.jpg" alt=""></a>
                            <a class="secondary_img" href="product-details.html"><img
                                    src="assets/img/product/product16.jpg" alt=""></a>
                        </div>
                        <figcaption class="product_content">
                            <div class="price_box">
                                <span class="old_price">$86.00</span>
                                <span class="current_price">$79.00</span>
                            </div>
                            <h3 class="product_name"><a href="product-details.html">Natus erro at congue massa
                                    commodo sit</a></h3>
                            <div class="add_to_cart">
                                <a href="cart.html" title="add to cart">Add to cart</a>
                            </div>
                        </figcaption>
                    </figure>
                </article>
            </div>
            <div class="col-lg-4">
                <article class="single_product">
                    <figure>
                        <div class="product_thumb">
                            <a class="primary_img" href="product-details.html"><img
                                    src="assets/img/product/product17.jpg" alt=""></a>
                            <a class="secondary_img" href="product-details.html"><img
                                    src="assets/img/product/product18.jpg" alt=""></a>
                            <div class="label_product">
                                <span class="label_sale">sale</span>
                            </div>
                        </div>
                        <figcaption class="product_content">
                            <div class="price_box">
                                <span class="old_price">$86.00</span>
                                <span class="current_price">$79.00</span>
                            </div>
                            <h3 class="product_name"><a href="product-details.html">Cras neque honcus consectetur
                                    magna</a></h3>
                            <div class="add_to_cart">
                                <a href="cart.html" title="add to cart">Add to cart</a>
                            </div>
                        </figcaption>
                    </figure>
                </article>
            </div> --}}
        </div>
    </div>
</section>
<!--featured product area end-->