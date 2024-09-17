<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Mã trạng thái</th>
            <th>Tên trạng thái</th>
            <th class="text-center">Hàng động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($listTrangThaiDonHang as $key => $value)
            <tr>
                <td>{{$value->ma_trang_thai_don_hang}}</td>
                <td>{{$value->ten_trang_thai_don_hang}}</td>
                <td class="text-center"><a style="margin-right: 2px" href="{{route('trangthaidonhang.edit', $value->id)}}"><button
                    class="btn btn-success"><i class="fa fa-edit"></i></button></a>
                    <form action="{{route('trangthaidonhang.destroy', $value->id)}}" method="post" style="display: inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn chuyển vào thùng rác không ?')">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                    </form></td>
            </tr>
        @endforeach
    </tbody>
</table>
