<form method="post" action="{{route('danhmuc.update', $danhMucDetail->id)}}" class="form-horizontal" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="form-group"><label class="col-sm-2 control-label">Mã danh mục</label>

        <div class="col-sm-10"><input type="text" name="id" disabled value="{{$danhMucDetail->ma_danh_muc}}" class="form-control"></div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Tên danh mục <span class="text-danger">(*)</span></label>

        <div class="col-sm-10"><input type="text" name="name" value="{{$danhMucDetail->ten_danh_muc}}" class="form-control {{$errors->has('name') ? "is-invalid" : ""}}">
            @if ($errors->has('name'))
                <p class="error-message">* {{$errors->first('name')}}</p>
            @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Danh mục cha</label>
        <div class="col-sm-10">
            <select name="parent_id" class="form-control">
                <option value="0">Danh mục cha</option>
                @php
                function printCategoryRow($danhMuc, $level = 0, $danhMucDetailParentIdAlt, $danhMucDetailId) {
                    echo '<option '.(($danhMucDetailParentIdAlt == $danhMuc->id) ? "selected " : "").(($danhMucDetailId == $danhMuc->id) ? "disabled " : "").' value="'.$danhMuc->id.'">'.str_repeat('--', $level).' '.$danhMuc->ten_danh_muc.'</option>';
                    if ($danhMuc->children->count() > 0) {
                        foreach ($danhMuc->children as $child) {
                            printCategoryRow($child, $level + 1, $danhMucDetailParentIdAlt, $danhMucDetailId);
                        }
                    }
                }
                @endphp
                @php
                    if (!isset($danhMucDetail->parent->id)) {
                        $danhMucDetailParentId = 0;
                    }else{
                        $danhMucDetailParentId = $danhMucDetail->parent->id;
                    }
                @endphp
                @foreach ($listDanhMuc as $danhMuc)
                @if ($danhMuc->danh_muc_cha_id == null) <!-- Chỉ hiển thị danh mục cha -->
                    @php printCategoryRow($danhMuc, 0, $danhMucDetailParentId, $danhMucDetail->id); @endphp
                @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Ảnh</label>

        <div class="col-sm-10"><input type="file" name="image" class="custom-file-input {{$errors->has('image') ? "is-invalid" : ""}}" onchange="showImage(event)">
            <img src="{{".".Storage::url($danhMucDetail->anh_danh_muc)}}" style="margin-top: 5px; width:40px; object-fit: cover; aspect-ratio: 1/1; {{$danhMucDetail->anh_danh_muc === NULL ? "display: none" : ""}}" id="image_danh_muc" alt="image">
            @if ($errors->has('image'))
            <p class="error-message">* {{$errors->first('image')}}</p>
          @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            <button class="btn btn-white" type="reset" style="margin-right: 2px;">Hủy</button>
            <button class="btn btn-primary" type="submit">Cập nhật</button>
        </div>
    </div>
</form>
<script>
    function showImage(event){
     const image_danh_muc = document.getElementById('image_danh_muc');
     const file = event.target.files[0];
     const render = new FileReader();
     render.onload = function () {
        image_danh_muc.src = render.result;
        image_danh_muc.style.display = "block";
     }
     if(file){
        render.readAsDataURL(file);
     }
    }
</script>