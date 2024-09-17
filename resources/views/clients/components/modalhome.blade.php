<!-- modal area start-->
@foreach ($sanPhamKhuyenMai as $key => $value)
<div class="modal fade" id="modal_box_khuyen_mai_{{$value->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal_body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12">
                            <div class="modal_tab">
                                <div class="tab-content product-details-large">
                                    <div class="tab-pane fade show active" id="tab_main_khuyen_mai_{{$value->id}}" role="tabpanel">
                                        <div class="modal_tab_img" style="position: relative">
                                            <a href="{{route('client.show', $value->id)}}" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                <div>
                                                    <img src="{{'.'.Storage::url($value->anh_san_pham)}}" class="w-100" alt="">
                                                </div>                                            
                                            </a>
                                            <div style="font-size: 12px; z-index: 100; position: absolute; top: 0; left: 0; background-color: #0063d1; border-bottom-right-radius: 2px; padding: 2px 6px" class="text-white">Còn 
                                                @if($value->kieu_san_pham == 2)
                                                {{$value->sum_so_luong}}
                                                @else
                                                {{$value->so_luong}}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($albumAnhSanPhamKhuyenMai as $keyAlbum => $valueAlbum)
                                        @if($valueAlbum->id_san_pham == $value->id && $valueAlbum->duong_dan_anh !== NULL)
                                        <div class="tab-pane fade" id="tab_khuyen_mai_{{$valueAlbum->id_album}}" role="tabpanel">
                                            <div class="modal_tab_img">
                                                <a href="{{route('client.show', $value->id)}}" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                    <div><img src="{{'.'.Storage::url($valueAlbum->duong_dan_anh)}}" class="w-100" alt=""></div>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                    @foreach ($albumAnhBienTheKhuyenMai as $keyAlbumBienThe => $valueAlbumBienThe)
                                        @if($valueAlbumBienThe->id_san_pham == $value->id && $valueAlbumBienThe->anh_bien_the_san_pham !== NULL)
                                        <div class="tab-pane fade" id="tab_khuyen_mai_bien_the_{{$valueAlbumBienThe->id_bien_the}}" role="tabpanel">
                                            <div class="modal_tab_img">
                                                <a href="{{route('client.show', $value->id)}}" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                    <div><img src="{{'.'.Storage::url($valueAlbumBienThe->anh_bien_the_san_pham)}}" class="w-100" alt=""></div>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="modal_tab_button">
                                    <ul class="nav product_navactive owl-carousel" role="tablist">
                                        <li>
                                            <a class="nav-link active" data-bs-toggle="tab" href="#tab_main_khuyen_mai_{{$value->id}}" role="tab"
                                                aria-controls="tab_main_khuyen_mai_{{$value->id}}" aria-selected="false" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                            <div><img src="{{'.'.Storage::url($value->anh_san_pham)}}" class="w-100" alt=""></div>
                                            </a>
                                        </li>
                                        @foreach ($albumAnhSanPhamKhuyenMai as $keyAlbum => $valueAlbum)
                                        @if($valueAlbum->id_san_pham == $value->id && $valueAlbum->duong_dan_anh !== NULL)
                                        <li>
                                            <a class="nav-link" data-bs-toggle="tab" href="#tab_khuyen_mai_{{$valueAlbum->id_album}}" role="tab"
                                                aria-controls="tab_khuyen_mai_{{$valueAlbum->id_album}}" aria-selected="false" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                <div><img src="{{'.'.Storage::url($valueAlbum->duong_dan_anh)}}" class="w-100" alt=""></div>
                                            </a>
                                        </li>
                                        @endif
                                        @endforeach
                                        @foreach ($albumAnhBienTheKhuyenMai as $keyAlbumBienThe => $valueAlbumBienThe)
                                        @if($valueAlbumBienThe->id_san_pham == $value->id && $valueAlbumBienThe->anh_bien_the_san_pham !== NULL)
                                        <li>
                                            <a class="nav-link" data-bs-toggle="tab" href="#tab_khuyen_mai_bien_the_{{$valueAlbumBienThe->id_bien_the}}" role="tab"
                                                aria-controls="tab_khuyen_mai_bien_the_{{$valueAlbumBienThe->id_bien_the}}" aria-selected="false" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                <div><img src="{{'.'.Storage::url($valueAlbumBienThe->anh_bien_the_san_pham)}}" class="w-100" alt=""></div>
                                            </a>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12">
                            <div class="modal_right">
                                <div class="modal_title mb-10">
                                    <h2>{{$value->ten_san_pham}}</h2>
                                </div>
                                <div class="modal_price mb-10">
                                @if ($value->gia_khuyen_mai != NULL)
                                <span class="old_price" style="margin-left: 0; margin-right: 5px">{{number_format($value->gia, 0, '', '.')}} vnđ</span>
                                <span class="new_price">{{number_format($value->gia_khuyen_mai, 0, '', '.')}} vnđ</span>
                                @elseif($value->kieu_san_pham == 2)
                                <span class="new_price">{{number_format($value->gia_min, 0, '', '.')}} vnđ - {{number_format($value->gia_max, 0, '', '.')}} vnđ</span>
                                @else
                                <span class="new_price">{{number_format($value->gia, 0, '', '.')}} vnđ</span>
                                @endif
                                </div>
                                <div class="modal_description mb-15">
                                    {!!$value->mo_ta_ngan!!}
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
                                <form id="add-to-cart-form-khuyen-mai-{{$value->id}}" action="{{route('client.addtocart', $value->id)}}" method="post">
                                @csrf
                                <div class="variants_selects">
                                    @if ($value->kieu_san_pham == 2)
                                    @foreach ($resultKhuyenMai[$value->id] as $keyBienThe => $valueBienThes)
                                    <div class="variants_size">
                                        <h2>{{$keyBienThe}}</h2><span class="text-danger" id="{{'error-'.$keyBienThe.'-khuyen-mai-'.$value->id}}"></span>
                                        <input type="hidden" name="atrributes[]" value="{{$keyBienThe}}">
                                        <select id="{{$keyBienThe.'-khuyen-mai-'.$value->id}}" class="select_option" name="values[]">
                                            <option value="0">Chọn một tùy chọn</option>
                                            @foreach ($valueBienThes as $valueBienThe)
                                           <option value="{{ $valueBienThe }}">{{ $valueBienThe }}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                    @php
                                        echo '<script>
                                                document.getElementById("add-to-cart-form-khuyen-mai-'.$value->id.'").addEventListener("submit", function(event) {
                                                if('.Auth::id().'){
                                                        var isValid = true;
                                                        if (document.getElementById("'.$keyBienThe.'-khuyen-mai-'.$value->id.'").value === "0") {
                                                            isValid = false;
                                                        }
                                                    if (!isValid) {
                                                        document.getElementById("error-'.$keyBienThe.'-khuyen-mai-'.$value->id.'").innerHTML = "Vui lòng chọn thuộc tính <span>'.$keyBienThe.'</span>";
                                                        document.getElementById("error-'.$keyBienThe.'-khuyen-mai-'.$value->id.'").previousElementSibling.classList.add("mb-0");
                                                        event.preventDefault();
                                                    }else{
                                                        document.getElementById("error-'.$keyBienThe.'-khuyen-mai-'.$value->id.'").innerHTML = "";
                                                    }
                                                }
                                                });
                                            </script>';
                                    @endphp
                                    @endforeach
                                    @endif
                                    <div class="modal_add_to_cart modal_add_to_cart_custom">
                                        @if($value->kieu_san_pham == 1)
                                        <label class="me-2">Số lượng</label>
                                        @endif
                                        <input id="so-luong-khuyen-mai-{{$value->id}}" min="1" max="50" name="quantity" value="1" type="number">
                                        <span id="error-so-luong-khuyen-mai-{{$value->id}}" class="text-danger"></span>
                                        @if($value->kieu_san_pham == 1)<br />@endif
                                        <button {{(($value->so_luong == 0 && $value->kieu_san_pham == 1) || ($value->sum_so_luong == 0 && $value->kieu_san_pham == 2)) ? "disabled" : ""}} class="{{$value->kieu_san_pham == 1 ? 'ms-0 mt-3' : ''}}" type="{{(($value->so_luong == 0 && $value->kieu_san_pham == 1) || ($value->sum_so_luong == 0 && $value->kieu_san_pham == 2)) ? "button" : "submit"}}" style="cursor: {{(($value->so_luong == 0 && $value->kieu_san_pham == 1) || ($value->sum_so_luong == 0 && $value->kieu_san_pham == 2)) ? 'not-allowed' : 'pointer'}}">{{(($value->so_luong == 0 && $value->kieu_san_pham == 1) || ($value->sum_so_luong == 0 && $value->kieu_san_pham == 2)) ? "hết hàng" : "thêm vào giỏ hàng"}}</button>
                                        <p id="error-bien-the-so-luong-khuyen-mai-{{$value->id}}" class="text-danger mb-0"></p>
                                    </div>
                                </div> 
                            </form>
                            @php
                                echo '<script>
                                        document.getElementById("add-to-cart-form-khuyen-mai-'.$value->id.'").addEventListener("submit", function(event) {
                                        if('.Auth::id().'){
                                            var isValid = true;
                                            var soLuongKhuyenMai'.$value->id.' = document.getElementById("so-luong-khuyen-mai-'.$value->id.'");
                                            var errorSoLuongKhuyenMai'.$value->id.' = document.getElementById("error-so-luong-khuyen-mai-'.$value->id.'");
                                            var errorBienTheSoLuongKhuyenMai'.$value->id.' = document.getElementById("error-bien-the-so-luong-khuyen-mai-'.$value->id.'");
                                            if (soLuongKhuyenMai'.$value->id.'.value === "") {
                                                    var text = "Vui lòng nhập số lượng";
                                                    isValid = false;
                                            }
                                            else if (isNaN(soLuongKhuyenMai'.$value->id.'.value)) {
                                                    var text = "Số lượng phải là số";
                                                    isValid = false;
                                            }
                                            else if (soLuongKhuyenMai'.$value->id.'.value % 1 != 0) {
                                                    var text = "Số lượng phải là số nguyên";
                                                    isValid = false;
                                            }
                                            else if (soLuongKhuyenMai'.$value->id.'.value <= 0) {
                                                    var text = "Số lượng phải lớn hơn 0";
                                                    isValid = false;
                                            }else if (soLuongKhuyenMai'.$value->id.'.value > 50){
                                                    var text = "Số lượng phải nhỏ hơn 50";
                                                    isValid = false;
                                            }
                                            if (!isValid) {
                                            if('.$value->kieu_san_pham.' == 1){
                                                errorSoLuongKhuyenMai'.$value->id.'.innerHTML = "<br/>" + text;
                                            }else{
                                                errorBienTheSoLuongKhuyenMai'.$value->id.'.innerHTML = text;
                                                errorBienTheSoLuongKhuyenMai'.$value->id.'.style.marginTop = "2px";
                                            }    
                                                event.preventDefault();
                                            }else{
                                            if('.$value->kieu_san_pham.' == 1){
                                                errorSoLuongKhuyenMai'.$value->id.'.innerHTML = "";
                                            }else{
                                                errorBienTheSoLuongKhuyenMai'.$value->id.'.innerHTML = "";
                                                errorBienTheSoLuongKhuyenMai'.$value->id.'.style.marginTop = "0";
                                            }
                                            }
                                        }
                                        });
                                    </script>';
                            @endphp
                            @if ($value->kieu_san_pham == 2)
                            <div class="row" style="row-gap: 10px">
                                @foreach ($sanPhamBienTheKhuyenMaiShow as $keyBienTheKhuyenMaiShow => $valueBienTheKhuyenMaiShow)
                                @if ($value->id == $valueBienTheKhuyenMaiShow->id)
                                <div class="col-6 col-sm-4 col-md-6 col-lg-4 d-flex align-items-center">
                                    <img src="{{$valueBienTheKhuyenMaiShow->anh_bien_the_san_pham === NULL ? '.'.Storage::url($value->anh_san_pham) : '.'.Storage::url($valueBienTheKhuyenMaiShow->anh_bien_the_san_pham)}}" class="me-1" style="width: 40px; aspect-ratio: 1/1; object-fit: cover" alt="Ảnh biến thể">
                                    <div style="font-size: 10px; display: flex; flex-direction: column">
                                        <span style="line-height: normal; margin-bottom: 2px; color: #0063d1; font-weight: 500; font-size: 11px" title="">{{$valueBienTheKhuyenMaiShow->ten_gia_tri_thuoc_tinh_bt}}</span>
                                        <span style="line-height: normal; margin-bottom: 2px" title="">{{number_format($valueBienTheKhuyenMaiShow->gia, 0, '', '.')}} vnđ</span>
                                        <span style="line-height: normal" title="">Còn: {{$valueBienTheKhuyenMaiShow->so_luong}}</span>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            @else
                            <div class="modal_social">
                                <h2>Chia sẻ sản phẩm</h2>
                                <ul>
                                    <li class="facebook"><a href="javasript:void(0)"><i class="fa fa-facebook"></i></a></li>
                                    <li class="twitter"><a href="javasript:void(0)"><i class="fa fa-twitter"></i></a></li>
                                    <li class="pinterest"><a href="javasript:void(0)"><i class="fa fa-pinterest"></i></a></li>
                                    <li class="google-plus"><a href="javasript:void(0)"><i class="fa fa-google-plus"></i></a>
                                    </li>
                                    <li class="linkedin"><a href="javasript:void(0)"><i class="fa fa-linkedin"></i></a></li>
                                </ul>
                            </div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $daBan = DB::table("san_phams")
                ->leftJoin('bien_the_san_phams', 'san_phams.id', '=', 'bien_the_san_phams.san_pham_id')
                ->leftJoin('chi_tiet_don_hangs', function($join) {
                    $join->on('chi_tiet_don_hangs.san_pham_id', '=', 'san_phams.id')
                        ->orOn('chi_tiet_don_hangs.bien_the_san_pham_id', '=', 'bien_the_san_phams.id');
                })
                ->where('san_phams.id', $value->id)
                ->sum('chi_tiet_don_hangs.so_luong');
            @endphp
            <div style="font-size: 12px; z-index: 100; position: absolute; bottom: 0; right: 0; border-top-left-radius: 2px; padding: 2px 6px" class="text-white bg-danger">Đã bán
            {{$daBan}}
            </div>
        </div>
    </div>
