<!--product details start-->
<div class="product_details variable_product mt-60 mb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="product-details-tab" style="position: relative">
                    <div id="img-1" class="zoomWrapper single-zoom">
                        <a href="{{asset('chi-tiet-san-pham/'.$sanPhamDetail[0]->id.'#')}}" class="d-flex justify-content-center align-items-center" style="aspect-ratio: 1/1; overflow: hidden;">
                           <div>
                            <img id="zoom1" src="{{'.'.Storage::url($sanPhamDetail[0]->anh_san_pham)}}" width="380px"
                            data-zoom-image="{{'.'.Storage::url($sanPhamDetail[0]->anh_san_pham)}}" alt="big-1">
                           </div>
                        </a>
                    </div>
                    <div class="single-zoom-thumb">
                        <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                            <li>
                                <a href="#" class="elevatezoom-gallery active d-flex justify-content-center align-items-center" style="aspect-ratio: 1/1; overflow: hidden;" data-update=""
                                    data-image="{{'.'.Storage::url($sanPhamDetail[0]->anh_san_pham)}}"
                                    data-zoom-image="{{'.'.Storage::url($sanPhamDetail[0]->anh_san_pham)}}">
                                    <img src="{{'.'.Storage::url($sanPhamDetail[0]->anh_san_pham)}}" alt="zo-th-1" />
                                </a>
                            </li>
                            @foreach ($alBumAnh as $key => $value)
                            @if($value->duong_dan_anh !== NULL)
                            <li>
                                <a href="#" class="elevatezoom-gallery active d-flex justify-content-center align-items-center" style="aspect-ratio: 1/1; overflow: hidden;" data-update=""
                                    data-image="{{'.'.Storage::url($value->duong_dan_anh)}}"
                                    data-zoom-image="{{'.'.Storage::url($value->duong_dan_anh)}}">
                                    <img src="{{'.'.Storage::url($value->duong_dan_anh)}}" alt="zo-th-1" />
                                </a>
                            </li>
                            @endif
                            @endforeach
                            @foreach ($alBumAnhBienThe as $key => $value)
                                        @if($value->anh_bien_the_san_pham !== NULL)
                                        <li>
                                          <a href="#" class="elevatezoom-gallery active d-flex justify-content-center align-items-center" style="aspect-ratio: 1/1; overflow: hidden;" data-update=""
                                          data-image="{{'.'.Storage::url($value->anh_bien_the_san_pham)}}"
                                          data-zoom-image="{{'.'.Storage::url($value->anh_bien_the_san_pham)}}">
                                          <img src="{{'.'.Storage::url($value->anh_bien_the_san_pham)}}" alt="zo-th-1" />
                                         </a>
                                        </li>
                                        @endif
                            @endforeach            
                        </ul>
                    </div>
                    <div style="z-index: 50; position: absolute; top: 0; left: 0; background-color: #0063d1; border-bottom-right-radius: 2px; padding: 2px 6px" class="text-white">Còn 
                        @if($sanPhamDetail[0]->kieu_san_pham == 2)
                        {{$sumSoLuong}}
                        @else
                        {{$sanPhamDetail[0]->so_luong}}
                        @endif
                    </div>
                    @php
                        $daBan = DB::table("san_phams")
                        ->leftJoin('bien_the_san_phams', 'san_phams.id', '=', 'bien_the_san_phams.san_pham_id')
                        ->leftJoin('chi_tiet_don_hangs', function($join) {
                            $join->on('chi_tiet_don_hangs.san_pham_id', '=', 'san_phams.id')
                                ->orOn('chi_tiet_don_hangs.bien_the_san_pham_id', '=', 'bien_the_san_phams.id');
                        })
                        ->where('san_phams.id', $sanPhamDetail[0]->id)
                        ->sum('chi_tiet_don_hangs.so_luong');
                    @endphp
            <div style="z-index: 50; position: absolute; top: 0; right: 0; border-top-left-radius: 2px; padding: 2px 6px" class="text-white bg-danger">Đã bán
            {{$daBan}}
            </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="product_d_right">
                    <form action="{{route('client.addtocart', $sanPhamDetail[0]->id)}}" method="post">
                        @csrf
                        <h1 style="text-transform: none">{{$sanPhamDetail[0]->ten_san_pham}}</h1>
                        <div class="product_nav">
                            <ul>
                                <li class="prev"><a href="{{route('client.show', $preShow[0]->id)}}"><i class="fa fa-angle-left"></i></a></li>
                                <li class="next"><a href="{{route('client.show', $nextShow[0]->id)}}"><i class="fa fa-angle-right"></i></a></li>
                            </ul>
                        </div>
                        <div class="product_ratting">
                            <ul>
                                <?php
                                    $danhGia = $listDanhGia->avg('sao');
                                    // Làm tròn giá trị $danhGia lên 0.5
                                    $danhGia = round($danhGia * 2) / 2;
                    
                                    // Khởi tạo số lượng sao đầy, sao rưỡi, và sao trống
                                    $fullStars = floor($danhGia);
                                    $halfStar = ($danhGia - $fullStars >= 0.5) ? 1 : 0;
                                    $emptyStars = 5 - $fullStars - $halfStar;
                    
                                    // In sao đầy
                                    for ($i = 0; $i < $fullStars; $i++) {
                                        echo '<i class="fa fa-star text-warning"></i> ';
                                    }
                    
                                    // In sao rưỡi
                                    if ($halfStar) {
                                        echo '<i class="fa fa-star-half-o text-warning"></i> ';
                                    }
                    
                                    // In sao trống
                                    for ($i = 0; $i < $emptyStars; $i++) {
                                        echo '<i class="fa fa-star-o text-warning"></i> ';
                                    }
                                ?>
                                <li class="review"><a href="#">(Đánh giá)</a></li>
                            </ul>

                        </div>
                        <div class="price_box">
                            @if ($sanPhamDetail[0]->gia_khuyen_mai != NULL)
                            <span class="old_price">{{number_format($sanPhamDetail[0]->gia, 0, '', '.')}} VNĐ</span>
                            <span class="current_price">{{number_format($sanPhamDetail[0]->gia_khuyen_mai, 0, '', '.')}} VNĐ</span>
                            @elseif($sanPhamDetail[0]->kieu_san_pham == 2)
                            <span class="current_price">{{number_format($minPrice, 0, '', '.')}} VNĐ - {{number_format($maxPrice, 0, '', '.')}} VNĐ</span>
                            @else
                            <span class="current_price">{{number_format($sanPhamDetail[0]->gia, 0, '', '.')}} VNĐ</span>
                            @endif
                        </div>
                        <div class="product_desc">
                            {!!$sanPhamDetail[0]->mo_ta_ngan === NULL ? "Sản phẩm chưa có mô tả ngắn" : $sanPhamDetail[0]->mo_ta_ngan!!}
                        </div>
                        @if ($sanPhamDetail[0]->gia_khuyen_mai != NULL && $sanPhamDetail[0]->ngay_ket_thuc_km != NULL)
                        <div class="product_timing">
                            @php
                                $timestamp = strtotime($sanPhamDetail[0]->ngay_ket_thuc_km);
                                $newTimestamp = strtotime('+1 day', $timestamp);
                                $promotionEndDate = date('Y-m-d', $newTimestamp);
                            @endphp
                            <div data-countdown="{{$promotionEndDate}}"></div>
                        </div>
                        @endif
                        @if($sanPhamDetail[0]->kieu_san_pham == 2)
                            @php
                                $keys = array_keys($result);
                            @endphp
                            @foreach ($result as $key => $values)
                            @php
                                $keyAlt = array_search($key, $keys);
                            @endphp
                            <div class="product_variant size" style="margin-bottom: 20px">
                                <label>{{ $key }}</label>
                            <input type="hidden" name="atrributes[]" value="{{$key}}">
                            <select class="niceselect_option" name="values[]">
                                <option value="0">Chọn một tùy chọn</option>
                                @foreach ($values as $value)
                                <option value="{{ $value }}" @if(in_array($value, old('values', []))) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has("values.$keyAlt"))
                            <p class="text-danger">{{$errors->first("values.$keyAlt")}} <span style="text-transform: lowercase">{{$key}}</span></p>
                            @else
                            @if ($errors->has("values"))
                            <p class="text-danger">{{$errors->first("values")}} <span style="text-transform: lowercase">{{$key}}</span></p>
                            @endif
                            @endif
                        </div>
                            @endforeach
                            @endif
                        <div class="product_variant quantity" style="display: block">
                            @if($sanPhamDetail[0]->kieu_san_pham == 1)
                            <div>
                                <label style="display: block" class="mb-1">Số lượng</label>
                            <input class="ms-0" name="quantity" min="1" max="50" value="1" type="number">
                            </div>
                            @else
                            <label>Số lượng</label>
                            <input min="1" max="50" name="quantity" value="1" type="number">
                            @endif
                            @if($sanPhamDetail[0]->kieu_san_pham == 2)
                            @if($sumSoLuong > 0)
                            <button class="button" type="submit">Thêm vào giỏ hàng</button>
                            @else
                            <button disabled class="button" type="button">Hết hàng</button>
                            @endif
                            @endif
                            @if ($errors->has("quantity"))
                            <p class="text-danger">{{$errors->first("quantity")}}</p>
                            @endif
                        </div>
                        @if($sanPhamDetail[0]->kieu_san_pham != 2)
                        <div class="product_variant quantity">
                            @if($sanPhamDetail[0]->so_luong > 0)
                            <button class="button ms-0" type="submit">Thêm vào giỏ hàng</button>
                            @else
                            <button disabled class="button ms-0" type="button">Hết hàng</button>
                            @endif
                        </div>
                        @endif
                        <div class="product_d_action">
                            <ul>
                                <li><a href="{{route('client.favorite', $sanPhamDetail[0]->id)}}" title="Add to wishlist">+ Thêm vào danh sách yêu thích</a></li>
                            </ul>
                        </div>
                    </form>
                    <div class="product_d_meta">
                        <span>Mã sản phẩm: <strong>{{$sanPhamDetail[0]->ma_san_pham}}</strong></span>
                        <span>Danh mục: <a href="{{route('client.shop').'?category='.$sanPhamDetail[0]->id_danh_muc}}">{{$sanPhamDetail[0]->ten_danh_muc}}</a>@foreach ($allParents as $key => $value), <a href="{{route('client.shop').'?category='.$value->id}}">{{$value->ten_danh_muc}}</a>@endforeach</span>
                    </div>
                    @if ($sanPhamDetail[0]->kieu_san_pham == 2)
                    <div class="row" style="row-gap: 10px">
                        @foreach ($sanPhamShow as $key => $value)
                            <div class="col-6 col-sm-4 col-md-6 col-lg-4 d-flex align-items-center">
                                <img src="{{$value->anh_bien_the_san_pham === NULL ? '.'.Storage::url($sanPhamDetail[0]->anh_san_pham) : '.'.Storage::url($value->anh_bien_the_san_pham)}}" class="me-1" style="width: 40px; aspect-ratio: 1/1; object-fit: cover" alt="Ảnh biến thể">
                                <div style="font-size: 10px; display: flex; flex-direction: column">
                                    <span style="line-height: normal; margin-bottom: 2px; color: #0063d1; font-weight: 500; font-size: 11px" title="">{{$value->ten_gia_tri_thuoc_tinh_bt}}</span>
                                    <span style="line-height: normal; margin-bottom: 2px" title="">{{number_format($value->gia, 0, '', '.')}} vnđ</span>
                                    <span style="line-height: normal" title="">Còn: {{$value->so_luong}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @else
                    <div class="priduct_social">
                        <ul>
                            <li><a class="facebook" href="javascript:void(0)" title="facebook"><i class="fa fa-facebook"></i>
                                    Like</a></li>
                            <li><a class="twitter" href="javascript:void(0)" title="twitter"><i class="fa fa-twitter"></i> tweet</a>
                            </li>
                            <li><a class="pinterest" href="javascript:void(0)" title="pinterest"><i class="fa fa-pinterest"></i>
                                    save</a></li>
                            <li><a class="google-plus" href="javascript:void(0)" title="google +"><i class="fa fa-google-plus"></i>
                                    share</a></li>
                            <li><a class="linkedin" href="javascript:void(0)" title="linkedin"><i class="fa fa-linkedin"></i>
                                    linked</a></li>
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
<!--product details end-->

<!--product info start-->
<div class="product_d_info mb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product_d_inner">
                    <div class="product_info_button">
                        <ul class="nav" role="tablist">
                            <li>
                                <a class="active" data-bs-toggle="tab" href="#info" role="tab" aria-controls="info"
                                    aria-selected="false">Mô Tả Chi Tiết</a>
                            </li>
                            <li>
                                <a data-bs-toggle="tab" href="#sheet" role="tab" aria-controls="sheet"
                                    aria-selected="false">Bình Luận ({{count($listBinhLuan)}})</a>
                            </li>
                            <li>
                                <a data-bs-toggle="tab" href="#reviews" role="tab" aria-controls="reviews"
                                    aria-selected="false">Đánh Giá ({{count($listDanhGia)}})</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <div class="product_info_content">
                                {!! $sanPhamDetail[0]->mo_ta === NULL ? 'Sản phẩm này chưa có mô tả chi tiết' : $sanPhamDetail[0]->mo_ta !!}
                            </div>
                        </div>
                        <div class="tab-pane fade" id="sheet" role="tabpanel">
                            <div class="reviews_wrapper">
                                <h2 style="text-transform: none; font-weight: normal">{{count($listBinhLuan)}} bình luận cho <strong>{{$sanPhamDetail[0]->ten_san_pham}}</strong></h2>
                                    @forelse ($listBinhLuan as $key => $value)
                                <div class="reviews_comment_box">   
                                    <div class="comment_thmb">
                                        <img style="width: 80px;" src="{{$value->anh_dai_dien === NULL ? "./storage/uploads/khachhang/avatar.png" : ".".Storage::url($value->anh_dai_dien)}}" alt="">
                                    </div>
                                    <div class="comment_text">
                                        <div class="reviews_meta">
                                            <div class="star_rating">
                                                <small><?php
                                                    $dateString = $value->thoi_gian;
                                                    $date = new DateTime($dateString);
                                                    $now = new DateTime();
        
                                                    // Tính toán sự khác biệt giữa hai ngày
                                                    $interval = $now->diff($date);
        
                                                    // Xác định kết quả dựa trên sự khác biệt
                                                    $years = $interval->y;
                                                    $months = $interval->m;
                                                    $days = $interval->d;
                                                    $weeks = floor($interval->days / 7); // Tính số tuần
                                                    $hours = $interval->h;
                                                    $minutes = $interval->i;
                                                    $seconds = $interval->s;
        
                                                    if ($years > 0) {
                                                    echo $years . " năm trước";
                                                    } elseif ($months > 0) {
                                                    echo $months . " tháng trước";
                                                    } elseif ($weeks > 0) {
                                                    echo $weeks . " tuần trước";
                                                    } elseif ($days > 0) {
                                                    echo $days . " ngày trước";
                                                    } elseif ($hours > 0) {
                                                    echo $hours . " giờ trước";
                                                    } elseif ($minutes > 0) {
                                                    echo $minutes . " phút trước";
                                                    } elseif ($seconds > 0) {
                                                    echo $seconds . " giây trước";
                                                    } else {
                                                    echo "vừa mới đây";
                                                    }
                                                    ?></small>
                                            </div>
                                            <p class="mb-0"><strong style="text-transform: none">{{(Auth::id() && $value->id === Auth::id()) ? 'Bạn' : $value->name}} </strong> đã bình luận cho <strong style="text-transform: none">{{$sanPhamDetail[0]->ten_san_pham}}</strong></p>
                                            <small>
                                                <?php
                                        $dateString = $value->thoi_gian;
                                        // Chuyển đổi định dạng
                                        $date = new DateTime($dateString);
                                        $now = new DateTime();

                                        $today = $now->format('Y-m-d');
                                        $yesterday = $now->modify('-1 day')->format('Y-m-d');
                                        $targetDate = $date->format('Y-m-d');

                                        // So sánh thời gian
                                        if ($targetDate === $today) {
                                        echo "Hôm nay";
                                        } elseif ($targetDate === $yesterday) {
                                        echo "Hôm qua";
                                        } else {
                                        echo ""; // Chuỗi rỗng nếu không phải hôm nay hoặc hôm qua
                                        }?> {{date('H:i - d.m.Y', strtotime($value->thoi_gian))}}
                                            </small>
                                            <p class="mb-0" style="margin-top: 3px">{{$value->noi_dung}}</p>
                                        </div>
                                    </div>
                                   </div>
                                    @empty
                                    <p>
                                    Sản phẩm này chưa có bình luận nào
                                    </p>
                                    @endforelse
                                <div class="comment_title mb-0">
                                    <h2 class="mb-0" style="text-transform: none;">Thêm bình luận cho sản phẩm</h2>
                                </div>
                                <div class="product_review_form">
                                    <form id="form-comment" action="{{route('client.comment', $sanPhamDetail[0]->id)}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <label>Nội dung</label>
                                                <textarea name="comment" id="comment"></textarea>
                                                <p class="text-danger mb-0" id="error-comment">{{$errors->has("comment") ? $errors->first("comment") : ""}}</p>
                                            </div>
                                        </div>
                                        <button type="submit">Bình luận</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="reviews_wrapper">
                                    <div style="display: flex; margin-bottom: 30px">
                                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 25%; border: 1px solid rgba(0, 0, 0, 0.1); border-top-left-radius: 3px; border-bottom-left-radius: 3px">
                                          <strong>{{round($listDanhGia->avg('sao') * 2) / 2}}/5</strong>
                                          <div>
                                            <?php
                                                    $danhGia = $listDanhGia->avg('sao');
                                                    // Làm tròn giá trị $danhGia lên 0.5
                                                    $danhGia = round($danhGia * 2) / 2;
                                    
                                                    // Khởi tạo số lượng sao đầy, sao rưỡi, và sao trống
                                                    $fullStars = floor($danhGia);
                                                    $halfStar = ($danhGia - $fullStars >= 0.5) ? 1 : 0;
                                                    $emptyStars = 5 - $fullStars - $halfStar;
                                    
                                                    // In sao đầy
                                                    for ($i = 0; $i < $fullStars; $i++) {
                                                        echo '<i class="fa fa-star text-warning"></i> ';
                                                    }
                                    
                                                    // In sao rưỡi
                                                    if ($halfStar) {
                                                        echo '<i class="fa fa-star-half-o text-warning"></i> ';
                                                    }
                                    
                                                    // In sao trống
                                                    for ($i = 0; $i < $emptyStars; $i++) {
                                                        echo '<i class="fa fa-star-o text-warning"></i> ';
                                                    }
                                                ?>
                                          </div>
                                        </div>
                                      <div style="flex: 1; border: 1px solid rgba(0, 0, 0, 0.1); border-left: none; border-top-right-radius: 3px; border-bottom-right-radius: 3px"><div>
                                        <div style="border-bottom: 1px solid rgba(0, 0, 0, 0.1); text-align: center; padding-top: 3px; padding-bottom: 3px">{{$listDanhGia->where('sao', 1)->count()}} đánh giá 1 <i class="fa fa-star text-warning"></i></div>
                                           <div style="border-bottom: 1px solid rgba(0, 0, 0, 0.1); text-align: center; padding-top: 3px; padding-bottom: 3px">{{$listDanhGia->where('sao', 2)->count()}} đánh giá 2 <i class="fa fa-star text-warning"></i></div>
                                           <div style="border-bottom: 1px solid rgba(0, 0, 0, 0.1); text-align: center; padding-top: 3px; padding-bottom: 3px">{{$listDanhGia->where('sao', 3)->count()}} đánh giá 3 <i class="fa fa-star text-warning"></i></div>
                                           <div style="border-bottom: 1px solid rgba(0, 0, 0, 0.1); text-align: center; padding-top: 3px; padding-bottom: 3px">{{$listDanhGia->where('sao', 4)->count()}} đánh giá 4 <i class="fa fa-star text-warning"></i></div>
                                           <div style="text-align: center; padding-top: 3px; padding-bottom: 3px">{{$listDanhGia->where('sao', 5)->count()}} đánh giá 5 <i class="fa fa-star text-warning"></i></div>
                                    </div>
                                    </div>
                                    </div>
                                <h2 style="text-transform: none; font-weight: normal">{{count($listDanhGia)}} đánh giá cho <strong>{{$sanPhamDetail[0]->ten_san_pham}}</strong></h2>
                                    @forelse ($listDanhGia as $key => $value)
                                <div class="reviews_comment_box">   
                                    <div class="comment_thmb">
                                        <img style="width: 80px;" src="{{$value->anh_dai_dien === NULL ? "./storage/uploads/khachhang/avatar.png" : ".".Storage::url($value->anh_dai_dien)}}" alt="">
                                    </div>
                                    <div class="comment_text">
                                        <div class="reviews_meta">
                                            <div class="star_rating">
                                                <small>{{date('d.m.Y', strtotime($value->ngay_danh_gia))}}</small>
                                            </div>
                                            <p class="mb-0"><strong style="text-transform: none">{{(Auth::id() && $value->id === Auth::id()) ? 'Bạn' : $value->name}} </strong> đã đánh giá <strong style="text-transform: none">{{$value->sao}} sao</strong></p>
                                            <div class="star_rating" style="float: left">
                                            <ul>
                                                <?php
                                                    $danhGia = $value->sao;
                                                    // Làm tròn giá trị $danhGia lên 0.5
                                                    $danhGia = round($danhGia * 2) / 2;
                                    
                                                    // Khởi tạo số lượng sao đầy, sao rưỡi, và sao trống
                                                    $fullStars = floor($danhGia);
                                                    $halfStar = ($danhGia - $fullStars >= 0.5) ? 1 : 0;
                                                    $emptyStars = 5 - $fullStars - $halfStar;
                                    
                                                    // In sao đầy
                                                    for ($i = 0; $i < $fullStars; $i++) {
                                                        echo '<li><i style="font-size: 12px" class="fa fa-star text-warning"></i></li> ';
                                                    }
                                    
                                                    // In sao rưỡi
                                                    if ($halfStar) {
                                                        echo '<li><i style="font-size: 12px" class="fa fa-star-half-o text-warning"></i></li> ';
                                                    }
                                    
                                                    // In sao trống
                                                    for ($i = 0; $i < $emptyStars; $i++) {
                                                        echo '<li><i style="font-size: 12px" class="fa fa-star-o text-warning"></i></li> ';
                                                    }
                                                ?>
                                            </ul>
                                            </div><br />
                                            <span>{{$value->noi_dung}}</span>
                                        </div>
                                    </div>
                                   </div>
                                    @empty
                                    <p>
                                    Sản phẩm này chưa có đánh giá nào
                                    </p>
                                    @endforelse
                                <div class="comment_title mb-0">
                                    <h2 class="mb-0" style="text-transform: none;">Thêm đánh giá cho sản phẩm</h2>
                                </div>
                                <div class="product_ratting mb-2">
                                    <h3 class="mb-0" style="text-transform: none; font-weight: normal">Chất lượng sản phẩm</h3>
                                    <ul class="stars">
                                        <li><i style="cursor: pointer" class="fa fa-star-o text-warning" data-value="1"></i></li>
                                        <li><i style="cursor: pointer" class="fa fa-star-o text-warning" data-value="2"></i></li>
                                        <li><i style="cursor: pointer" class="fa fa-star-o text-warning" data-value="3"></i></li>
                                        <li><i style="cursor: pointer" class="fa fa-star-o text-warning" data-value="4"></i></li>
                                        <li><i style="cursor: pointer" class="fa fa-star-o text-warning" data-value="5"></i></li>
                                    </ul>
                                    <p class="text-danger" id="error-star">{{$errors->has("rating") ? $errors->first("rating") : ""}}</p>
                                </div>
                                <div class="product_review_form">
                                    <form id="form-review" action="{{route('client.review', $sanPhamDetail[0]->id)}}" method="post">
                                        @csrf
                                    <input type="hidden" id="rating" name="rating" value="0">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="review_comment">Nhận xét</label>
                                                <textarea name="comment" id="review_comment"></textarea>
                                                <p class="text-danger mb-0" id="error-text">{{$errors->has("comment") ? $errors->first("comment") : ""}}</p>
                                            </div>
                                        </div>
                                        <button type="submit">Đánh giá</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--product info end-->

<!--product area start-->
<section class="product_area related_products">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section_title">
                    <h2>Sản Phẩm Cùng Loại</h2>
                </div>
            </div>
        </div>
        <div class="product_carousel product_column5 owl-carousel">
            @forelse ($sanPhamCungLoai as $key => $value)
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
    
                                        @foreach ($checkSanPhamYeuThichCungLoai as $valueYeuThich)
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
                                    <li class="quick_button"><a href="#" data-bs-toggle="modal" data-bs-target="#modal_box_cung_loai_{{$value->id}}"
                                            title="Xem nhanh"> <span class="ion-ios-search-strong"></span></a></li>
                                </ul>
                            </div>
                            <div class="add_to_cart">
                                @if($value->kieu_san_pham == 1)
                                @if($value->so_luong > 0)
                                    <button type="submit" title="Thêm giỏ hàng" style="border: none">Thêm Giỏ Hàng</button>
                                @else
                                <button disabled title="Hết hàng" style="border: none; cursor: not-allowed">Hết hàng</button>
                                @endif        
                                @else
                                @if($value->sum_so_luong > 0)
                                    <a href="{{route('client.show', $value->id)}}" title="Xem tùy chọn">Xem Tùy Chọn</a>
                                @else
                                <button disabled title="Hết hàng" style="border: none; cursor: not-allowed">Hết hàng</button>
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
            @empty
            <p>Không có sản phẩm nào</p>
            @endforelse
        </div>
    </div>
</section>
<!--product area end-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.stars i');
    const ratingInput = document.getElementById('rating');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-value');
            ratingInput.value = rating;

            stars.forEach(s => {
                if (s.getAttribute('data-value') <= rating) {
                    s.classList.remove('fa-star-o');
                    s.classList.add('fa-star');
                } else {
                    s.classList.remove('fa-star');
                    s.classList.add('fa-star-o');
                }
            });
        });
    });
    var formComemnt = document.getElementById("form-comment");
    formComemnt.addEventListener("submit", (event) => {
        if(document.getElementById("comment").value == ""){
            document.getElementById("error-comment").innerText = "Vui lòng nhập nội dung bình luận";
            event.preventDefault();
        }else{
            document.getElementById("error-comment").innerText = "";
        }
    });
    var formReview = document.getElementById("form-review");
    formReview.addEventListener("submit", (event) => {
        var checkStar = true;
        var checkText = true;
        if(ratingInput.value != "1" && ratingInput.value != "2" && ratingInput.value != "3" && ratingInput.value != "4" && ratingInput.value != "5"){
            document.getElementById("error-star").innerText = "Vui lòng chọn sao";
            checkStar = false;
        }else{
            document.getElementById("error-star").innerText = "";
        }
        if(document.getElementById("review_comment").value == ""){
            document.getElementById("error-text").innerText = "Vui lòng gửi nhận xét của bạn";
            checkText = false;
        }else{
            document.getElementById("error-text").innerText = "";
        }
        if(!checkStar || !checkText){
            event.preventDefault();
        }
    });
});
</script>