<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Mã đơn hàng</th>
            <th>Thông tin khách hàng</th>
            <th>Địa chỉ</th>
            <th>Tổng tiền</th>
            <th>Ngày đặt</th>
            <th>Trạng thái thanh toán</th>
            <th class="text-center">Hàng động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($listDonHang as $key => $value)
            <tr>
             <td>{{$value->ma_don_hang}}</td>
             <td>
                <div class="mb1"><strong>Họ và tên:</strong> {{$value->ten_nguoi_nhan}}</div>
                <div class="mb1"><strong>Email:</strong> {{$value->email_nguoi_nhan}}</div>
                <div><strong>Số điện thoại:</strong> {{$value->so_dien_thoai_nguoi_nhan}}</div>
            </td>
             <td>{{$value->dia_chi_nguoi_nhan}}</td>
             <td>{{number_format($value->tong_tien, 0, '', '.')}} vnđ</td>
             <td>{{date('d/m/Y', strtotime($value->ngay_dat))}}</td>
             <td>{{$value->ten_trang_thai_don_hang}}</td>
             <td class="text-center">
                <a style="margin-right: 2px" href="{{route('donhang.show', $value->id)}}"><button
                    class="btn btn-info"><i class="fa fa-eye"></i></button></a>
                <a href="{{route('donhang.edit', $value->id)}}"><button
                class="btn btn-success"><i class="fa fa-edit"></i></button></a>
                {{-- <form action="{{route('donhang.destroy', $value->id)}}" method="post" style="display: inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn đơn hàng không ?')">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                </form> --}}
            </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $listDonHang->appends(request()->query())->links('pagination::bootstrap-4') }}