<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Mã bài viết</th>
            <th>Tiêu đề</th>
            <th>Ảnh</th>
            <th>Ngày đăng</th>
            <th>Người đăng</th>
            <th class="text-center">Trạng thái</th>
            <th class="text-center">Hàng động</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($listBaiViet as $key => $value)
        <tr>
            <td>{{$value->ma_bai_viet}}</td>
            <td>{{$value->tieu_de}}</td>
            <td style="width: 90px;">
               <img src="{{'.'.Storage::url($value->anh_bai_viet)}}" style="width: 100%" alt="Ảnh bài viết"></td>
            <td>{{date('d/m/Y', strtotime($value->ngay_dang))}}</td>
            <td>{{$value->name}}</td>
            <td><div class="bg-primary"
                   style="border-radius: 50%; width: 30px; height: 30px; display: flex; justify-content: center; align-items: center; margin: 0 auto">
                   <i class="fa fa-check"></i>
               </div></td>
            <td class="text-center">
               {{-- <a style="margin-right: 2px;" href=""><button class="btn btn-info"><i class="fa fa-eye"></i></button></a> --}}
               <a style="margin-right: 2px" href="{{route('baiviet.edit', $value->id)}}"><button
               class="btn btn-success"><i class="fa fa-edit"></i></button></a>
               <form action="{{route('baiviet.destroy', $value->id)}}" method="post" style="display: inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết không ?')">
                   @csrf
                   @method('delete')
                   <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
               </form></td>
        </tr>       
        @empty
        <tr><td colspan="7" class="text-center">Không có bài viết nào</td></tr>
        @endforelse
    </tbody>
</table>
{{-- {{$listSanPham->links('pagination::bootstrap-4')}} --}}
{{ $listBaiViet->appends(request()->query())->links('pagination::bootstrap-4') }}