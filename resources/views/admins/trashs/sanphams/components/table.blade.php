<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Mã sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Ảnh</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Danh mục</th>
            <th>Ngày nhập</th>
            <th class="text-center">Trạng thái</th>
            <th>Thời gian xóa</th>
            <th class="text-center">Hàng động</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($listSanPhamTrash as $key => $value)
            <tr>
             <td>{{$value->ma_san_pham}}</td>
             <td>{{$value->ten_san_pham}}</td>
             <td style="width: 90px;">
                <img src="{{".".Storage::url($value->anh_san_pham)}}" style="width: 100%;object-fit: cover; aspect-ratio: 1/1;" alt="Ảnh sản phẩm"></td>
             <td>{{number_format($value->gia, 0, '', '.')}} vnđ</td>
             <td>{{$value->so_luong}}</td>
             <td>{{$value->ten_danh_muc}}</td>
             <td>{{date('d/m/Y', strtotime($value->ngay_nhap))}}</td>
             <td><div class="bg-danger"
                style="border-radius: 50%; width: 30px; height: 30px; display: flex; justify-content: center; align-items: center; margin: 0 auto">
                <i class="fa fa-times"></i>
            </div></td>
                <td>{{date('H:i:s d/m/Y', strtotime($value->deleted_at))}}</td>
             <td class="text-center">
                <div style="display: inline-block; margin-right: 2px">
                    <form action="{{route('sanphamtrash.update', $value->id)}}" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn khôi phục không ?')">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-success"><i class="fa fa-window-restore"></i></button>
                    </form>
                </div>
                <div style="display: inline-block">
                    <form action="{{route('sanphamtrash.destroy', $value->id)}}" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn không ?')">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                    </form>
                </div>
             </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center">
                Chưa có sản phẩm nào trong thùng rác
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
{{-- {{$listSanPham->links('pagination::bootstrap-4')}} --}}
{{ $listSanPhamTrash->appends(request()->query())->links('pagination::bootstrap-4') }}