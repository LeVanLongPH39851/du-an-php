 <!--Checkout page section-->
 <div class="Checkout_section mt-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                {{-- <div class="user-actions">
                    <h3>
                        <i class="fa fa-file-o" aria-hidden="true"></i>
                        Returning customer?
                        <a class="Returning" href="#" data-bs-toggle="collapse" data-bs-target="#checkout_login"
                            aria-expanded="true">Click here to login</a>

                    </h3>
                    <div id="checkout_login" class="collapse" data-bs-parent="#accordion">
                        <div class="checkout_info">
                            <p>If you have shopped with us before, please enter your details in the boxes below. If
                                you are a new customer please proceed to the Billing & Shipping section.</p>
                            <form action="#">
                                <div class="form_group">
                                    <label>Username or email <span>*</span></label>
                                    <input type="text">
                                </div>
                                <div class="form_group">
                                    <label>Password <span>*</span></label>
                                    <input type="text">
                                </div>
                                <div class="form_group group_3 ">
                                    <button type="submit">Login</button>
                                    <label for="remember_box">
                                        <input id="remember_box" type="checkbox">
                                        <span> Remember me </span>
                                    </label>
                                </div>
                                <a href="#">Lost your password?</a>
                            </form>
                        </div>
                    </div>
                </div> --}}
                <div class="user-actions">
                    <h3>
                        <i class="fa fa-file-o" aria-hidden="true"></i>
                        <a class="Returning" href="#" data-bs-toggle="collapse" data-bs-target="#checkout_coupon"
                            aria-expanded="true">Bấm vào đây để nhập mã giảm giá</a>
                    </h3>
                    <div id="checkout_coupon" class="collapse" data-bs-parent="#accordion">
                        <div class="checkout_info">
                            <form action="#">
                                <input placeholder="Mã giảm giá" type="text">
                                <button type="submit">Áp dụng</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="checkout_form">
            <form action="{{route('client.checkout.post')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-md-6">
                        <h3>Chi tiết thanh toán</h3>
                        <div class="row">
                            <div class="col-lg-12 mb-20">
                                <label>Họ và tên <span>*</span></label>
                                <input type="text" placeholder="Nhập họ và tên" readonly name="name" value="{{Auth::user()->name}}">
                                @if ($errors->has("name"))
                                    <p class="mb-0 text-danger">{{$errors->first("name")}}</p>
                                @endif
                            </div>
                            <div class="col-6 mb-20">
                                <label>Email <span>*</span></label>
                                <input type="text" placeholder="Nhập email" readonly name="email" value="{{Auth::user()->email}}">
                                @if ($errors->has("email"))
                                    <p class="mb-0 text-danger">{{$errors->first("email")}}</p>
                                @endif
                            </div>
                            <div class="col-6 mb-20">
                                <label>Số điện thoại <span>*</span></label>
                                <input type="text" placeholder="Nhập số điện thoại" name="phone" value="{{Auth::user()->so_dien_thoai}}">
                                @if ($errors->has("phone"))
                                    <p class="mb-0 text-danger">{{$errors->first("phone")}}</p>
                                @endif
                            </div>
                            {{-- <div class="col-12 mb-20">
                                <label for="country">country <span>*</span></label>
                                <select class="niceselect_option" name="cuntry" id="country">
                                    <option value="2">bangladesh</option>
                                    <option value="3">Algeria</option>
                                    <option value="4">Afghanistan</option>
                                    <option value="5">Ghana</option>
                                    <option value="6">Albania</option>
                                    <option value="7">Bahrain</option>
                                    <option value="8">Colombia</option>
                                    <option value="9">Dominican Republic</option>

                                </select>
                            </div> --}}

                            <div class="col-12 mb-20">
                                <label>Địa chỉ <span>*</span></label>
                                <input placeholder="Nhập địa chỉ cụ thể" type="text" name="address" value="{{Auth::user()->dia_chi}}">
                                @if ($errors->has("address"))
                                    <p class="mb-0 text-danger">{{$errors->first("address")}}</p>
                                @endif
                            </div>
            
                            {{-- <div class="col-12 mb-20">
                                <input id="address" type="checkbox" />
                                <label class="righ_0" style="text-transform: none" for="address" data-bs-toggle="collapse"
                                    data-bs-target="#collapsetwo" >Giao đến một địa chỉ khác?</label>

                                <div id="collapsetwo" class="collapse one" data-bs-parent="#accordion">
                                    <div class="row">
                                        <div class="col-12 mb-20">
                                            <label>Địa chỉ <span>*</span></label>
                                            <input placeholder="Nhập địa chỉ cụ thể" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="order-notes">
                                    <label for="order_note">Ghi chú</label>
                                    <textarea id="order_note" name="order_comments"
                                        placeholder="Nhập ghi chú"></textarea>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-lg-6 col-md-6">
                        <h3>Đơn hàng của bạn</h3>
                        <div class="order_table table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Sản Phẩm</th>
                                        <th>Thành Tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $tongTien = 0;
                                    ?>
                                    @foreach ($listCart as $key => $value)
                                    <tr>
                                        <td style="text-transform: none">{{$value->ten_san_pham}}{{($value->ten_gia_tri_thuoc_tinh_bt!==NULL) ? ' ('.$value->ten_gia_tri_thuoc_tinh_bt.')' : "" }} <strong>× {{$value->so_luong}}</strong></td>
                                        <td> {{number_format($value->gia * $value->so_luong, 0, '', '.')}} VNĐ</td>
                                    </tr>
                                    <?php
                                        $tongTien += $value->so_luong * $value->gia
                                        ?>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="order_total">
                                        <th>Tổng Tiền</th>
                                        <td><strong class="text-primary">{{number_format($tongTien, 0, '', '.')}} VNĐ</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="payment_method">
                            <div class="row">
                                <div class="panel-default col-md-6">
                                <input id="payment_defult" checked name="pttt" type="radio"/>
                                <label for="payment_defult">Thanh toán khi nhận hàng</label>
                                @if ($errors->has("pttt"))
                                <p class="mb-0 text-danger">{{$errors->first("pttt")}}</p>
                                @endif
                                </div>
                            </div>    
                            <div class="order_button mt-2">
                                <button type="submit">Đặt hàng</button>
                            </div>
                        </div>
                </div>
            </div>
          </form>
        </div>
    </div>
</div>
<!--Checkout page section end-->