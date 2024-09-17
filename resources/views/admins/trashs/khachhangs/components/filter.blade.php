<form id="form_filter" action="{{route('khachhangtrash.index')}}" method="get">
    <div class="filter-wrapper">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div class="perpage">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <select name="perpage" onchange="submitForm()" class="form-control input-sm perpage filter mr10">
                        <option value="8" {{$perPage==8 ? "selected" : ""}}>8 khách hàng</option>
                        <option value="10" {{$perPage==10 ? "selected" : ""}}>10 khách hàng</option>
                        <option value="15" {{$perPage==15 ? "selected" : ""}}>15 khách hàng</option>
                        <option value="20" {{$perPage==20 ? "selected" : ""}}>20 khách hàng</option>
                        <option value="25" {{$perPage==25 ? "selected" : ""}}>25 khách hàng</option>
                        <option value="30" {{$perPage==30 ? "selected" : ""}}>30 khách hàng</option>
                    </select>
                </div>
            </div>
            <div class="action">
                <div class="uk-flex uk-flex-middle">
                    <div class="mr10">
                        <select name="role" id="" class="form-control" onchange="submitForm()">
                            <option value="0">Lọc theo vai trò</option>
                            <option {{$role == 1 ? "selected" : ""}} value="1">user</option>
                            <option {{$role == 2 ? "selected" : ""}} value="2">admin</option>
                         </select>
                    </div>
                    <div class="uk-search uk-flex uk-flex-middle mr10">
                        <div class="input-group">
                            <input type="text" name="keyword" placeholder="Nhập tên khách hàng" id="keyword-input" class="form-control">
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
                alert("Vui lòng nhập tên khách hàng trước khi tìm kiếm.");
                return false;
            }
            document.getElementById('form_filter').submit();
        }
      </script>