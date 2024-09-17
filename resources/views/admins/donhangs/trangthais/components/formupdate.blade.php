<form method="post" action="{{route('trangthaidonhang.update', $trangThaiDonHangDetail->id)}}" class="form-horizontal">
    @csrf
    @method('put')
    <div class="form-group"><label class="col-sm-2 control-label">Mã trạng thái</label>

        <div class="col-sm-10"><input type="text" name="id" disabled value="{{$trangThaiDonHangDetail->ma_trang_thai_don_hang}}" class="form-control"></div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Tên trạng thái <span class="text-danger">(*)</span></label>

        <div class="col-sm-10"><input type="text" name="name" value="{{$trangThaiDonHangDetail->ten_trang_thai_don_hang}}" class="form-control {{$errors->has('name') ? "is-invalid" : ""}}">
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