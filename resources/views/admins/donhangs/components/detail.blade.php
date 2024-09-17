<table class="table table-bordered">
    <thead>
        <tr>
            <th class="text-center">STT</th>
            <th>Tên sản phẩm</th>
            <th>Ảnh</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
            <th>Tổng tiền</th>
            <th>Hình thức thanh toán</th>
        </tr>
    </thead>
    <tbody>
        @foreach($donHangShow as $key => $value)
        <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td><a class="Order-Detail-Product-Name" style="color: inherit" href="{{route('sanpham.show', $value->id_san_pham)}}">{{$value->ten_san_pham}}{{($value->ten_gia_tri_thuoc_tinh_bt!==NULL) ? ' ('.$value->ten_gia_tri_thuoc_tinh_bt.')' : "" }}</a></td>
            <td style="width: 90px;"><a href="{{route('sanpham.show', $value->id_san_pham)}}"><img src="{{".".Storage::url($value->anh_san_pham)}}" style="width: 100%;object-fit: cover; aspect-ratio: 1/1;" alt="Ảnh sản phẩm"></a></td>
            <td>{{number_format($value->gia, 0, '', '.')}} vnđ</td>
            <td>{{$value->so_luong}}</td>
            <td>{{number_format($value->thanh_tien, 0, '', '.')}} vnđ</td>
            @if($loop->first)
            <td rowspan="{{ $loop->count }}">{{number_format($value->tong_tien, 0, '', '.')}} vnđ</td>
            <td rowspan="{{ $loop->count }}">{{$value->ten_phuong_thuc_thanh_toan}}</td>
            @endif
        </tr>
        @endforeach
        <tr>
            <td colspan="6"><strong>Ghi chú: </strong>{{$value->ghi_chu === NULL ? 'Không có ghi chú' : $value->ghi_chu}}</td>
            <td><strong>Ngày đặt: </strong>{{date('d/m/Y', strtotime($thongTinKhachHang[0]->ngay_dat))}}</td>
            <td><strong>Trạng thái: </strong>{{$value->ten_trang_thai_don_hang}}</td>
        </tr>    
    </tbody>
</table>
