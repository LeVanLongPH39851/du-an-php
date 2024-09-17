<form method="post" action="{{route('donhang.update', $donHangDetail->id)}}" class="form-horizontal">
    @csrf
    @method('put')
    <div class="form-group"><label class="col-sm-2 control-label">Trạng Thái</label>

        <div class="col-sm-10"><select name="status_order" class="form-control">
            @foreach ($listTrangThaiDonHang as $key => $value)
               <option {{$donHangDetail->trang_thai_don_hang_id === $value->id ? 'selected' : ''}}
                {{$donHangDetail->trang_thai_don_hang_id > $value->id ? "disabled" : ''}}
                value="{{$value->id}}">{{$value->ten_trang_thai_don_hang}}</option>
            @endforeach
            </select></div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            <button class="btn btn-white" type="reset" style="margin-right: 2px;">Hủy</button>
            <button class="btn btn-primary" type="submit">Cập nhật</button>
        </div>
    </div>
</form>
