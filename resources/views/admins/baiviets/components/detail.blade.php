<div class="row">
    <div class="col-md-9">

        <div class="ibox">
            <div class="ibox-title">
                <span class="pull-right">{{$sanPham[0]->kieu_san_pham == 1 ? 'Sản phẩm đơn giản' : 'Sản phẩm biến thể'}}</span>
                <h5>Chi Tiết Sản Phẩm</h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table shoping-cart-table">

                        <tbody>
                        <tr>
                            <td width="90">
                                <div class="cart-product-imitation" style="padding-top: 0; background-color: transparent">
                                    <img src="{{'.'.Storage::url($sanPham[0]->anh_san_pham)}}" style="width: 100%;object-fit: cover; aspect-ratio: 1/1;" alt="Ảnh sản phẩm">
                                </div>
                            </td>
                            <td class="desc">
                                <h3 style="margin-bottom: 4px; margin-top: 0">
                                <a href="#" class="text-navy">
                                    {{$sanPham[0]->ten_san_pham}}
                                </a>
                                </h3>
                                <p class="small" style="margin-bottom: 1px">
                                   Mã sản phẩm: <strong>{{$sanPham[0]->ma_san_pham}}</strong>
                                </p>
                                @if($sanPham[0]->kieu_san_pham === 1)
                                <p class="small" style="margin-bottom: 1px">
                                    Giá: @if ($sanPham[0]->gia_khuyen_mai != NULL)
                                    <del>{{number_format($sanPham[0]->gia, 0, '', '.')}} vnđ</del> {{number_format($sanPham[0]->gia_khuyen_mai, 0, '', '.')}} vnđ
                                    @else
                                    {{number_format($sanPham[0]->gia, 0, '', '.')}} vnđ
                                    @endif
                                </p>
                                @else
                                <p class="small" style="margin-bottom: 1px">
                                    Giá: {{number_format($giaMin, 0, '', '.')}} vnđ - {{number_format($giaMax, 0, '', '.')}} vnđ
                                </p>
                                @endif
                                <p class="small" style="margin-bottom: 1px">
                                    Số lượng: {{$sanPham[0]->kieu_san_pham === 1 ? $sanPham[0]->so_luong  : $totalQuantity}}
                                </p>
                                <p class="small" style="margin-bottom: 0">
                                   Danh mục: {{$sanPham[0]->ten_danh_muc}}
                                </p>
                            </td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                            <dl class="small m-b-none" style="margin-top: 5px;">
                                <dt>Mô tả ngắn:</dt>
                                <dd>{!!$sanPham[0]->mo_ta_ngan === null ? 'Sản phẩm chưa có mô tả ngắn' : $sanPham[0]->mo_ta_ngan!!}</dd>
                            </dl>
                            <dl class="small m-b-none" style="margin-top: 5px;">
                               <dt>Mô tả chi tiết:</dt>
                               <dd>{!!$sanPham[0]->mo_ta === null ? 'Sản phẩm chưa có mô tả chi tiết' : $sanPham[0]->mo_ta!!}</dd>
                            </dl>
                </div>
            </div>
        </div>
        <div class="ibox">
            <div class="ibox-title">
                <span class="pull-right">(<strong>{{count($albumAnh) + 1}}</strong>) ảnh</span>
                <h5>Album Ảnh</h5>
            </div>
            <div class="ibox-content">
            <div class="row">
                @if(!$albumAnh->isEmpty())
                <div class="col-sm-2">
                    <div class="table-responsive">
                      <table class="table shoping-cart-table">
                        <tbody>
                        <tr>
                            <td width="90">
                                <div class="cart-product-imitation" style="padding-top: 0; background-color: transparent">
                                    <img src="{{'.'.Storage::url($sanPham[0]->anh_san_pham)}}" style="width: 100%;object-fit: cover; aspect-ratio: 1/1;" alt="Ảnh sản phẩm">
                                </div>
                            </td>
                        </tr>
                        </tbody>
                        </table>
                    </div>
               </div>
               @endif
                @forelse ($albumAnh as $key => $value)
                <div class="col-sm-2">
                    <div class="table-responsive">
                      <table class="table shoping-cart-table">
                        <tbody>
                        <tr>
                            <td width="90">
                                <div class="cart-product-imitation" style="padding-top: 0; background-color: transparent">
                                    <img src="{{'.'.Storage::url($value->duong_dan_anh)}}" style="width: 100%;object-fit: cover; aspect-ratio: 1/1;" alt="Ảnh sản phẩm">
                                </div>
                            </td>
                        </tr>
                        </tbody>
                        </table>
                    </div>
               </div>
                @empty
                    <div class="col-sm-12">
                        Sản phẩm này chưa có Album ảnh
                    </div>
                @endforelse
            </div>
            </div>
        </div>

    </div>
    <div class="col-md-3">

        <div class="ibox">
            <div class="ibox-title">
                <h5>Doanh Thu</h5>
            </div>
            <div class="ibox-content">
                <span>
                    Tổng cộng
                </span>
                <h2 class="font-bold text-danger">
                    {{number_format($doanhThu, 0, '', '.')}} VNĐ
                </h2>
            </div>
        </div>

        <div class="ibox">
            <div class="ibox-title">
                <h5>Lượt Tương Tác</h5>
            </div>
            <div class="ibox-content">
            <div class="row" style="padding-bottom: 15px">
             <div class="col-sm-6"><button type="button" style="border-radius: 3px; margin-right: 5px" class="btn btn-warning">{{str_pad($sanPham[0]->luot_xem, 2, '0', STR_PAD_LEFT)}}</button>lượt xem</div>
             <div class="col-sm-6"><button type="button" style="border-radius: 3px; margin-right: 5px" class="btn btn-success">{{str_pad($daBan, 2, '0', STR_PAD_LEFT)}}</button>đã bán</div>
            </div>
            <div class="row">
                <div class="col-sm-6"><button type="button" style="border-radius: 3px; margin-right: 5px" class="btn btn-info">{{str_pad(count($listBinhLuan), 2, '0', STR_PAD_LEFT)}}</button>bình luận</div>
                <div class="col-sm-6"><button type="button" style="border-radius: 3px; margin-right: 5px" class="btn btn-danger">{{str_pad(count($listDanhGia), 2, '0', STR_PAD_LEFT)}}</button>đánh giá</div>
            </div>
            </div>
        </div>
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    {{-- <div class="col-lg-12">
                        <div class="feed-element" style="padding-bottom: 0; display: flex; align-items: center">
                            <a href="{{empty($khachHangVip) ? 'javascript:void(0)' : route('khachhang.show', $khachHangVip->id)}}" class="pull-left">
                                <img alt="image" class="img-circle" src="{{empty($khachHangVip) || $khachHangVip->anh_dai_dien===null ? "./storage/uploads/khachhang/avatar.png" : ".".Storage::url($khachHangVip->anh_dai_dien)}}">
                            </a>
                                <small><strong>{{empty($khachHangVip) ? 'User' : $khachHangVip->name}}</strong><br>{{empty($khachHangVip) ? 'Chưa có khách hàng nào mua' : 'mua nhiều nhất ('.$khachHangVip->sum_so_luong.' lần)'}}</small>
                        </div>
                    </div> --}}
                    <div class="col-lg-12">
                        <div class="widget-head-color-box p-sm text-center" style="margin-top: 0">
                            <a href="{{empty($khachHangVip) ? 'javascript:void(0)' : route('khachhang.show', $khachHangVip->id)}}">
                            <img src="{{empty($khachHangVip) || $khachHangVip->anh_dai_dien===null ? "./storage/uploads/khachhang/avatar.png" : ".".Storage::url($khachHangVip->anh_dai_dien)}}" class="img-circle circle-border" style="border-color: #1ab394; width: 135px;" alt="profile">
                            </a>
                        </div>
                        <div class="widget-text-box text-center" style="border: none; padding: 0; padding-bottom: 10px">
                            <a href="{{empty($khachHangVip) ? 'javascript:void(0)' : route('khachhang.show', $khachHangVip->id)}}">
                            <h4 class="media-heading" style="margin-top: 0">{{empty($khachHangVip) ? 'User' : $khachHangVip->name}}</h4>
                            </a>
                            <p style="margin-bottom: 0">{{empty($khachHangVip) ? 'Chưa có khách hàng nào mua' : 'Mua nhiều nhất ('.$khachHangVip->sum_so_luong.' lần)'}}</p>
                        </div>
                </div>
                    {{-- <div class="col-md-12">
                        <div class="text-center">
                            <h3>{{empty($khachHangVip) ? 'User' : $khachHangVip->name}}</h3>
                            <div class="m-b-sm">
                                    <img alt="image" class="img-circle" style="width: 100px;" src="{{empty($khachHangVip) || $khachHangVip->anh_dai_dien===null ? "./storage/uploads/khachhang/avatar.png" : ".".Storage::url($khachHangVip->anh_dai_dien)}}">
                            </div>
                                    <p style="margin-bottom: 0">{{empty($khachHangVip) ? 'Chưa có khách hàng nào mua' : 'Mua nhiều nhất ('.$khachHangVip->sum_so_luong.' lần)'}}</p>
                        </div> --}}
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
    @if($sanPham[0]->kieu_san_pham === 2)
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-title">
                <span class="pull-right">(<strong>{{$countBienThe}}</strong>) biến thể</span>
                <h5>Các Biến Thể <span style="font-weight: 500;">({{$sanPhamShow[0]->ten_thuoc_tinh_bien_the}})</span></h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    @foreach($sanPhamShow as $key => $value)
                    <div class="col-sm-4">
                        <div class="table-responsive">
                          <table class="table shoping-cart-table">
    
                            <tbody>
                            <tr>
                                <td width="90">
                                    <div class="cart-product-imitation" style="padding-top: 0; background-color: transparent">
                                        <img src="{{$value->anh_bien_the_san_pham === NULL ? '.'.Storage::url($sanPham[0]->anh_san_pham) : '.'.Storage::url($value->anh_bien_the_san_pham)}}" style="width: 100%;object-fit: cover; aspect-ratio: 1/1;" alt="Ảnh sản phẩm">
                                    </div>
                                </td>
                                <td class="desc">
                                    <h3 style="margin-bottom: 4px">
                                        <a href="#" class="text-navy">
                                         {{$value->ten_gia_tri_thuoc_tinh_bt}}
                                        </a>
                                    </h3>
                                    <p class="small" style="margin-bottom: 1px">
                                       Mã biến thể: <strong>{{$value->ma_bien_the_san_pham}}</strong>
                                    </p>
                                    <p class="small" style="margin-bottom: 1px">
                                        Giá: {{number_format($value->gia, 0, '', '.')}} vnđ
                                    </p>
                                    <p class="small" style="margin-bottom: 1px">
                                        Số lượng: {{$value->so_luong}}
                                    </p>
                                </td>
                                <td></td>
                            </tr>
                            </tbody>
                            </table>
                        </div>
                   </div>
                   @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="col-md-8">
        <div class="ibox">
            <div class="ibox-title">
                <span class="pull-right">(<strong>{{count($listBinhLuan)}}</strong>) bình luận</span>
                <h5>Bình Luận</h5>
            </div>
            <div class="ibox-content" style="padding-bottom: 15px">
                <div class="row">
                        <div class="col-lg-12">
                        <div class="panel blank-panel">
                        <div class="panel-body" style="{{empty($listBinhLuan['item']) ? 'padding-left: 0; padding-right: 0' : '' }}">
                        <div class="tab-content">
                        <div class="tab-pane active">
                            <div class="feed-activity-list">
                                @forelse ($listBinhLuan as $key => $value)
                                <div class="feed-element">
                                    <a href="{{route('khachhang.show', $value->id_user)}}" class="pull-left">
                                        <img alt="image" class="img-circle" src="{{$value->anh_dai_dien === NULL ? "./storage/uploads/khachhang/avatar.png" : ".".Storage::url($value->anh_dai_dien)}}">
                                    </a>
                                    <div class="media-body ">
                                        <small class="pull-right"><?php
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
                                        <strong>{{$value->name}}</strong> đã bình luận cho <strong>{{$sanPham[0]->ten_san_pham}}</strong><br>
                                        <small class="text-muted">
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
                                        }?><td> {{date('H:i - d.m.Y', strtotime($value->thoi_gian))}}</td></small>
                                        <div class="well">
                                            {{$value->noi_dung}}
                                        </div>
                                    </div>
                                </div>
                                @empty
                                Sản phẩm này chưa có bình luận nào
                                @endforelse
                            </div>
                        </div>
                    
                        </div>

                        </div>

                        </div>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ibox">
            <div class="ibox-title">
                <span class="pull-right">(<strong>{{count($listDanhGia)}}</strong>) đánh giá</span>
                <h5>Đánh Giá</h5>
            </div>
            <div class="ibox-content" style="padding-bottom: 15px">
                <div class="row">
                        <div class="col-lg-12">
                        <div class="panel blank-panel">
                        <div class="panel-body" style="{{empty($listDanhGia) ? 'padding-left: 0; padding-right: 0' : 'padding-top: 0' }}">
                        <div class="tab-content">
                        <div class="tab-pane active">
                            <div class="feed-activity-list">
                                <div class="feed-element">
                                    <div class="media-body">
                                    <div style="display: flex">
                                        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;padding-right: 14px; padding-left: 14px; border: 1px solid #e7eaec; border-radius: 50%; background-color: #f5f5f5; margin-right: 20px">
                                          <strong>{{round($trungBinhSao * 2) / 2;}}/5</strong>
                                          <div>
                                            <?php
                                                $danhGia = $trungBinhSao;
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
                                      <div style="flex: 1;"><small class="text-muted">
                                           <div style="border-bottom: 1px solid #e7eaec; text-align: center; padding-bottom: 1px">{{$listDanhGia->where('sao', 1)->count()}} đánh giá 1 <i class="fa fa-star text-warning"></i></div>
                                           <div style="border-bottom: 1px solid #e7eaec; text-align: center; padding-top: 1px; padding-bottom: 1px">{{$listDanhGia->where('sao', 2)->count()}} đánh giá 2 <i class="fa fa-star text-warning"></i></div>
                                           <div style="border-bottom: 1px solid #e7eaec; text-align: center; padding-top: 1px; padding-bottom: 1px">{{$listDanhGia->where('sao', 3)->count()}} đánh giá 3 <i class="fa fa-star text-warning"></i></div>
                                           <div style="border-bottom: 1px solid #e7eaec; text-align: center; padding-top: 1px; padding-bottom: 1px">{{$listDanhGia->where('sao', 4)->count()}} đánh giá 4 <i class="fa fa-star text-warning"></i></div>
                                           <div style="text-align: center; padding-top: 1px;">{{$listDanhGia->where('sao', 5)->count()}} đánh giá 5 <i class="fa fa-star text-warning"></i></div>
                                      </small>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                @forelse ($listDanhGia as $key => $value)
                                <div class="feed-element">
                                    <a href="{{route('khachhang.show', $value->id_user)}}" class="pull-left">
                                        <img alt="image" class="img-circle" src="{{$value->anh_dai_dien === NULL ? "./storage/uploads/khachhang/avatar.png" : ".".Storage::url($value->anh_dai_dien)}}">
                                    </a>
                                    <div class="media-body">
                                        <small class="pull-right">{{date('d.m.Y', strtotime($value->ngay_danh_gia))}}</small>
                                        <strong>{{$value->name}}</strong> đã đánh giá <strong>{{$value->sao}} sao</strong>.<br>
                                        <small class="text-muted">
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
                                        </small><br>
                                        <small class="text-muted">{{$value->noi_dung}}</small>
                                    </div>
                                </div>
                                @empty
                                <div style="margin-top: 15px">
                                    Sản phẩm này chưa có đánh giá nào
                                </div>
                                @endforelse
                            </div>
                        </div>
                    
                        </div>

                        </div>

                        </div>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>