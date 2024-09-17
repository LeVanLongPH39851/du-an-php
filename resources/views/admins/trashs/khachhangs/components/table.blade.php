<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Mã khách hàng</th>
            <th>Avatar</th>
            <th>Thông tin khách hàng</th>
            <th>Địa chỉ</th>
            <th>Vai trò</th>
            <th class="text-center">Trạng thái</th>
            <th>Thời gian xóa</th>
            <th class="text-center">Hàng động</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($listKhachHangTrash as $key => $value)
            <tr>
                <td>{{$value->ma_khach_hang}}</td>
                <td style="width: 90px;"><img style="width: 100%;object-fit: cover; aspect-ratio: 1/1;"
                    src="{{$value->anh_dai_dien === NULL ? "./storage/uploads/khachhang/avatar.png" : ".".Storage::url($value->anh_dai_dien)}}"
                    alt=""></td>
                <td>
                    <div class="mb1"><strong>Họ và tên:</strong> {{$value->name}}</div>
                    <div class="mb1"><strong>Email:</strong> {{$value->email}}</div>
                    <div><strong>Số điện thoại:</strong> {{$value->so_dien_thoai}}</div>
                </td>
                <td>{{$value->dia_chi}}</td>
                <td>{!!$value->vai_tro ===2 ? '<span class="text-danger" style="font-weight: 700">admin</span>' : '<span class="text-success" style="font-weight: 700">user</span>'!!}</td>
                <td>
                    <div class="bg-danger"
                    style="border-radius: 50%; width: 30px; height: 30px; display: flex; justify-content: center; align-items: center; margin: 0 auto">
                    <i class="fa fa-times"></i>
                </div>
                </td>
                <td>{{date('H:i:s d/m/Y', strtotime($value->deleted_at))}}</td>
                <td class="text-center">
                    <div style="display: inline-block; margin-right: 2px">
                        <form action="{{route('khachhangtrash.update', $value->id)}}" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn khôi phục không ?')">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn btn-success"><i class="fa fa-window-restore"></i></button>
                        </form>
                    </div>
                    <div style="display: inline-block">
                        <form action="{{route('khachhangtrash.destroy', $value->id)}}" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn không ?')">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>    
                </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center">Chưa có khách hàng nào trong thùng rác</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{-- {{$listKhachHang->links('pagination::bootstrap-4')}} --}}
{{ $listKhachHangTrash->appends(request()->query())->links('pagination::bootstrap-4') }}