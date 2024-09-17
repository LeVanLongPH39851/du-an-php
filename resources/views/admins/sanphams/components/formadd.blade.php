<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<form method="post" action="{{route('sanpham.store')}}" class="form-horizontal" enctype="multipart/form-data">
    @csrf
     {{-- CSRF Field: là một trường ẩn mà laravel bắt buộc nhúng vào form cho mục đích bảo vệ website  --}}
     <input type="hidden" id="selectedType" name="selectedType" value="{{ old('selectedType', '1') }}">
     <div class="form-group"><label class="col-sm-2 control-label">Kiểu sản phẩm</label>

        <div class="col-sm-10"><select name="type" class="form-control">
            <option value="1" {{ old('type', '1') == '1' ? 'selected' : '' }}>Sản phẩm đơn giản</option>
            <option value="2" {{ old('type') == '2' ? 'selected' : '' }}>Sản phẩm biến thể</option>
            </select></div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Mã sản phẩm</label>

        <div class="col-sm-10">
            <input type="text" name="id" placeholder="Auto String" disabled class="form-control">
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Tên sản phẩm <span
                class="text-danger">(*)</span></label>
        <div class="col-sm-10"><input type="text" name="name" placeholder="Nhập tên sản phẩm" value="{{old('name')}}" class="form-control {{$errors->has('name') ? "is-invalid" : ""}}">
            @if ($errors->has('name'))
                <p class="error-message">* {{$errors->first('name')}}</p>
            @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Ảnh <span class="text-danger">(*)</span></label>

        <div class="col-sm-10"><input type="file" class="custom-file-input {{$errors->has('image') ? "is-invalid" : ""}}" name="image" onchange="showImage(event)">
            <img src="" style="margin-top: 5px; width:40px; object-fit: cover; aspect-ratio: 1/1; display: none" id="image_san_pham" alt="image">
            @if ($errors->has('image'))
            <p class="error-message">* {{$errors->first('image')}}</p>
          @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div id="change-form-simple-product" style="display: {{ old('selectedType', '1') == '1' ? 'block' : 'none' }}">
        <div class="form-group"><label class="col-sm-2 control-label">Giá <span class="text-danger">(*)</span></label>
    
            <div class="col-sm-10"><input type="number" placeholder="0" value="{{old('price')}}" name="price" class="form-control {{$errors->has('price') ? "is-invalid" : ""}}">
                @if ($errors->has('price'))
                <p class="error-message">* {{$errors->first('price')}}</p>
              @endif
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group"><label class="col-sm-2 control-label">Giá khuyến mãi</label>
    
            <div class="col-sm-10"><input type="number" placeholder="có thể trống" id="promotion-price" value="{{old('promotion_price')}}" name="promotion_price" oninput="toggleDateInput()" class="form-control {{$errors->has('promotion_price') ? "is-invalid" : ""}}">
                @if ($errors->has('promotion_price'))
                <p class="error-message">* {{$errors->first('promotion_price')}}</p>
              @endif
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group"><label class="col-sm-2 control-label">Ngày hết khuyến mãi</label>
    
            <div class="col-sm-10"><input type="date" id="promotion-end-date" value="{{old('promotion_end_date')}}" disabled name="promotion_end_date" class="form-control {{$errors->has('promotion_end_date') ? "is-invalid" : ""}}">
                @if ($errors->has('promotion_end_date'))
                <p class="error-message">* {{$errors->first('promotion_end_date')}}</p>
              @endif
              <span class="help-block m-b-none">Nếu không nhập ngày ngày hết khuyến mãi, sản phẩm sẽ hết khuyến mãi cho đến khi bạn sửa đổi</span>
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group"><label class="col-sm-2 control-label">Số lượng <span class="text-danger">(*)</span></label>
    
            <div class="col-sm-10"><input type="number" placeholder="0" name="quantity" value="{{old("quantity")}}" class="form-control {{$errors->has('quantity') ? "is-invalid" : ""}}">
                @if ($errors->has('quantity'))
                <p class="error-message">* {{$errors->first('quantity')}}</p>
              @endif
            </div>
        </div>
        <div class="hr-line-dashed"></div>
    </div>
    <div id="change-form-variable-product" style="display: {{ old('selectedType') == '2' ? 'block' : 'none' }}">
        <div id="attribute-container">
            <!-- Khối thuộc tính ban đầu -->
            <div class="form-group attribute-item">
                <label class="col-sm-2 control-label">Tên thuộc tính <span class="text-danger">(*)</span></label>
                <div class="col-sm-2">
                    <input type="text" placeholder="VD: Size, Màu" class="form-control" name="atrribute_name[]" value="{{old('atrribute_name.0')}}">
                    <p class="error-message"></p>
                </div>
                <label class="col-sm-1 control-label">Giá trị <span class="text-danger">(*)</span></label>
                <div class="col-sm-6">
                    <textarea class="form-control" placeholder="Nhập các phương án để khách hàng lựa chọn, VD: “Xanh lam” hoặc “XL”. Sử dụng “|” để tách các lựa chọn khác nhau." name="value_names[]" rows="3">{{old('value_names.0')}}</textarea>
                    <p class="error-message"></p>
                </div>
            </div>
            @if (old('atrribute_name'))
            @foreach(old('atrribute_name') as $index => $name)
            @if($index > 0)
            <div class="form-group attribute-item">
                <label class="col-sm-2 control-label">Tên thuộc tính <span class="text-danger">(*)</span></label>
                <div class="col-sm-2">
                    <input type="text" placeholder="VD: Size, Màu" class="form-control" name="atrribute_name[]" value="{{old('atrribute_name.' . $index)}}">
                    <p class="error-message"></p>
                </div>
                <label class="col-sm-1 control-label">Giá trị <span class="text-danger">(*)</span></label>
                <div class="col-sm-6">
                    <textarea class="form-control" placeholder="Nhập các phương án để khách hàng lựa chọn, VD: “Xanh lam” hoặc “XL”. Sử dụng “|” để tách các lựa chọn khác nhau." name="value_names[]" rows="3">{{old('value_names.' . $index)}}</textarea>
                    <p class="error-message"></p>
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-danger remove-attribute-btn" type="button">Xóa</button>
                </div>
            </div>
            @endif
            @endforeach
            @endif
        </div>    
        <div class="form-group">
            <label class="col-sm-3 control-label">
                <button class="btn btn-primary" type="button" id="add-attribute-btn" style="margin-right: 2px">Thêm thuộc tính</button>
                <button class="btn btn-success" type="button" id="save-btn">Lưu</button>
            </label>
        </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Các biến thể</label>
              <div class="col-sm-10">
               <div class="row" id="variants-container">
                <label class="control-label"><p style="font-weight: normal">Chưa có biến thể nào</p></label>
               </div>
              </div>
            </div>
        <div class="hr-line-dashed"></div>
    </div>
    <div class="form-group"><label class="col-sm-2 control-label">Mô tả ngắn</label>
        <div class="col-sm-10"><textarea name="short-description" class="form-control" id="short-content" >{{old("short-description")}}</textarea>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Mô tả chi tiết</label>
        <div class="col-sm-10"><textarea name="description" class="form-control" id="content" >{{old("description")}}</textarea>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Danh Mục</label>

        <div class="col-sm-10"><select name="category" class="form-control" id="">
            @php
            function printCategoryRow($danhMuc, $level = 0) {
                echo '<option value="'.$danhMuc->id.'">'.str_repeat('--', $level).' '.$danhMuc->ten_danh_muc.'</option>';
                if ($danhMuc->children->count() > 0) {
                    foreach ($danhMuc->children as $child) {
                        printCategoryRow($child, $level + 1);
                    }
                }
            }
            @endphp
            @foreach ($listDanhMuc as $danhMuc)
            @if ($danhMuc->danh_muc_cha_id == null) <!-- Chỉ hiển thị danh mục cha -->
                @php printCategoryRow($danhMuc); @endphp
            @endif
            @endforeach  
            </select></div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Album Ảnh</label>

        <div class="col-sm-10"> 
            <input type="file" class="custom-file-input custom-file-album" name="album_anhs[]" multiple/>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group"><label class="col-sm-2 control-label">Sản phẩm nổi bật</label>
        <div class="col-sm-10" style="padding-top: 6px; padding-bottom: 6px">
            <div><label style="display: flex; align-items: center; margin-bottom: 0; font-weight: normal"><input type="checkbox" style="margin-top: 0; margin-right: 3px" name="featured">Đặt là sản phẩm nổi bật</label></div>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-2">
            <button class="btn btn-white" type="reset" style="margin-right: 2px;">Hủy</button>
            <button class="btn btn-primary" type="submit">Thêm mới</button>
        </div>
    </div>
