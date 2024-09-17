<form id="form_filter" action="{{route('sanphamtrash.index')}}" method="get">
<div class="filter-wrapper">
    <div class="uk-flex uk-flex-middle uk-flex-space-between">
        <div class="perpage">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <select name="perpage" onchange="submitForm()" class="form-control input-sm perpage filter mr10">
                    <option value="5" {{$perPage==5 ? "selected" : ""}}>5 sản phẩm</option>
                    <option value="8" {{$perPage==8 ? "selected" : ""}}>8 sản phẩm</option>
                    <option value="10" {{$perPage==10 ? "selected" : ""}}>10 sản phẩm</option>
                    <option value="12" {{$perPage==12 ? "selected" : ""}}>12 sản phẩm</option>
                    <option value="16" {{$perPage==16 ? "selected" : ""}}>16 sản phẩm</option>
                    <option value="18" {{$perPage==18 ? "selected" : ""}}>18 sản phẩm</option>
                    <option value="20" {{$perPage==20 ? "selected" : ""}}>20 sản phẩm</option>
                </select>
            </div>
        </div>
        <div class="action">
            <div class="uk-flex uk-flex-middle">
                <div class="mr10">
                    <select name="category" id="" class="form-control" onchange="submitForm()">
                        <option value="0">Lọc theo danh mục</option>
                        @foreach($listDanhMuc as $key => $value)
                        <option {{$category == $value->id ? "selected" : ""}} value="{{$value->id}}">{{$value->ten_danh_muc}}</option>
                        @endforeach
                     </select>
                </div>
                <div class="uk-search uk-flex uk-flex-middle mr10">
                    <div class="input-group">
                        <input type="text" name="keyword" placeholder="Nhập tên sản phẩm" id="keyword-input" class="form-control">
                        <span class="input-group-btn">
                            <button type="button"
                                class="btn btn-info mb0 btn-sm" onclick="validateAndSubmit()">Tìm kiếm</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<script>
    function submitForm() {
      document.getElementById('form_filter').submit();
      }
      function validateAndSubmit() {
        var keyword = document.getElementById('keyword-input').value;
        if (keyword.trim() === "") {
            alert("Vui lòng nhập tên sản phẩm trước khi tìm kiếm.");
            return false;
        }
        document.getElementById('form_filter').submit();
    }
  </script>