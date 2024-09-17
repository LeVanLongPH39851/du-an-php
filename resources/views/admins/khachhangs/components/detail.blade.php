<div class="row m-b-lg m-t-lg">
                <div class="col-md-6">

                    <div class="profile-image">
                        <img src="{{$khachHangShow->anh_dai_dien === NULL ? "./storage/uploads/khachhang/avatar.png" : ".".Storage::url($khachHangShow->anh_dai_dien)}}" class="img-circle circle-border m-b-md" alt="profile">
                    </div>
                    <div class="profile-info">
                        <div class="">
                            <div>
                                <h2 class="no-margins">
                                    {{$khachHangShow->name}}
                                </h2>
                                <i class="fa fa-address-book"></i> <h5 style="display: inline-block; margin-bottom: 0">{{$khachHangShow->ma_khach_hang}}</h5> <br>
                                <small>
                                    <i class="fa fa-phone-square"></i> {{$khachHangShow->so_dien_thoai===NULL ? 'chưa cập nhật' : $khachHangShow->so_dien_thoai}}
                                </small><br>
                                <small>
                                    <i class="fa fa-envelope-square"></i> {{$khachHangShow->email}}
                                </small><br>
                                <small>
                                    <i class="fa fa-map-marker"></i> {{$khachHangShow->dia_chi===NULL ? 'khách hàng chưa thêm địa chỉ' : $khachHangShow->dia_chi}}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <table class="table small m-b-xs">
                        <tbody>
                        <tr>
                            <td>
                                <strong>{{$khachHangShowOther[0]->so_don_hang}}</strong> Đơn hàng
                            </td>
                            <td>
                                <strong>{{$soLuongSanPham[0]->so_luong == NULL ? 0 : $soLuongSanPham[0]->so_luong}}</strong> Sản phẩm
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <strong>{{$khachHangComentReview[0]->binh_luans_count}}</strong> Bình luận
                            </td>
                            <td>
                                Đã chi <strong>{{$khachHangShowOther[0]->tong_tien_tat_ca_don_hang===null ? 0 : number_format($khachHangShowOther[0]->tong_tien_tat_ca_don_hang, 0, '', '.')}}đ</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>{{$khachHangComentReview[0]->danh_gias_count}}</strong> Đánh giá
                            </td>
                            <td>
                                Hạng: <strong>{{$userRank['rank']}}</strong>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-3">
                    <table class="table small m-b-xs">
                        <tbody>
                        <tr>
                <td>
                    <i class="fa fa-group"></i> | <i class="fa fa-address-book-o"></i> | <i class="fa fa-address-card"></i>
                </td>
                <td><i class="fa fa-cc-discover"></i> | <i class="fa fa-cc-visa"></i> | <i class="fa fa-cc-paypal"></i> | <i class="fa fa-cc-stripe"></i> | <i class="fa fa-cc-mastercard"></i></td>
                        </tr>
                        <tr>
                            <td>
                               Vai trò: <strong>{{$khachHangShow->vai_tro===1 ? 'user' : 'admin'}}</strong>
                            </td>
                            <td>
                                Ngày tham gia: <strong>{{date('d/m/Y', strtotime($khachHangShow->ngay_tao))}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span><i class="fa fa-circle text-navy"></i> Hoạt động</span>          
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-3">

                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>Thông Tin Đăng Nhập</h3>
                            <ul class="list-unstyled file-list">
                                <li><i class="fa fa-envelope-square"></i> Email: <span class="text-navy">{{$khachHangShow->email}}</span></li>
                                <li><i class="fa fa-unlock-alt"></i> Mật khẩu: <span class="text-navy">{{$khachHangShow->mat_khau}}</span></li>
                            </ul>
                        </div>
                    </div>

                    <div class="ibox">
                        <div class="ibox-content">
                            <h3>Các Khách Hàng Khác</h3>
                            <p class="small">
                                Các khách hàng khác bạn có thể biết
                            </p>
                            <div class="user-friends">
                                @foreach ($khachHangLienQuan as $key => $value)
                                <a href="{{route('khachhang.show', $value->id)}}"><img alt="image" class="img-circle" src="{{$value->anh_dai_dien === NULL ? "./storage/uploads/khachhang/avatar.png" : ".".Storage::url($value->anh_dai_dien)}}"></a>
                                @endforeach
                                {{-- <a href=""><img alt="image" class="img-circle" src="template/img/a3.jpg"></a>
                                <a href=""><img alt="image" class="img-circle" src="template/img/a1.jpg"></a>
                                <a href=""><img alt="image" class="img-circle" src="template/img/a2.jpg"></a>
                                <a href=""><img alt="image" class="img-circle" src="template/img/a4.jpg"></a>
                                <a href=""><img alt="image" class="img-circle" src="template/img/a5.jpg"></a>
                                <a href=""><img alt="image" class="img-circle" src="template/img/a6.jpg"></a>
                                <a href=""><img alt="image" class="img-circle" src="template/img/a7.jpg"></a>
                                <a href=""><img alt="image" class="img-circle" src="template/img/a8.jpg"></a>
                                <a href=""><img alt="image" class="img-circle" src="template/img/a2.jpg"></a>
                                <a href=""><img alt="image" class="img-circle" src="template/img/a1.jpg"></a> --}}
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="col-lg-9">

                    <div class="social-feed-box">
                        <div class="social-avatar">
                            <div class="media-body">
                                <a href="#">
                                    Các Sản Phẩm Đã Mua
                                </a>
                            </div>
                        </div>
                        <div class="social-body">
                            <div class="row">
                                @if($khachHangShowOrder[0]->ten_san_pham === null)
                                <div style="padding-left: 15px">Khách hàng này chưa mua sản phẩm nào</div>
                                @else
                                @foreach ($khachHangShowOrder as $key => $value)
                                <div class="col-md-4">
                                    <div class="ibox" style="margin-bottom: 10px">
                                        <div class="ibox-content product-box">
                                            <div style="display: flex; justify-content: center; align-items: center; overflow: hidden; aspect-ratio: 1/1">
                                                <div>
                                                    <img src="{{'.'.Storage::url($value->anh_san_pham)}}" style="width: 100%; margin-bottom: 0" alt="Ảnh sản phẩm">
                                                </div>
                                            </div>
                                            <div class="product-desc">
                                                {!! $value->ten_gia_tri_thuoc_tinh_bt !== null ? '<span class="product-price" style="font-size: 12px; top: 0; transform: translateY(-100%)">'.$value->ten_gia_tri_thuoc_tinh_bt.'</span>' : ''!!}
                                                <small class="text-muted">{{$value->ten_danh_muc}}</small>
                                                <a href="{{route('sanpham.show', $value->id_san_pham)}}" class="product-name" 
                                                style="overflow-wrap: break-word;
                                                display: -webkit-box;
                                                -webkit-line-clamp: 1;
                                                -webkit-box-orient: vertical;
                                                overflow: hidden; font-size: 14px
                                              ">{{$value->ten_san_pham}}</a>
                                              <span class="text-navy">{{number_format($value->gia, 0, '', '.')}} vnđ</span>
                                                <div class="m-t text-righ">
                
                                                    <a href="{{route('sanpham.show', $value->id_san_pham)}}" class="btn btn-xs btn-outline btn-primary">Xem <i class="fa fa-long-arrow-right"></i> </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            {{ $khachHangShowOrder->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>