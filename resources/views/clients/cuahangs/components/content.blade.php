<!--shop  area start-->
<div class="shop_area shop_reverse mt-60 mb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <!--sidebar widget start-->
                <aside class="sidebar_widget">
                    <div class="widget_inner" style="padding-top: 48px">
                        <div class="widget_list widget_categories">
                            <h2>Lọc Theo Danh Mục</h2>
                            <ul>
                                {{-- @php
                                function printCategoryRow($danhMuc, $level = 0, $category) {
                                    echo '<li><a style="'.(($category == $danhMuc->id) ? "color: #0063d1" : "").'" href="'.route('client.shop').'?category='.$danhMuc->id.'">'.str_repeat('--', $level).' '.$danhMuc->ten_danh_muc.'</a></li>';
                                    if ($danhMuc->children->count() > 0) {
                                        foreach ($danhMuc->children as $child) {
                                            printCategoryRow($child, $level + 1, $category);
                                        }
                                    }
                                }
                                @endphp
                                @foreach ($listDanhMuc as $danhMuc)
                                @if ($danhMuc->danh_muc_cha_id == null) <!-- Chỉ hiển thị danh mục cha -->
                                    @php printCategoryRow($danhMuc, 0, $category); @endphp
                                @endif
                                @endforeach --}}
                                {{-- <li class="widget_sub_categories"><a href="#">Computer &
                                        Networking</a>
                                    <ul class="widget_dropdown_categories">
                                        <li class="widget_sub_categories"><a href="#">Computer &
                                        Networking</a>
                                    <ul class="widget_dropdown_categories">
                                        <li><a href="#">Computer</a></li>
                                        <li><a href="#">Networking</a></li>
                                    </ul>
                                </li>
                                        <li class="widget_sub_categories"><a href="#">Computer &
                                        Networking</a>
                                    <ul class="widget_dropdown_categories">
                                        <li><a href="#">Computer</a></li>
                                        <li><a href="#">Networking</a></li>
                                    </ul>
                                </li>
                                    </ul>
                                </li> --}}
                           
                            @php
                            function printCategoryList($danhMuc, $category) {
                                $hasChildren = $danhMuc->children->count() > 0;
                                $isActive = ($category == $danhMuc->id) ? 'color: #0063d1' : '';
                                
                                $href = $hasChildren ? 'javascript:void(0)' : route('client.shop') .'?category='. $danhMuc->id;
                                $class = $hasChildren ? 'parent_custom' : "";
                                
                                echo '<li class="widget_sub_categories">';
                                echo '<a style="'. $isActive .'" href="'. $href .'" class="'.$class.'">'. str_repeat('--', $danhMuc->level) .' '. $danhMuc->ten_danh_muc .'</a>';
                                
                                if ($hasChildren) {
                                    echo '<ul class="widget_dropdown_categories">';
                                    foreach ($danhMuc->children as $child) {
                                        printCategoryList($child, $category);
                                    }
                                    echo '</ul>';
                                }
                                
                                echo '</li>';
                            }
                            @endphp

                            @foreach ($listDanhMuc as $danhMuc)
                                @if ($danhMuc->danh_muc_cha_id == null) <!-- Chỉ hiển thị danh mục cha -->
                                    @php printCategoryList($danhMuc, $category); @endphp
                                @endif
                            @endforeach
                            </ul>
                        </div>
                        <div class="widget_list widget_filter">
                            <h2>Lọc Theo Giá</h2>
                            <form action="{{route('client.shop')}}" method="get">
                                <div id="slider-range"></div>
                                <input type="text" class="w-100 text-start" name="text" id="amount" readonly/>
                                <button type="submit">Lọc</button>
                            </form>
                        </div>
                        <div class="widget_list tags_widget">
                            <h2>Loại Sản Phẩm</h2>
                            <div class="tag_cloud">
                                <a style="{{$loai==1 ? 'background: #0063d1; border-color: #0063d1;color: #ffffff' : ''}}" href="{{route('client.shop').'?loai=1'}}">Đon Giản</a>
                                <a style="{{$loai==2 ? 'background: #0063d1; border-color: #0063d1;color: #ffffff' : ''}}" href="{{route('client.shop').'?loai=2'}}">Biến Thể</a>
                            </div>
                        </div>
                    </div>
                </aside>
                <!--sidebar widget end-->
            </div>
            <div class="col-lg-9 col-md-12">
                <!--shop wrapper start-->
                <!--shop toolbar start-->
                <div class="shop_toolbar_wrapper">
                    <div class="shop_toolbar_btn">

                        <button data-role="grid_3" type="button" class="active btn-grid-3" data-bs-toggle="tooltip"
                            title="3"></button>

                        <button data-role="grid_4" type="button" class=" btn-grid-4" data-bs-toggle="tooltip"
                            title="4"></button>

                        <button data-role="grid_list" type="button" class="btn-list" data-bs-toggle="tooltip"
                            title="List"></button>
                    </div>

                    <div class="tag_cloud tag_cloud_custom">
                        <a style="height: 42px;" class="m-0 d-flex align-items-center" href="{{route('client.shop')}}">Tất cả</a>
                    </div>
                    <div class="niceselect_option_custom">

                        <form id="form_filter" action="{{route('client.shop')}}" method="get" class="d-flex">
                            
                            <div style="margin-right: 10px">
                                <select name="perpage" class="select_option" onchange="submitForm()">
                                <option value="6" {{$perPage=="6" ? "selected" : ""}}>6 sản phẩm</option>
                                <option value="9" {{$perPage=="9" ? "selected" : ""}}>9 sản phẩm</option>
                                <option value="12" {{$perPage=="12" ? "selected" : ""}}>12 sản phẩm</option>
                                <option value="15" {{$perPage=="15" ? "selected" : ""}}>15 sản phẩm</option>
                            </select>
                            </div>

                            <div style="margin-right: 10px">
                                <select name="orderby" class="select_option" onchange="submitForm()">
                                    <option value="1" {{$orderBy=="1" ? "selected" : ""}}>Mới nhất</option>
                                    <option value="2" {{$orderBy=="2" ? "selected" : ""}}>Cũ nhất</option>
                                    <option value="3" {{$orderBy=="3" ? "selected" : ""}}>Đánh giá</option>
                                    <option value="4" {{$orderBy=="4" ? "selected" : ""}}>Bán chạy</option>
                                    <option value="5" {{$orderBy=="5" ? "selected" : ""}}>Giá: thấp - cao</option>
                                    <option value="6" {{$orderBy=="6" ? "selected" : ""}}>Giá: cao - thấp</option>
                                </select>
                            </div>

                            <div class="search_box search_box_custom">
                                <input placeholder="Tên sản phẩm..." value="{{$search}}" class="border" name="search" style="height: 42px; border-radius: 5px; padding-right: 100px" type="text">
                                <button type="submit" style="min-width: 50px; height: 42px; right: 0" class="p-0 top-0 bottom-0"><i class="ion-search"></i></button>
                            </div>

                        </form>
                    </div>
                    {{-- <div class="page_amount">
                        <p>Hiển thị {{$perPage}} trên {{$count}} kết quả</p>
                    </div> --}}
                </div>
                <!--shop toolbar end-->
                <div class="row shop_wrapper">
                    @forelse ($allSanPham as $key => $value)
                    <div class="col-lg-4 col-md-4 col-12">
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

                                                    @foreach ($checkSanPhamYeuThich as $valueYeuThich)
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
                                                <li class="quick_button"><a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modal_box_all_san_pham_{{$value->id}}" title="Xem nhanh"> <span
                                                            class="ion-ios-search-strong"></span></a></li>
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
                                    <div class="product_content grid_content">
                                        <div class="price_box">
                                            @if($value->gia_khuyen_mai !== NULL)
                                            <span class="old_price">{{number_format($value->gia, 0, '', '.')}}đ</span>
                                            <span class="current_price" style="font-size: 14px">{{number_format($value->gia_khuyen_mai, 0, '', '.')}}đ</span>
                                            @else
                                            <span class="current_price" style="font-size: 14px">{{$value->gia == NULL ? number_format($value->gia_min, 0, '', '.').'đ - '. number_format($value->gia_max, 0, '', '.') : number_format($value->gia, 0, '', '.')}}đ</span>
                                            @endif
                                        </div>
                                        <div class="product_ratings">
                                            <ul>
                                                <?php
                                                    $danhGia = $value->trungBinhSao;
                                                    // Làm tròn giá trị $danhGia lên 0.5
                                                    $danhGia = round($danhGia * 2) / 2;
    
                                                    // Khởi tạo số lượng sao đầy, sao rưỡi, và sao trống
                                                    $fullStars = floor($danhGia);
                                                    $halfStar = ($danhGia - $fullStars >= 0.5) ? 1 : 0;
                                                    $emptyStars = 5 - $fullStars - $halfStar;
    
                                                    // In sao đầy
                                                    for ($i = 0; $i < $fullStars; $i++) {
                                                        echo '<li><a href="#"><i class="ion-android-star text-warning"></i></a></li>';
                                                    }
    
                                                    // In sao rưỡi
                                                    if ($halfStar) {
                                                        echo '<li><a href="#"><i class="ion-android-star-half text-warning"></i></a></li>';
                                                    }
    
                                                    // In sao trống
                                                    for ($i = 0; $i < $emptyStars; $i++) {
                                                        echo '<li><a href="#"><i class="ion-android-star-outline text-warning"></i></a></li>';
                                                    }
                                                ?>
                                            </ul>
                                        </div>
                                        <h3 class="product_name grid_name"><a href="product-details.html">{{$value->ten_san_pham}}</a></h3>
                                    </div>
                                    <div class="product_content list_content w-100">
                                        <div class="left_caption">
                                            <div class="price_box">
                                                @if($value->gia_khuyen_mai !== NULL)
                                                <span class="old_price">{{number_format($value->gia, 0, '', '.')}}đ</span>
                                                <span class="current_price" style="font-size: 14px">{{number_format($value->gia_khuyen_mai, 0, '', '.')}}đ</span>
                                                @else
                                                <span class="current_price" style="font-size: 14px">{{$value->gia == NULL ? number_format($value->gia_min, 0, '', '.').'đ - '. number_format($value->gia_max, 0, '', '.') : number_format($value->gia, 0, '', '.')}}đ</span>
                                                @endif
                                            </div>
                                            <h3 class="product_name"><a href="product-details.html">{{$value->ten_san_pham}}</a></h3>
                                            <div class="product_ratings">
                                                <ul>
                                                    <?php
                                                    $danhGia = $value->trungBinhSao;
                                                    // Làm tròn giá trị $danhGia lên 0.5
                                                    $danhGia = round($danhGia * 2) / 2;
    
                                                    // Khởi tạo số lượng sao đầy, sao rưỡi, và sao trống
                                                    $fullStars = floor($danhGia);
                                                    $halfStar = ($danhGia - $fullStars >= 0.5) ? 1 : 0;
                                                    $emptyStars = 5 - $fullStars - $halfStar;
    
                                                    // In sao đầy
                                                    for ($i = 0; $i < $fullStars; $i++) {
                                                        echo '<li><a href="#"><i class="ion-android-star text-warning"></i></a></li>';
                                                    }
    
                                                    // In sao rưỡi
                                                    if ($halfStar) {
                                                        echo '<li><a href="#"><i class="ion-android-star-half text-warning"></i></a></li>';
                                                    }
    
                                                    // In sao trống
                                                    for ($i = 0; $i < $emptyStars; $i++) {
                                                        echo '<li><a href="#"><i class="ion-android-star-outline text-warning"></i></a></li>';
                                                    }
                                                ?>
                                                </ul>
                                            </div>
                                            <div class="product_desc">
                                                {!!$value->mo_ta_ngan !== NULL ? $value->mo_ta_ngan : "Sản phẩm chưa có mô tả ngắn"!!}
                                            </div>
                                        </div>
                                        <div class="right_caption">
                                            <div class="add_to_cart">
                                                @if($value->kieu_san_pham == 1)
                                                <button type="submit" title="Thêm giỏ hàng">Thêm Giỏ Hàng</a>
                                                @else
                                                <a href="{{route('client.show', $value->id)}}" title="Xem tùy chọn">Xem Tùy Chọn</a>
                                                @endif
                                            </div>
                                            <div class="action_links">
                                                <ul>
                                                    <li class="wishlist">
                                                        @php
                                                    $love = false;
                                                    @endphp

                                                    @foreach ($checkSanPhamYeuThich as $valueYeuThich)
                                                    @if ($valueYeuThich['id_san_pham'] == $value->id)
                                                    <a href="javascript:void(0)"
                                                        title="Yêu thích"><i class="fa fa-heart"
                                                            aria-hidden="true"></i> Yêu thích</a>
                                                        @php
                                                            $love = true;
                                                        @endphp
                                                        @break
                                                    @endif
                                                    @endforeach

                                                    @if (!$love)
                                                    <a href="{{ route('client.favorite', $value->id) }}"
                                                        title="Yêu thích"><i class="fa fa-heart-o"
                                                            aria-hidden="true"></i> Yêu thích</a>
                                                    @endif
                                                    </li>
                                                    <li class="quick_button"><a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#modal_box_all_san_pham_{{$value->id}}" title="Xem nhanh"> <span
                                                                class="ion-ios-search-strong"></span> Xem nhanh</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </figure>
                            </article>
                        </form>
                    </div>
                    @empty
                    <p>
                    Không có sản phẩm nào
                    </p>                    
                    @endforelse
                </div>

                <div class="shop_toolbar t_bottom" style="border: none">
                    {{-- <div class="pagination"> --}}
                        {{ $allSanPham->appends(request()->query())->links('pagination::bootstrap-4') }}
                        {{-- <ul>
                            <li class="current">1</li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li class="next"><a href="#">next</a></li>
                            <li><a href="#">>></a></li>
                        </ul> --}}
                    {{-- </div> --}}
                </div>
                <!--shop toolbar end-->
                <!--shop wrapper end-->
            </div>
        </div>
    </div>
</div>
<!--shop  area end-->
<script>
      function submitForm() {
      document.getElementById('form_filter').submit();
      }
</script>