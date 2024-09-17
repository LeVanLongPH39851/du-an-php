<!--product area start-->
<section class="product_area mb-46">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_title">
                    <h2>Sản Phẩm Khuyến Mãi</h2>
                </div>
            </div>
        </div>
        <div class="product_carousel product_column5 owl-carousel">
            @foreach ($sanPhamKhuyenMai as $key => $value)
            <form action="{{route('client.addtocart', $value->id)}}" method="post">
            @csrf
            <article class="single_product">
                <figure>
                    <div class="product_thumb">
                        <a class="primary_img" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden" href="{{route('client.show', $value->id)}}"><img
                            src="{{'.'.Storage::url($value->anh_san_pham)}}" style="width: 100%" alt=""></a>
                            @if($value->duong_dan_anh !== NULL)
                        <a class="secondary_img" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden" href="{{route('client.show', $value->id)}}"><img
                            src="{{'.'.Storage::url($value->duong_dan_anh)}}" style="width: 100%" alt=""></a>
                            @endif
                            @if ($value->gia_khuyen_mai!=NULL)
                            <div class="label_product">
                                <span class="label_sale">-{{round(($value->gia - $value->gia_khuyen_mai) / $value->gia * 100)}}%</span>
                            </div>
                            @endif
                        <div class="action_links">
                            <ul>
                                <li class="wishlist">
                                    @php
                                    $love = false;
                                    @endphp

                                    @foreach ($checkSanPhamYeuThichKhuyenMai as $valueYeuThich)
                                    @if ($valueYeuThich['id_san_pham'] == $value->id)
                                        <a href="javascript:void(0)" title="Yêu thích"><i class="fa fa-heart" aria-hidden="true"></i></a>
                                        @php
                                            $love = true;
                                        @endphp
                                        @break
                                    @endif
                                    @endforeach

                                    @if (!$love)
                                    <a href="{{ route('client.favorite', $value->id) }}" title="Yêu thích"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                    @endif
                                    </li>
                                <li class="quick_button"><a href="#" data-bs-toggle="modal" data-bs-target="#modal_box_khuyen_mai_{{$value->id}}"
                                        title="Xem nhanh"> <span class="ion-ios-search-strong"></span></a></li>
                            </ul>
                        </div>
                        <div class="add_to_cart">
                            @if($value->kieu_san_pham == 1)
                               @if ($value->so_luong > 0)
                                <button type="submit" title="Thêm giỏ hàng" style="border: none">Thêm Giỏ Hàng</button>
                               @else
                               <button disabled title="Hết hàng" style="border: none; cursor: not-allowed">Hết Hàng</button>
                            @endif
                            @else
                            @if ($value->sum_so_luong > 0)
                            <a href="{{route('client.show', $value->id)}}" title="Xem tùy chọn">Xem Tùy Chọn</a>
                            @else    
                            <button disabled title="Hết hàng" style="border: none; cursor: not-allowed">Hết Hàng</button>
                            @endif
                            @endif
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
                    </div>
                    <figcaption class="product_content">
                        <div class="price_box">
                            @if($value->gia_khuyen_mai !== NULL)
                            <span class="old_price">{{number_format($value->gia, 0, '', '.')}}đ</span>
                            <span class="current_price" style="font-size: 14px">{{number_format($value->gia_khuyen_mai, 0, '', '.')}}đ</span>
                            @else
                            <span class="current_price" style="font-size: 14px">{{$value->gia == NULL ? number_format($value->gia_min, 0, '', '.').'đ - '. number_format($value->gia_max, 0, '', '.') : number_format($value->gia, 0, '', '.')}}đ</span>
                            @endif
                        </div>
                        <h3 class="product_name"><a href="{{route('client.show', $value->id)}}">{{$value->ten_san_pham}}</a></h3>
                    </figcaption>
                </figure>
            </article>
            </form>
            @endforeach
        </div>
    </div>
</section>
<!--product area end-->