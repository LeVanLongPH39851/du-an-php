<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Mã hình thức</th>
            <th>Tên hình thức</th>
            <th class="text-center">Hàng động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($listHinhThucThanhToan as $key => $value)
            <tr>
                <td>{{$value->ma_phuong_thuc_thanh_toan}}</td>
                <td>{{$value->ten_phuong_thuc_thanh_toan}}</td>
                <td class="text-center"><a style="margin-right: 2px" href="{{route('hinhthucthanhtoan.edit', $value->id)}}"><button
                    class="btn btn-success"><i class="fa fa-edit"></i></button></a>
                    <form action="{{route('hinhthucthanhtoan.destroy', $value->id)}}" method="post" style="display: inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn chuyển vào thùng rác không ?')">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                    </form></td>
            </tr>
        @endforeach
    </tbody>
</table>
