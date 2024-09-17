<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Mã khách hàng</th>
            <th>Avatar</th>
            <th>Thông tin khách hàng</th>
            <th>Địa chỉ</th>
            <th>Vai trò</th>
            <th class="text-center">Trạng thái</th>
            <th class="text-center">Hàng động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($listKhachHang as $key => $value)
            <tr>
                <td>{{$value->ma_khach_hang}}</td>
                <td style="width: 90px;"><img style="width: 100%; aspect-ratio: 1/1; object-fit: cover;"
                    src="{{$value->anh_dai_dien === NULL ? "./storage/uploads/khachhang/avatar.png" : ".".Storage::url($value->anh_dai_dien)}}"
                    alt=""></td>
                <td>
                    <div class="mb1"><strong>Họ và tên:</strong> {{$value->name}}</div>
                    <div class="mb1"><strong>Email:</strong> {{$value->email}}</div>
                    <div><strong>Số điện thoại:</strong> {{$value->so_dien_thoai===NULL ? 'chưa cập nhật' : $value->so_dien_thoai}}</div>
                </td>
                <td>{{$value->dia_chi===NULL ? 'Khách hàng chưa thêm địa chỉ' : $value->dia_chi}}</td>
                <td>{!!$value->vai_tro ===2 ? '<span class="text-danger" style="font-weight: 700">admin</span>' : '<span class="text-success" style="font-weight: 700">user</span>'!!}</td>
                <td>
                    <div class="bg-primary"
                        style="border-radius: 50%; width: 30px; height: 30px; display: flex; justify-content: center; align-items: center; margin: 0 auto">
                        <i class="fa fa-check"></i>
                    </div>
                </td>
                <td class="text-center">
                    <a style="margin-right: 2px;" href="{{route('khachhang.show', $value->id)}}"><button class="btn btn-info"><i class="fa fa-eye"></i></button></a>
                    <a style="margin-right: 2px" href="{{route('khachhang.edit', $value->id)}}"><button class="btn btn-success"><i class="fa fa-edit"></i></button></a>
                    <form action="{{route('khachhang.destroy', $value->id)}}" method="post" style="display: inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn chuyển vào thùng rác không ?')">
                        @csrf
                        @method('delete')
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                    </form></td>
            </tr>
        @endforeach
        {{-- <tr>
            <td>1</td>
            <td style="width: 90px;"><img style=" width: 100%;object-fit: cover; aspect-ratio: 1/1;"
                    src="data:image/png;base64,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"
                    alt=""></td>
            <td>
                <div class="mb1"><strong>Họ và tên:</strong> Lê Văn Long</div>
                <div class="mb1"><strong>Email:</strong> longlvph39851@fpt.edu.vn</div>
                <div><strong>Số điện thoại:</strong> 0388205794</div>
            </td>
            <td>Tân Minh, Thường Tín, Hà Nội</td>
            <td>
                <div class="bg-primary"
                    style="border-radius: 50%; width: 30px; height: 30px; display: flex; justify-content: center; align-items: center; margin: 0 auto">
                    <i class="fa fa-check"></i>
                </div>
            </td>
            <td class="text-center"><a style="margin-right: 2px" href="{{route('khachhang.edit', 1)}}"><button
                        class="btn btn-success"><i class="fa fa-edit"></i></button></a><a style="margin-left: 2px"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa không')" href=""><button
                        class="btn btn-danger"><i class="fa fa-trash"></i></button></a></td>
        </tr>
        <tr>
            <td>2</td>
            <td style="width: 90px;"><img style=" width: 100%;object-fit: cover; aspect-ratio: 1/1;"
                    src="data:image/png;base64,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"
                    alt=""></td>
            <td>
                <div class="mb1"><strong>Họ và tên:</strong> Lê Văn Long</div>
                <div class="mb1"><strong>Email:</strong> longlvph39851@fpt.edu.vn</div>
                <div><strong>Số điện thoại:</strong> 0388205794</div>
            </td>
            <td>Tân Minh, Thường Tín, Hà Nội</td>
            <td>
                <div class="bg-danger"
                    style="border-radius: 50%; width: 30px; height: 30px; display: flex; justify-content: center; align-items: center; margin: 0 auto">
                    <i class="fa fa-times"></i>
                </div>
            </td>
            <td class="text-center"><a style="margin-right: 2px" href=""><button class="btn btn-success"><i
                            class="fa fa-edit"></i></button></a><a style="margin-left: 2px" href=""><button
                        class="btn btn-danger"><i class="fa fa-trash"></i></button></a></td>
        </tr> --}}
    </tbody>
</table>
{{-- {{$listKhachHang->links('pagination::bootstrap-4')}} --}}
{{ $listKhachHang->appends(request()->query())->links('pagination::bootstrap-4') }}