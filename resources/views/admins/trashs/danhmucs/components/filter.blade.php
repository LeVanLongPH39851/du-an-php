<form id="form_filter" action="{{route('danhmuctrash.index')}}" method="get">
    <div class="filter-wrapper">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div class="perpage">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <select name="perpage" onchange="submitForm()" class="form-control input-sm perpage filter mr10">
                        <option value="3" {{$perPage==3 ? "selected" : ""}}>3 danh mục</option>
                        <option value="5" {{$perPage==5 ? "selected" : ""}}>5 danh mục</option>
                        <option value="8" {{$perPage==8 ? "selected" : ""}}>8 danh mục</option>
                        <option value="10" {{$perPage==10 ? "selected" : ""}}>10 danh mục</option>
                        <option value="12" {{$perPage==12 ? "selected" : ""}}>12 danh mục</option>
                        <option value="15" {{$perPage==15 ? "selected" : ""}}>15 danh mục</option>
                    </select>
                </div>
            </div>
            <div class="action">
                <div class="uk-flex uk-flex-middle">
                    <div class="uk-search uk-flex uk-flex-middle mr10">
                        <div class="input-group">
                            <input type="text" name="keyword" placeholder="Nhập tên danh mục" id="keyword-input" class="form-control">
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
                alert("Vui lòng nhập tên danh mục trước khi tìm kiếm.");
                return false;
            }
            document.getElementById('form_filter').submit();
        }
      </script>