<form method="post" action="{{route('hinhthucthanhtoan.update', $hinhThucThanhToanDetail->id)}}" class="form-horizontal">
    @csrf
    @method('put')
    <div class="form-group"><label class="col-sm-2 control-label">Mã hình thức</label>

        <div class="col-sm-10"><input type="text" name="id" disabled value="{{$hinhThucThanhToanDetail->ma_phuong_thuc_thanh_toan}}" class="form-control"></div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Tên hình thức <span class="text-danger">(*)</span></label>

        <div class="col-sm-10"><input type="text" name="name" value="{{$hinhThucThanhToanDetail->ten_phuong_thuc_thanh_toan}}" class="form-control {{$errors->has('name') ? "is-invalid" : ""}}">
            @if ($errors->has('name'))
                <p class="error-message">* {{$errors->first('name')}}</p>
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