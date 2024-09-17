<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<form method="post" action="{{route('baiviet.update', $baiVietDetail->id)}}" enctype="multipart/form-data" class="form-horizontal">
    @csrf
    @method("put")
    <div class="form-group"><label class="col-sm-2 control-label">Mã bài viết</label>

        <div class="col-sm-10"><input type="text" name="id" disabled value="{{$baiVietDetail->ma_bai_viet}}" class="form-control"></div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Tiêu đề bài viết <span
                class="text-danger">(*)</span></label>
        <div class="col-sm-10"><input type="text" name="name" value="{{$baiVietDetail->tieu_de}}" placeholder="Nhập tiêu đề bài viết" class="form-control {{$errors->has('name') ? "is-invalid" : ""}}">
            @if ($errors->has('name'))
            <p class="error-message">* {{$errors->first('name')}}</p>
          @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Ảnh đại diện <span class="text-danger">(*)</span></label>

        <div class="col-sm-10"><input type="file" class="custom-file-input {{$errors->has('image') ? "is-invalid" : ""}}" name="image" onchange="showImage(event)">
            <img src="{{'.'.Storage::url($baiVietDetail->anh_bai_viet)}}" style="margin-top: 5px; width:40px" id="image_san_pham" alt="image">
            @if ($errors->has('image'))
            <p class="error-message">* {{$errors->first('image')}}</p>
          @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Nội dung bài viết <span
        class="text-danger">(*)</span></label>
        <div class="col-sm-10"><textarea name="content" class="form-control" id="content" placeholder="Nhập nội dung bài viết">{{$baiVietDetail->noi_dung}}</textarea>
            @if ($errors->has('content'))
            <p class="error-message">* {{$errors->first('content')}}</p>
          @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Bài viết cho sản phẩm</label>
        <div class="col-sm-10">
         <select name="id_san_pham" class="form-control">
            @foreach ($listSanPham as $key => $value)
                <option {{$baiVietDetail->san_pham_id == $value->id ? "selected" : ""}} value="{{$value->id}}">{{$value->ten_san_pham}}</option>
            @endforeach
         </select>
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
     const image_san_pham = document.getElementById('image_san_pham');
     const file = event.target.files[0];
     const render = new FileReader();
     render.onload = function () {
        image_san_pham.src = render.result;
        image_san_pham.style.display = "block";
     }
     if(file){
        render.readAsDataURL(file);
     }
    }
</script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'))
        .catch(error => {
            console.error(error);
        });
</script>