<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Mã danh mục</th>
            <th>Tên danh mục</th>
            <th>Ảnh</th>
            <th>Ngày nhập</th>
            <th class="text-center">Trạng thái</th>
            <th class="text-center">Hàng động</th>
        </tr>
    </thead>
    <tbody>
        @php
        function printCategoryRow($category, $level = 0) {
            echo '<tr>';
            echo '<td>' . $category->ma_danh_muc . '</td>';
            echo '<td>' . str_repeat('--', $level) . ' ' . $category->ten_danh_muc . '</td>';
            echo '<td style="width: 90px;"><img style="width: 100%; aspect-ratio: 1/1; object-fit: cover;" src=".' . Storage::url($category->anh_danh_muc) . '" alt=""></td>';
            echo '<td>' . date('d/m/Y', strtotime($category->ngay_nhap)) . '</td>';
            echo '<td><div class="bg-primary" style="border-radius: 50%; width: 30px; height: 30px; display: flex; justify-content: center; align-items: center; margin: 0 auto"><i class="fa fa-check"></i></div></td>';
            echo '<td class="text-center">';
            echo '<a style="margin-right: 5px" href="' . route('sanpham.index') . '?category=' . $category->id . '"><button class="btn btn-info"><i class="fa fa-eye"></i></button></a>';
            echo '<a style="margin-right: 5px" href="' . route('danhmuc.edit', $category->id) . '"><button class="btn btn-success"><i class="fa fa-edit"></i></button></a>';
            echo '<form action="' . route('danhmuc.destroy', $category->id) . '" method="post" style="display: inline-block" onsubmit="return confirm(\'Bạn có chắc chắn muốn chuyển vào thùng rác không ?\')">';
            echo csrf_field();
            echo method_field('delete');
            echo '<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
            echo '</form></td>';
            echo '</tr>';

            if ($category->children->count() > 0) {
                foreach ($category->children as $child) {
                    printCategoryRow($child, $level + 1);
                }
            }
        }
        @endphp
        @foreach ($listDanhMuc as $category)
        @if ($category->danh_muc_cha_id == null) <!-- Chỉ hiển thị danh mục cha -->
            @php printCategoryRow($category); @endphp
        @endif
        @endforeach
    </tbody>
</table>
{{-- {{$listDanhMuc->links('pagination::bootstrap-4')}} --}}
{{ $listDanhMuc->appends(request()->query())->links('pagination::bootstrap-4') }}