</div>
@endforeach
@foreach ($sanPhamBanChay as $key => $value)
<div class="modal fade" id="modal_box_ban_chay_{{$value->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal_body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12">
                            <div class="modal_tab">
                                <div class="tab-content product-details-large">
                                    <div class="tab-pane fade show active" id="tab_main_ban_chay_{{$value->id}}" role="tabpanel">
                                        <div class="modal_tab_img" style="position: relative">
                                            <a href="{{route('client.show', $value->id)}}" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                <div>
                                                    <img src="{{'.'.Storage::url($value->anh_san_pham)}}" class="w-100" alt="">
                                                </div>                                            
                                            </a>
                                            <div style="font-size: 12px; z-index: 100; position: absolute; top: 0; left: 0; background-color: #0063d1; border-bottom-right-radius: 2px; padding: 2px 6px" class="text-white">Còn 
                                                @if($value->kieu_san_pham == 2)
                                                {{$value->sum_so_luong}}
                                                @else
                                                {{$value->so_luong}}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($albumAnhSanPhamBanChay as $keyAlbum => $valueAlbum)
                                        @if($valueAlbum->id_san_pham == $value->id && $valueAlbum->duong_dan_anh !== NULL)
                                        <div class="tab-pane fade" id="tab_ban_chay_{{$valueAlbum->id_album}}" role="tabpanel">
                                            <div class="modal_tab_img">
                                                <a href="{{route('client.show', $value->id)}}" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                    <div><img src="{{'.'.Storage::url($valueAlbum->duong_dan_anh)}}" class="w-100" alt=""></div>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                    @foreach ($albumAnhBienThe as $keyAlbumBienThe => $valueAlbumBienThe)
                                        @if($valueAlbumBienThe->id_san_pham == $value->id && $valueAlbumBienThe->anh_bien_the_san_pham !== NULL)
                                        <div class="tab-pane fade" id="tab_ban_chay_bien_the_{{$valueAlbumBienThe->id_bien_the}}" role="tabpanel">
                                            <div class="modal_tab_img">
                                                <a href="{{route('client.show', $value->id)}}" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                    <div><img src="{{'.'.Storage::url($valueAlbumBienThe->anh_bien_the_san_pham)}}" class="w-100" alt=""></div>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="modal_tab_button">
                                    <ul class="nav product_navactive owl-carousel" role="tablist">
                                        <li>
                                            <a class="nav-link active" data-bs-toggle="tab" href="#tab_main_ban_chay_{{$value->id}}" role="tab"
                                                aria-controls="tab_main_ban_chay_{{$value->id}}" aria-selected="false" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                            <div><img src="{{'.'.Storage::url($value->anh_san_pham)}}" class="w-100" alt=""></div>
                                            </a>
                                        </li>
                                        @foreach ($albumAnhSanPhamBanChay as $keyAlbum => $valueAlbum)
                                        @if($valueAlbum->id_san_pham == $value->id && $valueAlbum->duong_dan_anh !== NULL)
                                        <li>
                                            <a class="nav-link" data-bs-toggle="tab" href="#tab_ban_chay_{{$valueAlbum->id_album}}" role="tab"
                                                aria-controls="tab_ban_chay_{{$valueAlbum->id_album}}" aria-selected="false" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                <div><img src="{{'.'.Storage::url($valueAlbum->duong_dan_anh)}}" class="w-100" alt=""></div>
                                            </a>
                                        </li>
                                        @endif
                                        @endforeach
                                        @foreach ($albumAnhBienThe as $keyAlbumBienThe => $valueAlbumBienThe)
                                        @if($valueAlbumBienThe->id_san_pham == $value->id && $valueAlbumBienThe->anh_bien_the_san_pham !== NULL)
                                        <li>
                                            <a class="nav-link" data-bs-toggle="tab" href="#tab_ban_chay_bien_the_{{$valueAlbumBienThe->id_bien_the}}" role="tab"
                                                aria-controls="tab_ban_chay_bien_the_{{$valueAlbumBienThe->id_bien_the}}" aria-selected="false" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                <div><img src="{{'.'.Storage::url($valueAlbumBienThe->anh_bien_the_san_pham)}}" class="w-100" alt=""></div>
                                            </a>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12">
                            <div class="modal_right">
                                <div class="modal_title mb-10">
                                    <h2>{{$value->ten_san_pham}}</h2>
                                </div>
                                <div class="modal_price mb-10">
                                @if ($value->gia_khuyen_mai != NULL)
                                <span class="old_price" style="margin-left: 0; margin-right: 5px">{{number_format($value->gia, 0, '', '.')}} vnđ</span>
                                <span class="new_price">{{number_format($value->gia_khuyen_mai, 0, '', '.')}} vnđ</span>
                                @elseif($value->kieu_san_pham == 2)
                                <span class="new_price">{{number_format($value->gia_min, 0, '', '.')}} vnđ - {{number_format($value->gia_max, 0, '', '.')}} vnđ</span>
                                @else
                                <span class="new_price">{{number_format($value->gia, 0, '', '.')}} vnđ</span>
                                @endif
                                </div>
                                <div class="modal_description mb-15">
                                    {!!$value->mo_ta_ngan!!}
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
                                <form id="add-to-cart-form-ban-chay-{{$value->id}}" action="{{route('client.addtocart', $value->id)}}" method="post">
                                @csrf
                                <div class="variants_selects">
                                    @if ($value->kieu_san_pham == 2)
                                    @foreach ($result[$value->id] as $keyBienThe => $valueBienThes)
                                    <div class="variants_size">
                                        <h2>{{$keyBienThe}}</h2><span class="text-danger" id="{{'error-'.$keyBienThe.'-ban-chay-'.$value->id}}"></span>
                                        <input type="hidden" name="atrributes[]" value="{{$keyBienThe}}">
                                        <select id="{{$keyBienThe.'-ban-chay-'.$value->id}}" class="select_option" name="values[]">
                                            <option value="0">Chọn một tùy chọn</option>
                                            @foreach ($valueBienThes as $valueBienThe)
                                           <option value="{{ $valueBienThe }}">{{ $valueBienThe }}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                    @php
                                        echo '<script>
                                                document.getElementById("add-to-cart-form-ban-chay-'.$value->id.'").addEventListener("submit", function(event) {
                                                if('.Auth::id().'){
                                                        var isValid = true;
                                                        if (document.getElementById("'.$keyBienThe.'-ban-chay-'.$value->id.'").value === "0") {
                                                            isValid = false;
                                                        }
                                                    if (!isValid) {
                                                        document.getElementById("error-'.$keyBienThe.'-ban-chay-'.$value->id.'").innerHTML = "Vui lòng chọn thuộc tính <span>'.$keyBienThe.'</span>";
                                                        document.getElementById("error-'.$keyBienThe.'-ban-chay-'.$value->id.'").previousElementSibling.classList.add("mb-0");
                                                        event.preventDefault();
                                                    }else{
                                                        document.getElementById("error-'.$keyBienThe.'-ban-chay-'.$value->id.'").innerHTML = "";
                                                    }
                                                }
                                                });
                                            </script>';
                                    @endphp
                                    @endforeach
                                    @endif
                                    <div class="modal_add_to_cart modal_add_to_cart_custom">
                                        @if($value->kieu_san_pham == 1)
                                        <label class="me-2">Số lượng</label>
                                        @endif
                                        <input id="so-luong-ban-chay-{{$value->id}}" min="1" max="50" name="quantity" value="1" type="number">
                                        <span id="error-so-luong-ban-chay-{{$value->id}}" class="text-danger"></span>
                                        @if($value->kieu_san_pham == 1)<br />@endif
                                        <button {{(($value->so_luong == 0 && $value->kieu_san_pham == 1) || ($value->sum_so_luong == 0 && $value->kieu_san_pham == 2)) ? "disabled" : ""}} class="{{$value->kieu_san_pham == 1 ? 'ms-0 mt-3' : ''}}" type="{{(($value->so_luong == 0 && $value->kieu_san_pham == 1) || ($value->sum_so_luong == 0 && $value->kieu_san_pham == 2)) ? "button" : "submit"}}" style="cursor: {{(($value->so_luong == 0 && $value->kieu_san_pham == 1) || ($value->sum_so_luong == 0 && $value->kieu_san_pham == 2)) ? 'not-allowed' : 'pointer'}}">{{(($value->so_luong == 0 && $value->kieu_san_pham == 1) || ($value->sum_so_luong == 0 && $value->kieu_san_pham == 2)) ? "hết hàng" : "thêm vào giỏ hàng"}}</button>
                                        <p id="error-bien-the-so-luong-ban-chay-{{$value->id}}" class="text-danger mb-0"></p>
                                    </div>
                                </div> 
                            </form>
                            @php
                                echo '<script>
                                        document.getElementById("add-to-cart-form-ban-chay-'.$value->id.'").addEventListener("submit", function(event) {
                                        if('.Auth::id().'){
                                            var isValid = true;
                                            var soLuongBanChay'.$value->id.' = document.getElementById("so-luong-ban-chay-'.$value->id.'");
                                            var errorSoLuongBanChay'.$value->id.' = document.getElementById("error-so-luong-ban-chay-'.$value->id.'");
                                            var errorBienTheSoLuongBanChay'.$value->id.' = document.getElementById("error-bien-the-so-luong-ban-chay-'.$value->id.'");
                                            if (soLuongBanChay'.$value->id.'.value === "") {
                                                    var text = "Vui lòng nhập số lượng";
                                                    isValid = false;
                                            }
                                            else if (isNaN(soLuongBanChay'.$value->id.'.value)) {
                                                    var text = "Số lượng phải là số";
                                                    isValid = false;
                                            }
                                            else if (soLuongBanChay'.$value->id.'.value % 1 != 0) {
                                                    var text = "Số lượng phải là số nguyên";
                                                    isValid = false;
                                            }
                                            else if (soLuongBanChay'.$value->id.'.value <= 0) {
                                                    var text = "Số lượng phải lớn hơn 0";
                                                    isValid = false;
                                            }else if (soLuongBanChay'.$value->id.'.value > 50){
                                                    var text = "Số lượng phải nhỏ hơn 50";
                                                    isValid = false;
                                            }
                                            if (!isValid) {
                                            if('.$value->kieu_san_pham.' == 1){
                                                errorSoLuongBanChay'.$value->id.'.innerHTML = "<br/>" + text;
                                            }else{
                                                errorBienTheSoLuongBanChay'.$value->id.'.innerHTML = text;
                                                errorBienTheSoLuongBanChay'.$value->id.'.style.marginTop = "2px";
                                            }    
                                                event.preventDefault();
                                            }else{
                                            if('.$value->kieu_san_pham.' == 1){
                                                errorSoLuongBanChay'.$value->id.'.innerHTML = "";
                                            }else{
                                                errorBienTheSoLuongBanChay'.$value->id.'.innerHTML = "";
                                                errorBienTheSoLuongBanChay'.$value->id.'.style.marginTop = "0";
                                            }
                                            }
                                        }
                                        });
                                    </script>';
                            @endphp
                            @if ($value->kieu_san_pham == 2)
                            <div class="row" style="row-gap: 10px">
                                @foreach ($sanPhamBienTheBanChayShow as $keyBienTheBanChayShow => $valueBienTheBanChayShow)
                                @if ($value->id == $valueBienTheBanChayShow->id)
                                <div class="col-6 col-sm-4 col-md-6 col-lg-4 d-flex align-items-center">
                                    <img src="{{$valueBienTheBanChayShow->anh_bien_the_san_pham === NULL ? '.'.Storage::url($value->anh_san_pham) : '.'.Storage::url($valueBienTheBanChayShow->anh_bien_the_san_pham)}}" class="me-1" style="width: 40px; aspect-ratio: 1/1; object-fit: cover" alt="Ảnh biến thể">
                                    <div style="font-size: 10px; display: flex; flex-direction: column">
                                        <span style="line-height: normal; margin-bottom: 2px; color: #0063d1; font-weight: 500; font-size: 11px" title="">{{$valueBienTheBanChayShow->ten_gia_tri_thuoc_tinh_bt}}</span>
                                        <span style="line-height: normal; margin-bottom: 2px" title="">{{number_format($valueBienTheBanChayShow->gia, 0, '', '.')}} vnđ</span>
                                        <span style="line-height: normal" title="">Còn: {{$valueBienTheBanChayShow->so_luong}}</span>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            @else
                            <div class="modal_social">
                                <h2>Chia sẻ sản phẩm</h2>
                                <ul>
                                    <li class="facebook"><a href="javasript:void(0)"><i class="fa fa-facebook"></i></a></li>
                                    <li class="twitter"><a href="javasript:void(0)"><i class="fa fa-twitter"></i></a></li>
                                    <li class="pinterest"><a href="javasript:void(0)"><i class="fa fa-pinterest"></i></a></li>
                                    <li class="google-plus"><a href="javasript:void(0)"><i class="fa fa-google-plus"></i></a>
                                    </li>
                                    <li class="linkedin"><a href="javasript:void(0)"><i class="fa fa-linkedin"></i></a></li>
                                </ul>
                            </div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $daBan = DB::table("san_phams")
                ->leftJoin('bien_the_san_phams', 'san_phams.id', '=', 'bien_the_san_phams.san_pham_id')
                ->leftJoin('chi_tiet_don_hangs', function($join) {
                    $join->on('chi_tiet_don_hangs.san_pham_id', '=', 'san_phams.id')
                        ->orOn('chi_tiet_don_hangs.bien_the_san_pham_id', '=', 'bien_the_san_phams.id');
                })
                ->where('san_phams.id', $value->id)
                ->sum('chi_tiet_don_hangs.so_luong');
            @endphp
            <div style="font-size: 12px; z-index: 100; position: absolute; bottom: 0; right: 0; border-top-left-radius: 2px; padding: 2px 6px" class="text-white bg-danger">Đã bán
            {{$daBan}}
            </div>
        </div>
    </div>
