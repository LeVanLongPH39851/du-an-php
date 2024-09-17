    <div class="contact-box border-none" style="border: none; margin-bottom: 0">
        <a href="{{route('khachhang.show', $thongTinKhachHang[0]->id)}}" style="display: flex; align-items: center">
        <div class="col-sm-4">
            <div class="text-center">
                <img alt="image" class="img-circle m-t-xs img-responsive" src="{{$thongTinKhachHang[0]->anh_dai_dien === NULL ? "./storage/uploads/khachhang/avatar.png" : ".".Storage::url($thongTinKhachHang[0]->anh_dai_dien)}}">
                <div class="m-t-xs font-bold">{{$thongTinKhachHang[0]->name}}</div>
            </div>
        </div>
        <div class="col-sm-8">
            <p><strong><i class="fa fa-address-book"></i> {{$thongTinKhachHang[0]->ma_khach_hang}}</strong></p>
            <p><i class="fa fa-phone-square"></i> {{$thongTinKhachHang[0]->so_dien_thoai == NULL ? "chưa cập nhật" : $thongTinKhachHang[0]->so_dien_thoai}}</p>
            <p><i class="fa fa-envelope-square"></i> {{$thongTinKhachHang[0]->email}}</p>
            <address>
                <i class="fa fa-map-marker"></i> {{$thongTinKhachHang[0]->dia_chi == NULL ? "khách hàng chưa thêm địa chỉ" : $thongTinKhachHang[0]->dia_chi}}
            </address>
        </div>
        <div class="clearfix"></div>
            </a>
    </div>