<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<form method="post" action="{{route('sanpham.update', $sanPhamDetail->id)}}" enctype="multipart/form-data" class="form-horizontal">
    @csrf
    @method('put')
    <div class="form-group"><label class="col-sm-2 control-label">Mã sản phẩm</label>

        <div class="col-sm-10"><input type="text" name="id" disabled value="{{$sanPhamDetail->ma_san_pham}}" class="form-control"></div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Tên sản phẩm <span
                class="text-danger">(*)</span></label>
        <div class="col-sm-10"><input type="text" value="{{$sanPhamDetail->ten_san_pham}}" name="name" class="form-control {{$errors->has('name') ? "is-invalid" : ""}}">
            @if ($errors->has('name'))
            <p class="error-message">* {{$errors->first('name')}}</p>
          @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Ảnh <span class="text-danger">(*)</span></label>

        <div class="col-sm-10"><input type="file" class="custom-file-input {{$errors->has('image') ? "is-invalid" : ""}}" name="image" onchange="showImage(event)">
            <img src="{{".".Storage::url($sanPhamDetail->anh_san_pham)}}" style="margin-top: 5px; width:40px; object-fit: cover; aspect-ratio: 1/1;" id="image_san_pham" alt="image">
            @if ($errors->has('image'))
            <p class="error-message">* {{$errors->first('image')}}</p>
          @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Giá <span class="text-danger">(*)</span></label>

        <div class="col-sm-10"><input type="text" value="{{$sanPhamDetail->gia}}" name="price" class="form-control {{$errors->has('price') ? "is-invalid" : ""}}">
            @if ($errors->has('price'))
            <p class="error-message">* {{$errors->first('price')}}</p>
          @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Giá khuyến mãi</label>
    
        <div class="col-sm-10"><input type="number" placeholder="có thể trống" id="promotion-price" value="{{$sanPhamDetail->gia_khuyen_mai}}" name="promotion_price" oninput="toggleDateInput()" class="form-control {{$errors->has('promotion_price') ? "is-invalid" : ""}}">
            @if ($errors->has('promotion_price'))
            <p class="error-message">* {{$errors->first('promotion_price')}}</p>
          @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Ngày hết khuyến mãi</label>

        <div class="col-sm-10"><input type="date" id="promotion-end-date" value="{{$sanPhamDetail->ngay_ket_thuc_km}}" disabled name="promotion_end_date" class="form-control {{$errors->has('promotion_end_date') ? "is-invalid" : ""}}">
            @if ($errors->has('promotion_end_date'))
            <p class="error-message">* {{$errors->first('promotion_end_date')}}</p>
          @endif
          <span class="help-block m-b-none">Nếu không nhập ngày ngày hết khuyến mãi, sản phẩm sẽ hết khuyến mãi cho đến khi bạn sửa đổi</span>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Số lượng <span class="text-danger">(*)</span></label>

        <div class="col-sm-10"><input type="text" value="{{$sanPhamDetail->so_luong}}" placeholder="0" name="quantity" class="form-control {{$errors->has('quantity') ? "is-invalid" : ""}}">
            @if ($errors->has('quantity'))
            <p class="error-message">* {{$errors->first('quantity')}}</p>
          @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Mô tả ngắn</label>
        <div class="col-sm-10"><textarea name="short-description" class="form-control" id="short-content" >{!!$sanPhamDetail->mo_ta_ngan!!}</textarea>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Mô tả chi tiết</label>

        <div class="col-sm-10"><textarea name="description" class="form-control" id="content" >{!!$sanPhamDetail->mo_ta!!}</textarea>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Danh Mục</label>

        <div class="col-sm-10"><select name="category" class="form-control" id="">
            @php
                function printCategoryRow($danhMuc, $level = 0, $sanPhamDetailDanhMucId) {
                    echo '<option '.(($sanPhamDetailDanhMucId == $danhMuc->id) ? "selected" : "").' value="'.$danhMuc->id.'">'.str_repeat('--', $level).' '.$danhMuc->ten_danh_muc.'</option>';
                    if ($danhMuc->children->count() > 0) {
                        foreach ($danhMuc->children as $child) {
                            printCategoryRow($child, $level + 1, $sanPhamDetailDanhMucId);
                        }
                    }
                }
                @endphp
                @foreach ($listDanhMuc as $danhMuc)
                @if ($danhMuc->danh_muc_cha_id == null) <!-- Chỉ hiển thị danh mục cha -->
                    @php printCategoryRow($danhMuc, 0, $sanPhamDetail->danh_muc_id); @endphp
                @endif
                @endforeach
            </select></div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Album ảnh hiện tại</label>

        <div class="col-sm-10">
            @forelse($listAlbumAnh as $key => $value)
                        <div class="col-md-2" style="margin-bottom: 3px">
                            <div style="display: flex; align-items: center; overflow: hidden; width: 90px; aspect-ratio: 1/1">
                                <div><img src="{{'.'.Storage::url($value->duong_dan_anh)}}" style="width: 100%;"  alt="Product Image"></div>
                            </div>
                            <div class="form-check" style="display: flex; align-items: center">
                                <input type="checkbox" class="form-check-input" style="margin-top: 0; margin-right: 2px" name="delete_images[]" value="{{ $value->id }}">
                                <label class="form-check-label" style="margin-bottom: 0" for="delete_images">Xóa</label>
                            </div>
                        </div>
                        @empty
                        <div style="padding-top: 7px">Sản phầm này chưa có album ảnh</div>
            @endforelse
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Thêm ảnh vào Album</label>

        <div class="col-sm-10"> 
            <input type="file" class="custom-file-input custom-file-album" name="album_anhs[]" multiple/>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Sản phẩm nổi bật</label>
        <div class="col-sm-10" style="padding-top: 6px; padding-bottom: 6px">
            <div><label style="display: flex; align-items: center; margin-bottom: 0; font-weight: normal"><input type="checkbox" {{$sanPhamDetail->noi_bat == 1 ? 'checked' : ''}} style="margin-top: 0; margin-right: 3px" name="featured">Đặt là sản phẩm nổi bật</label></div>
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
        ClassicEditor
        .create(document.querySelector('#short-content'))
        .catch(error => {
            console.error(error);
        });
    </script>
<script>
    function toggleDateInput() {
        const promotionPrice = document.getElementById('promotion-price');
        const promotionEndDate = document.getElementById('promotion-end-date');

        if (promotionPrice.value.trim() !== "") {
            promotionEndDate.disabled = false;
        } else {
            promotionEndDate.disabled = true;
        }
    }
    if(document.getElementById('promotion-price') && document.getElementById('promotion-end-date')){
        document.addEventListener('DOMContentLoaded', function () {
    toggleDateInput();
    });
    }
</script>    