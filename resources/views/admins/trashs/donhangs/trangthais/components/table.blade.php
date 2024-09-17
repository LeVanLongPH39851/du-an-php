<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Mã trạng thái</th>
            <th>Tên trạng thái</th>
            <th>Thời gian xóa</th>
            <th class="text-center">Hàng động</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($listTrangThaiDonHangTrash as $key => $value)
            <tr>
                <td>{{$value->ma_trang_thai_don_hang}}</td>
                <td>{{$value->ten_trang_thai_don_hang}}</td>
                <td>{{date('H:i:s d/m/Y', strtotime($value->deleted_at))}}</td>
                <td class="text-center">
                    <div style="display: inline-block; margin-right: 2px">
                        <form action="{{route('trangthaidonhangtrash.update', $value->id)}}" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn khôi phục không ?')">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn btn-success"><i class="fa fa-window-restore"></i></button>
                        </form>
                    </div>
                    <div style="display: inline-block">
                        <form action="{{route('trangthaidonhangtrash.destroy', $value->id)}}" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn không ?')">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">Chưa có trạng thái đơn hàng nào trong thùng rác</td>
        </tr>
        @endforelse
    </tbody>
</table>
