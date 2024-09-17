<form id="form_filter" action="{{route('donhang.index')}}" method="get">
<div class="filter-wrapper">
    <div class="uk-flex uk-flex-middle uk-flex-space-between">
        <div class="perpage">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <select name="perpage" onchange="submitForm()" class="form-control input-sm perpage filter mr10">
                    <option value="5" {{$perPage==5 ? "selected" : ""}}>5 đơn hàng</option>
                    <option value="8" {{$perPage==8 ? "selected" : ""}}>8 đơn hàng</option>
                    <option value="10" {{$perPage==10 ? "selected" : ""}}>10 đơn hàng</option>
                    <option value="15" {{$perPage==15 ? "selected" : ""}}>15 đơn hàng</option>
                    <option value="18" {{$perPage==18 ? "selected" : ""}}>18 đơn hàng</option>
                    <option value="20" {{$perPage==20 ? "selected" : ""}}>20 đơn hàng</option>
                    <option value="25" {{$perPage==25 ? "selected" : ""}}>25 đơn hàng</option>
                </select>
            </div>
        </div>
        <div class="action">
            <div class="uk-flex uk-flex-middle">
                <div class="mr10">
                 <select name="version" id="" class="form-control" onchange="submitForm()">
                    <option {{$orderBy=='DESC' ? "selected" : ""}} value="DESC">Mới nhất</option>
                    <option {{$orderBy=='ASC' ? "selected" : ""}} value="ASC">Cũ nhất</option>
                 </select>
                </div>
                <div class="mr10">
                    <select name="status_order" id="" class="form-control" 
                    onchange="submitForm()"
                    >
                        <option value="0">Lọc theo trạng thái</option>
                        @foreach($listTrangThaiDonHang as $key => $value)
                        <option {{$statusOrder == $value->id ? "selected" : ""}} value="{{$value->id}}">{{$value->ten_trang_thai_don_hang}}</option>
                        @endforeach
                     </select>
                </div>
                <div class="uk-search uk-flex uk-flex-middle mr10">
                    <div class="input-group">
                        <input type="text" name="keyword" placeholder="Nhập mã đơn hàng" id="keyword-input" class="form-control">
                        <span class="input-group-btn">
                            <button type="button"
                                class="btn btn-info mb0 btn-sm" onclick="validateAndSubmit()">Tìm kiếm</button>
                        </span>
                    </div>
                </div>
                <a href="{{route('donhang.create')}}"><button type="button" class="btn btn-primary"><i
                            class="fa fa-plus mr5"></i>Thêm mới đơn hàng</button></a>
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