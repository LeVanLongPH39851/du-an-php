<table class="table" style="margin-bottom: 0px">
    <thead>
        <tr>
            <th>#</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>SL</th>
            <th>Thành tiền</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($donHangShow as $key => $value)
        <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td>{{$value->ten_san_pham}}{{($value->ten_gia_tri_thuoc_tinh_bt!==NULL) ? ' ('.$value->ten_gia_tri_thuoc_tinh_bt.')' : "" }}</td>
            <td>{{number_format($value->gia, 0, '', '.')}}đ</td>
            <td>{{$value->so_luong}}</td>
            <td>{{number_format($value->thanh_tien, 0, '', '.')}}đ</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="3"><span style="font-size: 12px;">{{$thongTinKhachHang[0]->ma_don_hang}}</span></td>
            <td colspan="2"><strong>Tổng tiền: </strong>{{number_format($value->tong_tien, 0, '', '.')}}đ</td>
        </tr>
    </tbody>
</table>
<div style="display: flex; justify-content: space-between">
    <div>
        <span style="font-size: 12px;padding-left: 8px;"><strong>Mã hóa đơn: </strong>#{{rand(100000, 999999)}}</span><br />
        <span style="font-size: 12px;padding-left: 8px;"><strong>Khách hàng: </strong>{{$thongTinKhachHang[0]->name}}</span><br>
        <span style="font-size: 12px;padding-left: 8px;"><strong>Ngày đặt hàng: </strong>{{date('d/m/Y', strtotime($thongTinKhachHang[0]->ngay_dat))}}</span>
    </div>
    <div style="align-self: flex-end;"><span style="font-family: Times New Roman;"><i>Xin cảm ơn quý khách</i></span></div>
</div>