</form>
<script>
    function showImage(event){
     const image_san_pham = document.getElementById('image_san_pham');
     const file = event.target.files[0];
     const render = new FileReader();
     render.onload = function () {
        image_san_pham.src = render.result;
        image_san_pham.style.display = "block";
     }
     if(file){
        render.readAsDataURL(file);
     }
    }
</script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'))
        .catch(error => {
            console.error(error);
        });
        ClassicEditor
        .create(document.querySelector('#short-content'))
        .catch(error => {
            console.error(error);
        });
    </script>
<script>
const productTypeSelect = document.querySelector('select[name="type"]');
const changeFormSimpleProduct = document.getElementById('change-form-simple-product');
const changeFormVariableProduct = document.getElementById('change-form-variable-product');
const form = document.querySelector('form');
function toggleFormDisplay(type) {
                if (type === '1') {
                    changeFormSimpleProduct.style.display = 'block';
                    changeFormVariableProduct.style.display = 'none';
                } else {
                    changeFormSimpleProduct.style.display = 'none';
                    changeFormVariableProduct.style.display = 'block';
                }
                document.getElementById('selectedType').value = type; // Update hidden input field
            }

            // Initialize form display based on selected type
            toggleFormDisplay(productTypeSelect.value);

            // Event listener to save the selected type to hidden input field and toggle forms
            productTypeSelect.addEventListener('change', function () {
                toggleFormDisplay(productTypeSelect.value);
            });
            
        document.addEventListener("DOMContentLoaded", function () {
        const addAttributeBtn = document.getElementById('add-attribute-btn');
        const attributeContainer = document.getElementById('attribute-container');
        const attributeTemplate = `<div class="form-group attribute-item">
            <label class="col-sm-2 control-label">Tên thuộc tính <span class="text-danger">(*)</span></label>
            <div class="col-sm-2">
                <input type="text" placeholder="VD: Size, Màu" class="form-control" name="atrribute_name[]">
                <p class="error-message"></p>
                            </div>
            <label class="col-sm-1 control-label">Giá trị <span class="text-danger">(*)</span></label>
            <div class="col-sm-6">
                <textarea class="form-control" placeholder="Nhập các phương án để khách hàng lựa chọn, VD: “Xanh lam” hoặc “XL”. Sử dụng “|” để tách các lựa chọn khác nhau." name="value_names[]" rows="3"></textarea>
                <p class="error-message"></p>
            </div>
            <div class="col-sm-1">
                    <button class="btn btn-danger remove-attribute-btn" type="button">Xóa</button>
            </div>
        </div>`;

        addAttributeBtn.addEventListener('click', function () {
            attributeContainer.insertAdjacentHTML('beforeend', attributeTemplate);
        });

        attributeContainer.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-attribute-btn')) {
                const attributeItem = e.target.closest('.attribute-item');
                attributeItem.classList.add('fade-out');
                setTimeout(function() {
                    attributeItem.remove();
                }, 200); // Thời gian phù hợp với thời gian chuyển đổi của CSS
            }
        });
    });        
    document.getElementById('save-btn').addEventListener('click', function(event) {
    // Get all input fields with name 'atrribute_name[]'
    var attributeNameFields = document.querySelectorAll('input[name="atrribute_name[]"]');
    var valueNameFields = document.querySelectorAll('textarea[name="value_names[]"]');
    var valid = true;
    attributeNameFields.forEach(function(field) {
        var errorMessageElement = field.nextElementSibling;
        if (field.value.trim() === '') {
            valid = false;
            field.classList.add('is-invalid'); // Add an invalid class if the field is empty
            errorMessageElement.textContent = '* Vui lòng nhập thuộc tính'; // Set error message
        } else {
            field.classList.remove('is-invalid'); // Remove the invalid class if the field is not empty
            errorMessageElement.textContent = ''; // Clear error message
        }
    });
    valueNameFields.forEach(function(field) {
        var errorMessageElement = field.nextElementSibling;
        if (field.value.trim() === '') {
            valid = false;
            field.classList.add('is-invalid'); // Add an invalid class if the field is empty
            errorMessageElement.textContent = '* Vui lòng nhập giá trị thuộc tính'; // Set error message
        } else {
            field.classList.remove('is-invalid'); // Remove the invalid class if the field is not empty
            errorMessageElement.textContent = ''; // Clear error message
        }
    });
    if(valid){
        const valueArrays = Array.from(valueNameFields).map(input => input.value.split('|'));
            // Hàm đệ quy để kết hợp các giá trị
    function generateCombinations(arrays, prefix = []) {
        if (arrays.length === 0) {
            return [prefix.join(' ')];
        }
        
        const result = [];
        const [firstArray, ...restArrays] = arrays;

        for (const value of firstArray) {
            result.push(...generateCombinations(restArrays, [...prefix, value]));
        }

        return result;
    }

    const combinations = generateCombinations(valueArrays);
    const variantsContainer = document.getElementById('variants-container');
    showVariants = '';
    combinations.forEach(function(combination, index){
        showVariants += `<div class="col-sm-6">
                    <div class="ibox float-e-margins border-bottom">
                        <div class="ibox-title" style="border: 1px solid #e7eaec; border-bottom: none">
                            <h5>${combination}</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link collapse-link-variant">
                                    <i class="fa fa-chevron-down"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">Config option 1</a>
                                    </li>
                                    <li><a href="#">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content" style="border: 1px dashed #e7eaec; border-top: 1px solid #e7eaec;display: none">
                            <input type="hidden" name="variants[]" value="${combination}">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" name="id" placeholder="Mã biến thể" disabled class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="file" name="image-variant[]" placeholder="Ảnh đại điện" class="custom-file-input">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="number" name="price-variant[]" placeholder="Giá" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="number" name="quantity-variant[]" placeholder="Số lượng" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
    });
    variantsContainer.innerHTML = showVariants;
    // Gán lại các sự kiện collapse sau khi cập nhật innerHTML
    document.querySelectorAll('.collapse-link-variant').forEach(function(link) {
                link.addEventListener('click', function() {
                    const ibox = this.closest('.ibox');
                    const content = ibox.querySelector('.ibox-content');
                    if (content.style.display === 'none') {
                        ibox.classList.remove('border-bottom');
                        content.style.display = 'block';
                        this.querySelector('i').classList.remove('fa-chevron-down');
                        this.querySelector('i').classList.add('fa-chevron-up');
                    } else {
                        content.style.display = 'none';
                        ibox.classList.add('border-bottom');
                        this.querySelector('i').classList.remove('fa-chevron-up');
                        this.querySelector('i').classList.add('fa-chevron-down');
                    }
                });
            });
        }
});
document.querySelectorAll('input[name="atrribute_name[]"]').forEach(function(field) {
    field.addEventListener('input', function() {
        if (field.value.trim() !== '') {
            field.classList.remove('is-invalid');
            var errorMessageElement = field.nextElementSibling;
            errorMessageElement.textContent = '';
        }
    });
});
document.querySelectorAll('textarea[name="value_names[]"]').forEach(function(field) {
    field.addEventListener('input', function() {
        if (field.value.trim() !== '') {
            field.classList.remove('is-invalid');
            var errorMessageElement = field.nextElementSibling;
            errorMessageElement.textContent = '';
        }
    });
});
</script>
<script>
    function toggleDateInput() {
        const promotionPrice = document.getElementById('promotion-price');
        const promotionEndDate = document.getElementById('promotion-end-date');

        if (promotionPrice.value.trim() !== "") {
            promotionEndDate.disabled = false;
        } else {
            promotionEndDate.disabled = true;
        }
    }
    if(document.getElementById('promotion-price') && document.getElementById('promotion-end-date')){
        document.addEventListener('DOMContentLoaded', function () {
    toggleDateInput();
    });
    }
</script>