</div>
@endforeach
@foreach ($sanPhamNoiBat as $key => $value)
<div class="modal fade" id="modal_box_noi_bat_{{$value->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal_body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12">
                            <div class="modal_tab">
                                <div class="tab-content product-details-large">
                                    <div class="tab-pane fade show active" id="tab_main_noi_bat_{{$value->id}}" role="tabpanel">
                                        <div class="modal_tab_img" style="position: relative">
                                            <a href="{{route('client.show', $value->id)}}" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                <div>
                                                    <img src="{{'.'.Storage::url($value->anh_san_pham)}}" class="w-100" alt="">
                                                </div>                                            
                                            </a>
                                            <div style="font-size: 12px; z-index: 100; position: absolute; top: 0; left: 0; background-color: #0063d1; border-bottom-right-radius: 2px; padding: 2px 6px" class="text-white">Còn 
                                                @if($value->kieu_san_pham == 2)
                                                {{$value->sum_so_luong}}
                                                @else
                                                {{$value->so_luong}}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($albumAnhSanPhamNoiBat as $keyAlbum => $valueAlbum)
                                        @if($valueAlbum->id_san_pham == $value->id && $valueAlbum->duong_dan_anh !== NULL)
                                        <div class="tab-pane fade" id="tab_noi_bat_{{$valueAlbum->id_album}}" role="tabpanel">
                                            <div class="modal_tab_img">
                                                <a href="{{route('client.show', $value->id)}}" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                    <div><img src="{{'.'.Storage::url($valueAlbum->duong_dan_anh)}}" class="w-100" alt=""></div>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                    @foreach ($albumAnhBienTheNoiBat as $keyAlbumBienThe => $valueAlbumBienThe)
                                        @if($valueAlbumBienThe->id_san_pham == $value->id && $valueAlbumBienThe->anh_bien_the_san_pham !== NULL)
                                        <div class="tab-pane fade" id="tab_noi_bat_bien_the_{{$valueAlbumBienThe->id_bien_the}}" role="tabpanel">
                                            <div class="modal_tab_img">
                                                <a href="{{route('client.show', $value->id)}}" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                    <div><img src="{{'.'.Storage::url($valueAlbumBienThe->anh_bien_the_san_pham)}}" class="w-100" alt=""></div>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="modal_tab_button">
                                    <ul class="nav product_navactive owl-carousel" role="tablist">
                                        <li>
                                            <a class="nav-link active" data-bs-toggle="tab" href="#tab_main_noi_bat_{{$value->id}}" role="tab"
                                                aria-controls="tab_main_noi_bat_{{$value->id}}" aria-selected="false" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                            <div><img src="{{'.'.Storage::url($value->anh_san_pham)}}" class="w-100" alt=""></div>
                                            </a>
                                        </li>
                                        @foreach ($albumAnhSanPhamNoiBat as $keyAlbum => $valueAlbum)
                                        @if($valueAlbum->id_san_pham == $value->id && $valueAlbum->duong_dan_anh !== NULL)
                                        <li>
                                            <a class="nav-link" data-bs-toggle="tab" href="#tab_noi_bat_{{$valueAlbum->id_album}}" role="tab"
                                                aria-controls="tab_noi_bat_{{$valueAlbum->id_album}}" aria-selected="false" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                <div><img src="{{'.'.Storage::url($valueAlbum->duong_dan_anh)}}" class="w-100" alt=""></div>
                                            </a>
                                        </li>
                                        @endif
                                        @endforeach
                                        @foreach ($albumAnhBienTheNoiBat as $keyAlbumBienThe => $valueAlbumBienThe)
                                        @if($valueAlbumBienThe->id_san_pham == $value->id && $valueAlbumBienThe->anh_bien_the_san_pham !== NULL)
                                        <li>
                                            <a class="nav-link" data-bs-toggle="tab" href="#tab_noi_bat_bien_the_{{$valueAlbumBienThe->id_bien_the}}" role="tab"
                                                aria-controls="tab_noi_bat_bien_the_{{$valueAlbumBienThe->id_bien_the}}" aria-selected="false" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                <div><img src="{{'.'.Storage::url($valueAlbumBienThe->anh_bien_the_san_pham)}}" class="w-100" alt=""></div>
                                            </a>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12">
                            <div class="modal_right">
                                <div class="modal_title mb-10">
                                    <h2>{{$value->ten_san_pham}}</h2>
                                </div>
                                <div class="modal_price mb-10">
                                @if ($value->gia_khuyen_mai != NULL)
                                <span class="old_price" style="margin-left: 0; margin-right: 5px">{{number_format($value->gia, 0, '', '.')}} vnđ</span>
                                <span class="new_price">{{number_format($value->gia_khuyen_mai, 0, '', '.')}} vnđ</span>
                                @elseif($value->kieu_san_pham == 2)
                                <span class="new_price">{{number_format($value->gia_min, 0, '', '.')}} vnđ - {{number_format($value->gia_max, 0, '', '.')}} vnđ</span>
                                @else
                                <span class="new_price">{{number_format($value->gia, 0, '', '.')}} vnđ</span>
                                @endif
                                </div>
                                <div class="modal_description mb-15">
                                    {!!$value->mo_ta_ngan!!}
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
                                <form id="add-to-cart-form-noi-bat-{{$value->id}}" action="{{route('client.addtocart', $value->id)}}" method="post">
                                @csrf
                                <div class="variants_selects">
                                    @if ($value->kieu_san_pham == 2)
                                    @foreach ($resultNoiBat[$value->id] as $keyBienThe => $valueBienThes)
                                    <div class="variants_size">
                                        <h2>{{$keyBienThe}}</h2><span class="text-danger" id="{{'error-'.$keyBienThe.'-noi-bat-'.$value->id}}"></span>
                                        <input type="hidden" name="atrributes[]" value="{{$keyBienThe}}">
                                        <select id="{{$keyBienThe.'-noi-bat-'.$value->id}}" class="select_option" name="values[]">
                                            <option value="0">Chọn một tùy chọn</option>
                                            @foreach ($valueBienThes as $valueBienThe)
                                           <option value="{{ $valueBienThe }}">{{ $valueBienThe }}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                    @php
                                        echo '<script>
                                                document.getElementById("add-to-cart-form-noi-bat-'.$value->id.'").addEventListener("submit", function(event) {
                                                if('.Auth::id().'){
                                                        var isValid = true;
                                                        if (document.getElementById("'.$keyBienThe.'-noi-bat-'.$value->id.'").value === "0") {
                                                            isValid = false;
                                                        }
                                                    if (!isValid) {
                                                        document.getElementById("error-'.$keyBienThe.'-noi-bat-'.$value->id.'").innerHTML = "Vui lòng chọn thuộc tính <span>'.$keyBienThe.'</span>";
                                                        document.getElementById("error-'.$keyBienThe.'-noi-bat-'.$value->id.'").previousElementSibling.classList.add("mb-0");
                                                        event.preventDefault();
                                                    }else{
                                                        document.getElementById("error-'.$keyBienThe.'-noi-bat-'.$value->id.'").innerHTML = "";
                                                    }
                                                }
                                                });
                                            </script>';
                                    @endphp
                                    @endforeach
                                    @endif
                                    <div class="modal_add_to_cart modal_add_to_cart_custom">
                                        @if($value->kieu_san_pham == 1)
                                        <label class="me-2">Số lượng</label>
                                        @endif
                                        <input id="so-luong-noi-bat-{{$value->id}}" min="1" max="50" name="quantity" value="1" type="number">
                                        <span id="error-so-luong-noi-bat-{{$value->id}}" class="text-danger"></span>
                                        @if($value->kieu_san_pham == 1)<br />@endif
                                        <button {{(($value->so_luong == 0 && $value->kieu_san_pham == 1) || ($value->sum_so_luong == 0 && $value->kieu_san_pham == 2)) ? "disabled" : ""}} class="{{$value->kieu_san_pham == 1 ? 'ms-0 mt-3' : ''}}" type="{{(($value->so_luong == 0 && $value->kieu_san_pham == 1) || ($value->sum_so_luong == 0 && $value->kieu_san_pham == 2)) ? "button" : "submit"}}" style="cursor: {{(($value->so_luong == 0 && $value->kieu_san_pham == 1) || ($value->sum_so_luong == 0 && $value->kieu_san_pham == 2)) ? 'not-allowed' : 'pointer'}}">{{(($value->so_luong == 0 && $value->kieu_san_pham == 1) || ($value->sum_so_luong == 0 && $value->kieu_san_pham == 2)) ? "hết hàng" : "thêm vào giỏ hàng"}}</button>
                                        <p id="error-bien-the-so-luong-noi-bat-{{$value->id}}" class="text-danger mb-0"></p>
                                    </div>
                                </div> 
                            </form>
                            @php
                                echo '<script>
                                        document.getElementById("add-to-cart-form-noi-bat-'.$value->id.'").addEventListener("submit", function(event) {
                                        if('.Auth::id().'){
                                            var isValid = true;
                                            var soLuongNoiBat'.$value->id.' = document.getElementById("so-luong-noi-bat-'.$value->id.'");
                                            var errorSoLuongNoiBat'.$value->id.' = document.getElementById("error-so-luong-noi-bat-'.$value->id.'");
                                            var errorBienTheSoLuongNoiBat'.$value->id.' = document.getElementById("error-bien-the-so-luong-noi-bat-'.$value->id.'");
                                            if (soLuongNoiBat'.$value->id.'.value === "") {
                                                    var text = "Vui lòng nhập số lượng";
                                                    isValid = false;
                                            }
                                            else if (isNaN(soLuongNoiBat'.$value->id.'.value)) {
                                                    var text = "Số lượng phải là số";
                                                    isValid = false;
                                            }
                                            else if (soLuongNoiBat'.$value->id.'.value % 1 != 0) {
                                                    var text = "Số lượng phải là số nguyên";
                                                    isValid = false;
                                            }
                                            else if (soLuongNoiBat'.$value->id.'.value <= 0) {
                                                    var text = "Số lượng phải lớn hơn 0";
                                                    isValid = false;
                                            }else if (soLuongNoiBat'.$value->id.'.value > 50){
                                                    var text = "Số lượng phải nhỏ hơn 50";
                                                    isValid = false;
                                            }
                                            if (!isValid) {
                                            if('.$value->kieu_san_pham.' == 1){
                                                errorSoLuongNoiBat'.$value->id.'.innerHTML = "<br/>" + text;
                                            }else{
                                                errorBienTheSoLuongNoiBat'.$value->id.'.innerHTML = text;
                                                errorBienTheSoLuongNoiBat'.$value->id.'.style.marginTop = "2px";
                                            }    
                                                event.preventDefault();
                                            }else{
                                            if('.$value->kieu_san_pham.' == 1){
                                                errorSoLuongNoiBat'.$value->id.'.innerHTML = "";
                                            }else{
                                                errorBienTheSoLuongNoiBat'.$value->id.'.innerHTML = "";
                                                errorBienTheSoLuongNoiBat'.$value->id.'.style.marginTop = "0";
                                            }
                                            }
                                        }
                                        });
                                    </script>';
                            @endphp
                            @if ($value->kieu_san_pham == 2)
                            <div class="row" style="row-gap: 10px">
                                @foreach ($sanPhamBienTheNoiBatShow as $keyBienTheNoiBatShow => $valueBienTheNoiBatShow)
                                @if ($value->id == $valueBienTheNoiBatShow->id)
                                <div class="col-6 col-sm-4 col-md-6 col-lg-4 d-flex align-items-center">
                                    <img src="{{$valueBienTheNoiBatShow->anh_bien_the_san_pham === NULL ? '.'.Storage::url($value->anh_san_pham) : '.'.Storage::url($valueBienTheNoiBatShow->anh_bien_the_san_pham)}}" class="me-1" style="width: 40px; aspect-ratio: 1/1; object-fit: cover" alt="Ảnh biến thể">
                                    <div style="font-size: 10px; display: flex; flex-direction: column">
                                        <span style="line-height: normal; margin-bottom: 2px; color: #0063d1; font-weight: 500; font-size: 11px" title="">{{$valueBienTheNoiBatShow->ten_gia_tri_thuoc_tinh_bt}}</span>
                                        <span style="line-height: normal; margin-bottom: 2px" title="">{{number_format($valueBienTheNoiBatShow->gia, 0, '', '.')}} vnđ</span>
                                        <span style="line-height: normal" title="">Còn: {{$valueBienTheNoiBatShow->so_luong}}</span>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            @else
                            <div class="modal_social">
                                <h2>Chia sẻ sản phẩm</h2>
                                <ul>
                                    <li class="facebook"><a href="javasript:void(0)"><i class="fa fa-facebook"></i></a></li>
                                    <li class="twitter"><a href="javasript:void(0)"><i class="fa fa-twitter"></i></a></li>
                                    <li class="pinterest"><a href="javasript:void(0)"><i class="fa fa-pinterest"></i></a></li>
                                    <li class="google-plus"><a href="javasript:void(0)"><i class="fa fa-google-plus"></i></a>
                                    </li>
                                    <li class="linkedin"><a href="javasript:void(0)"><i class="fa fa-linkedin"></i></a></li>
                                </ul>
                            </div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $daBan = DB::table("san_phams")
                ->leftJoin('bien_the_san_phams', 'san_phams.id', '=', 'bien_the_san_phams.san_pham_id')
                ->leftJoin('chi_tiet_don_hangs', function($join) {
                    $join->on('chi_tiet_don_hangs.san_pham_id', '=', 'san_phams.id')
                        ->orOn('chi_tiet_don_hangs.bien_the_san_pham_id', '=', 'bien_the_san_phams.id');
                })
                ->where('san_phams.id', $value->id)
                ->sum('chi_tiet_don_hangs.so_luong');
            @endphp
            <div style="font-size: 12px; z-index: 100; position: absolute; bottom: 0; right: 0; border-top-left-radius: 2px; padding: 2px 6px" class="text-white bg-danger">Đã bán
            {{$daBan}}
            </div>
        </div>
    </div>
