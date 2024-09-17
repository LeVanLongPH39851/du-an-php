<form action="{{route('slideshow.store')}}" method="post" enctype="multipart/form-data">
    @csrf
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
                <input type="text" class="form-control" name="name" placeholder="Nhập tên slide show">
              </div>
              <div class="form-group"><label class="font-normal">Trạng thái</label>
                <div><label> <input type="radio" checked="" value="1" id="optionsRadios1" name="optionsRadios"> Apply</label></div>
                <div><label> <input type="radio" value="0" id="optionsRadios2" name="optionsRadios"> No Apply</label></div>
              </div>
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
                            <button class="btn btn-primary" type="submit">Thêm mới</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>
</form>