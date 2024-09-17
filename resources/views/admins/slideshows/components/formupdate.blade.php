<form id="radioForm" action="{{route('slideshow.update', $slideShowDetail->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="row">
        <div class="col-lg-5">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
              <h5>
                Thông Tin Slide Show
              </h5>
              @include('admins.slideshows.components.toolbox')
            </div>
            <div class="ibox-content">
              <div class="form-group">
                <label class="font-normal">Tên slide show</label>
                <input type="text" class="form-control" value="{{$slideShowDetail->ten_slide_show}}" name="name" placeholder="Nhập tên slide show">
              </div>
              <div class="form-group"><label class="font-normal">Trạng thái</label>
                <div class="row">
                  <div class="col-sm-4">
                    <div><label> <input type="radio" {{$slideShowDetail->active == 1 ? 'checked' : ''}} value="1" name="optionsRadios"> Aplly</label></div>
              <div><label> <input type="radio" {{$slideShowDetail->active == 0 ? 'checked' : ''}} value="0" name="optionsRadios"> No Apply</label></div>
                  </div>
                  <div class="col-sm-8">
                    <div class="row" style="margin-bottom: 10px;">
                      <div class="col-sm-4" style="padding-left: 0; padding-right: 0">
                        <div style="display: flex">
                          <input type="checkbox" {{$slideShowDetail->arrows == 1 ? 'checked' : ''}} class="form-check-input" value="1" style="margin-top: 0; margin-right: 2px;" name="arrows">
                                  <label class="form-check-label" style="margin-bottom: 0">Arrows</label>
                        </div>
                      </div>
                      <div class="col-sm-4" style="padding-left: 0; padding-right: 0">
                        <div style="display: flex">
                          <input type="checkbox" {{$slideShowDetail->dots == 1 ? 'checked' : ''}} class="form-check-input" value="1" style="margin-top: 0; margin-right: 2px;" name="dots">
                                  <label class="form-check-label" style="margin-bottom: 0">Dots</label>
                        </div>
                      </div>
                      <div class="col-sm-4" style="padding-left: 0; padding-right: 0">
                        <div style="display: flex">
                          <input type="checkbox" {{$slideShowDetail->fade == 1 ? 'checked' : ''}} class="form-check-input" value="1" style="margin-top: 0; margin-right: 2px;" name="fade">
                                  <label class="form-check-label" style="margin-bottom: 0">Fade</label>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4" style="padding-left: 0; padding-right: 0">
                        <div style="display: flex">
                          <input type="checkbox" {{$slideShowDetail->infinite == 1 ? 'checked' : ''}} class="form-check-input" value="1" style="margin-top: 0; margin-right: 2px;" name="infinite">
                                  <label class="form-check-label" style="margin-bottom: 0">Infinite</label>
                        </div>
                      </div>
                      <div class="col-sm-4" style="padding-left: 0; padding-right: 0">
                        <div style="display: flex">
                          <input type="checkbox" {{$slideShowDetail->auto_play == 1 ? 'checked' : ''}} class="form-check-input" value="1" style="margin-top: 0; margin-right: 2px;" name="autoplay">
                                  <label class="form-check-label" style="margin-bottom: 0">Autoplay</label>
                        </div>
                      </div>
                      <div class="col-sm-4" style="padding-left: 0; padding-right: 0">
                        <div style="display: flex; align-items: center">
                          <label class="form-check-label" style="margin-bottom: 0">Speed</label>
                          <input type="number" min="1000" max="6000" class="form-check-input form-control" value="{{$slideShowDetail->speed}}" style="height: 25px; margin-left: 2px; font-size: 12px" name="speed">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                <label class="font-normal">Hình ảnh hiện tại</label>
                @forelse ($listAnhSlideShowDetail as $key => $value)
                <div class="row" style="margin-bottom: 5px">
                    <div class="col-md-4">
                        <img src="{{'.'.Storage::url($value->duong_dan_anh)}}" style="width: 100%;"  alt="Slide Show Image">
                        <div class="form-check" style="margin-top: 1px; display: flex; align-items: center; justify-content: center">
                            <input type="checkbox" class="form-check-input" style="margin-top: 0; margin-right: 2px" name="delete_images[]" value="{{ $value->id }}">
                            <label class="form-check-label" style="margin-bottom: 0">Xóa</label>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group" style="margin-bottom: 10px">
                            <input type="hidden" name="id_album_slide_show[]" value="{{$value->id}}">
                            <select name="links[]" class="form-control" style="font-size: 13px">
                                <option value="0">Nhập link sản phẩm</option>
                                @foreach($listSanPham as $keySanPham => $valueSanPham)
                                <option {{$value->link == $valueSanPham->id ? 'selected' : ''}} value="{{$valueSanPham->id}}">{{$valueSanPham->ten_san_pham}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-normal">Thứ tự xuất hiện</label>
                            <div class="row" style="margin-bottom: 5px">
                                @foreach ($listAnhSlideShowDetail as $keyAnhSlideShowDetail => $valueAnhSlideShowDetail)
                                <div class="col-md-2">
                                    <div class="form-check" style="display: flex; align-items: center;">
                                        <input type="radio" {{$listOrder[$key]['order'] == $loop->iteration ? 'checked' : ''}} class="form-check-input check_checked" value="{{$loop->iteration}}" style="margin-top: 0; margin-right: 2px;" name="orders[{{$value->id}}]">
                                        <label class="form-check-label" style="margin-bottom: 0">{{$loop->iteration}}</label>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p style="margin-bottom: 0; font-size: 12px">Slide show này chưa có ảnh nào</p>
                @endforelse
            </div>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
              <h5>
                Thêm Nhiều Hình Ảnh
              </h5>
              @include('admins.slideshows.components.toolbox')
            </div>
            <div class="ibox-content">
              <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="file-upload-wrapper">
                            <input type="file" name="slides[]" id="file-upload" class="file-slides" multiple>
                            <label for="file-upload" class="file-upload-label"><i class="fa fa-upload" style="font-size: 50px"></i></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12" style="display: flex; justify-content: end">
                            <button class="btn btn-white" type="reset" style="margin-right: 5px;">Hủy</button>
                            <button class="btn btn-primary" type="submit">Cập nhật</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>
</form>
<script>
    document.getElementById('radioForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Ngăn chặn form gửi đi

        const radios = document.querySelectorAll('.check_checked:checked');
        const selectedValues = {};

        for (let radio of radios) {
            const value = radio.value;
            if (selectedValues[value]) {
                alert('Thứ tự thứ ' + value + ' đã trùng lập');
                return;
            }
            selectedValues[value] = true;
        }

        // Nếu không có giá trị trùng lặp, gửi form
        this.submit();
    });
</script>