</div>
@endforeach
@foreach ($sanPhamDanhGiaTot as $key => $value)
<div class="modal fade" id="modal_box_danh_gia_tot_{{$value->id}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal_body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12">
                            <div class="modal_tab">
                                <div class="tab-content product-details-large">
                                    <div class="tab-pane fade show active" id="tab_main_danh_gia_tot_{{$value->id}}" role="tabpanel">
                                        <div class="modal_tab_img" style="position: relative">
                                            <a href="{{route('client.show', $value->id)}}" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                <div>
                                                    <img src="{{'.'.Storage::url($value->anh_san_pham)}}" class="w-100" alt="">
                                                </div>                                            
                                            </a>
                                            <div style="font-size: 12px; z-index: 100; position: absolute; top: 0; left: 0; background-color: #0063d1; border-bottom-right-radius: 2px; padding: 2px 6px" class="text-white">Còn 
                                                @if($value->kieu_san_pham == 2)
                                                {{$value->sum_so_luong}}
                                                @else
                                                {{$value->so_luong}}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($albumAnhSanPhamDanhGiaTot as $keyAlbum => $valueAlbum)
                                        @if($valueAlbum->id_san_pham == $value->id && $valueAlbum->duong_dan_anh !== NULL)
                                        <div class="tab-pane fade" id="tab_danh_gia_tot_{{$valueAlbum->id_album}}" role="tabpanel">
                                            <div class="modal_tab_img">
                                                <a href="{{route('client.show', $value->id)}}" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                    <div><img src="{{'.'.Storage::url($valueAlbum->duong_dan_anh)}}" class="w-100" alt=""></div>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                    @foreach ($albumAnhBienTheDanhGiaTot as $keyAlbumBienThe => $valueAlbumBienThe)
                                        @if($valueAlbumBienThe->id_san_pham == $value->id && $valueAlbumBienThe->anh_bien_the_san_pham !== NULL)
                                        <div class="tab-pane fade" id="tab_danh_gia_tot_bien_the_{{$valueAlbumBienThe->id_bien_the}}" role="tabpanel">
                                            <div class="modal_tab_img">
                                                <a href="{{route('client.show', $value->id)}}" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                    <div><img src="{{'.'.Storage::url($valueAlbumBienThe->anh_bien_the_san_pham)}}" class="w-100" alt=""></div>
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="modal_tab_button">
                                    <ul class="nav product_navactive owl-carousel" role="tablist">
                                        <li>
                                            <a class="nav-link active" data-bs-toggle="tab" href="#tab_main_danh_gia_tot_{{$value->id}}" role="tab"
                                                aria-controls="tab_main_danh_gia_tot_{{$value->id}}" aria-selected="false" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                            <div><img src="{{'.'.Storage::url($value->anh_san_pham)}}" class="w-100" alt=""></div>
                                            </a>
                                        </li>
                                        @foreach ($albumAnhSanPhamDanhGiaTot as $keyAlbum => $valueAlbum)
                                        @if($valueAlbum->id_san_pham == $value->id && $valueAlbum->duong_dan_anh !== NULL)
                                        <li>
                                            <a class="nav-link" data-bs-toggle="tab" href="#tab_danh_gia_tot_{{$valueAlbum->id_album}}" role="tab"
                                                aria-controls="tab_danh_gia_tot_{{$valueAlbum->id_album}}" aria-selected="false" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                <div><img src="{{'.'.Storage::url($valueAlbum->duong_dan_anh)}}" class="w-100" alt=""></div>
                                            </a>
                                        </li>
                                        @endif
                                        @endforeach
                                        @foreach ($albumAnhBienTheDanhGiaTot as $keyAlbumBienThe => $valueAlbumBienThe)
                                        @if($valueAlbumBienThe->id_san_pham == $value->id && $valueAlbumBienThe->anh_bien_the_san_pham !== NULL)
                                        <li>
                                            <a class="nav-link" data-bs-toggle="tab" href="#tab_danh_gia_tot_bien_the_{{$valueAlbumBienThe->id_bien_the}}" role="tab"
                                                aria-controls="tab_danh_gia_tot_bien_the_{{$valueAlbumBienThe->id_bien_the}}" aria-selected="false" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden">
                                                <div><img src="{{'.'.Storage::url($valueAlbumBienThe->anh_bien_the_san_pham)}}" class="w-100" alt=""></div>
                                            </a>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12">
                            <div class="modal_right">
                                <div class="modal_title mb-10">
                                    <h2>{{$value->ten_san_pham}}</h2>
                                </div>
                                <div class="modal_price mb-10">
                                    @if ($value->gia_khuyen_mai != NULL)
                                    <span class="old_price" style="margin-left: 0; margin-right: 5px">{{number_format($value->gia, 0, '', '.')}} vnđ</span>
                                    <span class="new_price">{{number_format($value->gia_khuyen_mai, 0, '', '.')}} vnđ</span>
                                    @elseif($value->kieu_san_pham == 2)
                                    <span class="new_price">{{number_format($value->gia_min, 0, '', '.')}} vnđ - {{number_format($value->gia_max, 0, '', '.')}} vnđ</span>
                                    @else
                                    <span class="new_price">{{number_format($value->gia, 0, '', '.')}} vnđ</span>
                                    @endif
                                </div>
                                <div class="modal_description mb-15">
                                    {!!$value->mo_ta_ngan!!}
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
                                <form id="add-to-cart-form-danh-gia-tot-{{$value->id}}" action="{{route('client.addtocart', $value->id)}}" method="post">
                                @csrf
                                <div class="variants_selects">
                                    @if ($value->kieu_san_pham == 2)
                                    @foreach ($resultDanhGiaTot[$value->id] as $keyBienThe => $valueBienThes)
                                    <div class="variants_size">
                                        <h2>{{$keyBienThe}}</h2><span class="text-danger" id="{{'error-'.$keyBienThe.'-danh-gia-tot-'.$value->id}}"></span>
                                        <input type="hidden" name="atrributes[]" value="{{$keyBienThe}}">
                                        <select id="{{$keyBienThe.'-danh-gia-tot-'.$value->id}}" class="select_option" name="values[]">
                                            <option value="0">Chọn một tùy chọn</option>
                                            @foreach ($valueBienThes as $valueBienThe)
                                           <option value="{{ $valueBienThe }}">{{ $valueBienThe }}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                    @php
                                        echo '<script>
                                                document.getElementById("add-to-cart-form-danh-gia-tot-'.$value->id.'").addEventListener("submit", function(event) {
                                                if('.Auth::id().'){
                                                        var isValid = true;
                                                        if (document.getElementById("'.$keyBienThe.'-danh-gia-tot-'.$value->id.'").value === "0") {
                                                            isValid = false;
                                                        }
                                                    if (!isValid) {
                                                        document.getElementById("error-'.$keyBienThe.'-danh-gia-tot-'.$value->id.'").innerHTML = "Vui lòng chọn thuộc tính <span>'.$keyBienThe.'</span>";
                                                        document.getElementById("error-'.$keyBienThe.'-danh-gia-tot-'.$value->id.'").previousElementSibling.classList.add("mb-0");
                                                        event.preventDefault();
                                                    }else{
                                                        document.getElementById("error-'.$keyBienThe.'-danh-gia-tot-'.$value->id.'").innerHTML = "";
                                                    }
                                                }
                                                });
                                            </script>';
                                    @endphp
                                    @endforeach
                                    @endif
                                    <div class="modal_add_to_cart modal_add_to_cart_custom">
                                        @if($value->kieu_san_pham == 1)
                                        <label class="me-2">Số lượng</label>
                                        @endif
                                        <input id="so-luong-danh-gia-tot-{{$value->id}}" min="1" max="50" name="quantity" value="1" type="number">
                                        <span id="error-so-luong-danh-gia-tot-{{$value->id}}" class="text-danger"></span>
                                        @if($value->kieu_san_pham == 1)<br />@endif
                                        <button {{(($value->so_luong == 0 && $value->kieu_san_pham == 1) || ($value->sum_so_luong == 0 && $value->kieu_san_pham == 2)) ? "disabled" : ""}} class="{{$value->kieu_san_pham == 1 ? 'ms-0 mt-3' : ''}}" type="{{(($value->so_luong == 0 && $value->kieu_san_pham == 1) || ($value->sum_so_luong == 0 && $value->kieu_san_pham == 2)) ? "button" : "submit"}}" style="cursor: {{(($value->so_luong == 0 && $value->kieu_san_pham == 1) || ($value->sum_so_luong == 0 && $value->kieu_san_pham == 2)) ? 'not-allowed' : 'pointer'}}">{{(($value->so_luong == 0 && $value->kieu_san_pham == 1) || ($value->sum_so_luong == 0 && $value->kieu_san_pham == 2)) ? "hết hàng" : "thêm vào giỏ hàng"}}</button>
                                        <p id="error-bien-the-so-luong-danh-gia-tot-{{$value->id}}" class="text-danger mb-0"></p>
                                    </div>
                                </div> 
                            </form>
                            @php
                                echo '<script>
                                        document.getElementById("add-to-cart-form-danh-gia-tot-'.$value->id.'").addEventListener("submit", function(event) {
                                        if('.Auth::id().'){
                                            var isValid = true;
                                            var soLuongDanhGiaTot'.$value->id.' = document.getElementById("so-luong-danh-gia-tot-'.$value->id.'");
                                            var errorSoLuongDanhGiaTot'.$value->id.' = document.getElementById("error-so-luong-danh-gia-tot-'.$value->id.'");
                                            var errorBienTheSoLuongDanhGiaTot'.$value->id.' = document.getElementById("error-bien-the-so-luong-danh-gia-tot-'.$value->id.'");
                                            if (soLuongDanhGiaTot'.$value->id.'.value === "") {
                                                    var text = "Vui lòng nhập số lượng";
                                                    isValid = false;
                                            }
                                            else if (isNaN(soLuongDanhGiaTot'.$value->id.'.value)) {
                                                    var text = "Số lượng phải là số";
                                                    isValid = false;
                                            }
                                            else if (soLuongDanhGiaTot'.$value->id.'.value % 1 != 0) {
                                                    var text = "Số lượng phải là số nguyên";
                                                    isValid = false;
                                            }
                                            else if (soLuongDanhGiaTot'.$value->id.'.value <= 0) {
                                                    var text = "Số lượng phải lớn hơn 0";
                                                    isValid = false;
                                            }else if (soLuongDanhGiaTot'.$value->id.'.value > 50){
                                                    var text = "Số lượng phải nhỏ hơn 50";
                                                    isValid = false;
                                            }
                                            if (!isValid) {
                                            if('.$value->kieu_san_pham.' == 1){
                                                errorSoLuongDanhGiaTot'.$value->id.'.innerHTML = "<br/>" + text;
                                            }else{
                                                errorBienTheSoLuongDanhGiaTot'.$value->id.'.innerHTML = text;
                                                errorBienTheSoLuongDanhGiaTot'.$value->id.'.style.marginTop = "2px";
                                            }    
                                                event.preventDefault();
                                            }else{
                                            if('.$value->kieu_san_pham.' == 1){
                                                errorSoLuongDanhGiaTot'.$value->id.'.innerHTML = "";
                                            }else{
                                                errorBienTheSoLuongDanhGiaTot'.$value->id.'.innerHTML = "";
                                                errorBienTheSoLuongDanhGiaTot'.$value->id.'.style.marginTop = "0";
                                            }
                                            }
                                        }
                                        });
                                    </script>';
                            @endphp
                            @if ($value->kieu_san_pham == 2)
                            <div class="row" style="row-gap: 10px">
                                @foreach ($sanPhamBienTheDanhGiaTotShow as $keyBienTheDanhGiaTotShow => $valueBienTheDanhGiaTotShow)
                                @if ($value->id == $valueBienTheDanhGiaTotShow->id)
                                <div class="col-6 col-sm-4 col-md-6 col-lg-4 d-flex align-items-center">
                                    <img src="{{$valueBienTheDanhGiaTotShow->anh_bien_the_san_pham === NULL ? '.'.Storage::url($value->anh_san_pham) : '.'.Storage::url($valueBienTheDanhGiaTotShow->anh_bien_the_san_pham)}}" class="me-1" style="width: 40px; aspect-ratio: 1/1; object-fit: cover" alt="Ảnh biến thể">
                                    <div style="font-size: 10px; display: flex; flex-direction: column">
                                        <span style="line-height: normal; margin-bottom: 2px; color: #0063d1; font-weight: 500; font-size: 11px" title="">{{$valueBienTheDanhGiaTotShow->ten_gia_tri_thuoc_tinh_bt}}</span>
                                        <span style="line-height: normal; margin-bottom: 2px" title="">{{number_format($valueBienTheDanhGiaTotShow->gia, 0, '', '.')}} vnđ</span>
                                        <span style="line-height: normal" title="">Còn: {{$valueBienTheDanhGiaTotShow->so_luong}}</span>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            @else
                            <div class="modal_social">
                                <h2>Chia sẻ sản phẩm</h2>
                                <ul>
                                    <li class="facebook"><a href="javasript:void(0)"><i class="fa fa-facebook"></i></a></li>
                                    <li class="twitter"><a href="javasript:void(0)"><i class="fa fa-twitter"></i></a></li>
                                    <li class="pinterest"><a href="javasript:void(0)"><i class="fa fa-pinterest"></i></a></li>
                                    <li class="google-plus"><a href="javasript:void(0)"><i class="fa fa-google-plus"></i></a>
                                    </li>
                                    <li class="linkedin"><a href="javasript:void(0)"><i class="fa fa-linkedin"></i></a></li>
                                </ul>
                            </div>
                            @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $daBan = DB::table("san_phams")
                ->leftJoin('bien_the_san_phams', 'san_phams.id', '=', 'bien_the_san_phams.san_pham_id')
                ->leftJoin('chi_tiet_don_hangs', function($join) {
                    $join->on('chi_tiet_don_hangs.san_pham_id', '=', 'san_phams.id')
                        ->orOn('chi_tiet_don_hangs.bien_the_san_pham_id', '=', 'bien_the_san_phams.id');
                })
                ->where('san_phams.id', $value->id)
                ->sum('chi_tiet_don_hangs.so_luong');
            @endphp
            <div style="font-size: 12px; z-index: 100; position: absolute; bottom: 0; right: 0; border-top-left-radius: 2px; padding: 2px 6px" class="text-white bg-danger">Đã bán
            {{$daBan}}
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- modal area end-->
