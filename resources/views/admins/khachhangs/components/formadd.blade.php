<form method="post" action="{{route('khachhang.store')}}" enctype="multipart/form-data" class="form-horizontal">
    @csrf
    <div class="form-group"><label class="col-sm-2 control-label">Mã khách hàng</label>

        <div class="col-sm-10"><input type="text" name="id" disabled placeholder="Auto String" class="form-control"></div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Họ và tên <span class="text-danger">(*)</span></label>

        <div class="col-sm-10"><input type="text" name="name" placeholder="Nhập tên khách hàng" value="{{old('name')}}" class="form-control {{$errors->has('name') ? "is-invalid" : ""}}">
            @if ($errors->has('name'))
              <p class="error-message">* {{$errors->first('name')}}</p>
            @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Số điện thoại <span
                class="text-danger">(*)</span></label>
        <div class="col-sm-10"><input type="text" name="phone" placeholder="Nhập số điện thoại" value="{{old('phone')}}" class="form-control {{$errors->has('phone') ? "is-invalid" : ""}}">
            @if ($errors->has('phone'))
              <p class="error-message">* {{$errors->first('phone')}}</p>
            @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Email <span class="text-danger">(*)</span></label>

        <div class="col-sm-10"><input type="text" name="email" value="{{old('email')}}" class="form-control {{$errors->has('email') ? "is-invalid" : ""}}" placeholder="example@gmail.com" name="email">
            @if ($errors->has('email'))
              <p class="error-message">* {{$errors->first('email')}}</p>
            @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Địa chỉ <span class="text-danger">(*)</span></label>

        <div class="col-sm-10"><input type="text" name="address" value="{{old('address')}}" placeholder="Nhập địa chỉ cụ thể" class="form-control {{$errors->has('address') ? "is-invalid" : ""}}">
            @if ($errors->has('address'))
            <p class="error-message">* {{$errors->first('address')}}</p>
          @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Avatar</label>

        <div class="col-sm-10"><input type="file" name="image" value="{{old('image')}}" class="custom-file-input {{$errors->has('image') ? "is-invalid" : ""}}" onchange="showImage(event)">
        <img src="" style="margin-top: 5px; width:40px; object-fit: cover; aspect-ratio: 1/1; display: none" id="image_khach_hang" alt="image">
        @if ($errors->has('image'))
            <p class="error-message">* {{$errors->first('image')}}</p>
          @endif
       </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Mật khẩu <span class="text-danger">(*)</span></label>

        <div class="col-sm-10"><input type="password" name="password" value="{{old('password')}}" class="form-control {{$errors->has('password') ? "is-invalid" : ""}}">
            @if ($errors->has('password'))
            <p class="error-message">* {{$errors->first('password')}}</p>
          @endif</div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Vai trò</label>

        <div class="col-sm-10"><select name="role" class="form-control" id="">
                <option value="1">user</option>
                <option value="2">admin</option>
            </select></div>
    </div>
    <div class="hr-line-dashed"></div>
    {{-- <div class="form-group"><label class="col-sm-2 control-label">Trạng thái <br>
            <small class="text-navy">Tình trạng</small></label>

        <div class="col-sm-10">
            <div><label> <input type="radio" checked="" value="option1" id="optionsRadios1" name="optionsRadios"> Hoạt
                    động</label></div>
            <div><label> <input type="radio" value="option2" id="optionsRadios2" name="optionsRadios"> Không hoạt
                    động</label></div>
        </div>
    </div>
    <div class="hr-line-dashed"></div> --}}
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            <button class="btn btn-white" type="reset" style="margin-right: 2px;">Hủy</button>
            <button class="btn btn-primary" type="submit">Thêm mới</button>
        </div>
    </div>
</form>
<script>
    function showImage(event){
     const image_khach_hang = document.getElementById('image_khach_hang');
     const file = event.target.files[0];
     const render = new FileReader();
     render.onload = function () {
        image_khach_hang.src = render.result;
        image_khach_hang.style.display = "block";
     }
     if(file){
        render.readAsDataURL(file);
     }
    }
</script>