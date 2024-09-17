<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Mã danh mục</th>
            <th>Tên danh mục</th>
            <th>Ngày nhập</th>
            <th class="text-center">Trạng thái</th>
            <th>Thời gian xóa</th>
            <th class="text-center">Hàng động</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($listDanhMucTrash as $key => $value)
            <tr>
                <td>{{$value->ma_danh_muc}}</td>
                <td>{{$value->ten_danh_muc}}</td>
                <td>{{date('d/m/Y', strtotime($value->ngay_nhap))}}</td>
                <td>
                    <div class="bg-danger"
                    style="border-radius: 50%; width: 30px; height: 30px; display: flex; justify-content: center; align-items: center; margin: 0 auto">
                    <i class="fa fa-times"></i>
                </div>
                </td>
                <td>{{date('H:i:s d/m/Y', strtotime($value->deleted_at))}}</td>
                <td class="text-center">
                    <div style="display: inline-block; margin-right: 2px">
                        <form action="{{route('danhmuctrash.update', $value->id)}}" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn khôi phục không ?')">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn btn-success"><i class="fa fa-window-restore"></i></button>
                        </form>
                    </div>
                    <div style="display: inline-block">
                        <form action="{{route('danhmuctrash.destroy', $value->id)}}" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn không ?')">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>    
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Chưa có danh mục nào trong thùng rác</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{-- {{$listDanhMuc->links('pagination::bootstrap-4')}} --}}
{{ $listDanhMucTrash->appends(request()->query())->links('pagination::bootstrap-4') }}
