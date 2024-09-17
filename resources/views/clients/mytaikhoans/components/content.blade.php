<!-- my account start  -->
<section class="main_content_area">
    <div class="container">
        <div class="account_dashboard">
            <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <!-- Nav tabs -->
                    <div class="dashboard_tab_button">
                        <ul role="tablist" class="nav flex-column dashboard-list">
                            <li><a href="#dashboard" data-bs-toggle="tab" class="nav-link active">Thông tin cá nhân</a></li>
                            <li> <a href="#orders" data-bs-toggle="tab" class="nav-link">Đơn hàng của tôi</a></li>
                            <li><a href="#address" data-bs-toggle="tab" class="nav-link">Địa chỉ nhận hàng</a></li>
                            </li>
                            <li><a href="{{route('client.logout')}}" class="nav-link">Đăng xuất</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-12 col-md-9 col-lg-9">
                    <!-- Tab panes -->
                    <div class="tab-content dashboard_content">
                        <div class="tab-pane fade show active" id="dashboard">
                            <h3>Thông tin cá nhân</h3>
                            <section>
                                    <form action="{{route('client.update.user')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="card mb-4">
                                                    <div class="card-body text-center">
                                                        <img src="{{Auth::user()->anh_dai_dien === NULL ? "./storage/uploads/khachhang/avatar.png" : ".".Storage::url(Auth::user()->anh_dai_dien)}}" alt="avatar" class="rounded-circle img-fluid" style="width: 150px">
                                                        <p class="my-1 text-primary" style="font-weight: 500">{{Auth::user()->ma_khach_hang}}</p>
                                                        <input type="file" hidden id="img" name="img" style="font-size: 10px">
                                                        <div class="d-flex justify-content-center">
                                                            <button type="button" class="btn btn-outline-primary mt-0"
                                                                onclick="enableInputs()">Chỉnh Sửa</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="card mb-4">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <p class="mb-0">Họ và tên</p>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input type="text" disabled class="text-muted mb-0 form-control" value="{{Auth::user()->name}}" name='name'>
                                                                @if ($errors->has('name'))
                                                                    <p class="text-danger">{{$errors->first('name')}}</p>
                                                                    @endif
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <p class="mb-0">Email</p>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input type="email" disabled value="{{Auth::user()->email}}" name='email'
                                                                    class="text-muted mb-0 form-control">
                                                                    @if ($errors->has('email'))
                                                                    <p class="text-danger">{{$errors->first('email')}}</p>
                                                                    @endif
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <p class="mb-0">Số điện thoại</p>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input name='phone' disabled name='phone' value="{{Auth::user()->so_dien_thoai}}"
                                                                    class="text-muted mb-0 form-control">
                                                                    @if ($errors->has('phone'))
                                                                    <p class="text-danger">{{$errors->first('phone')}}</p>
                                                                    @endif
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <button type="submit" hidden name="submit"
                                                                    class="btn btn-outline-primary ms-1">Lưu</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                            </section>
                            <script>
                            function enableInputs() {
                                document.querySelectorAll('input[disabled]').forEach(input => {
                                    input.disabled = false;
                                });
                                document.querySelector('button[name="submit"]').hidden = false;
                                document.querySelector('input[name="img"]').hidden = false;
                            }
                            </script>
                        </div>
                        <div class="tab-pane fade" id="orders">
                            <h3>Đơn hàng của tôi</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="white-space: nowrap">Mã đơn hàng</th>
                                            <th style="white-space: nowrap">Tổng tiền</th>
                                            <th style="white-space: nowrap">Ngày đặt hàng</th>
                                            <th style="white-space: nowrap">Trạng thái</th>
                                            <th style="white-space: nowrap">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($listDonHang as $key => $value)
                                        <tr>
                                            <td style="min-width: 0; white-space: nowrap; font-weight: normal; text-transform: none">{{$value->ma_don_hang}}</td>
                                            <td style="min-width: 0; white-space: nowrap; font-weight: normal">{{number_format($value->tong_tien, 0, '', '.')}} VNĐ</td>
                                            <td style="min-width: 0; white-space: nowrap; font-weight: normal">{{date('d/m/Y', strtotime($value->ngay_dat))}}</td>
                                            <td style="min-width: 0; white-space: nowrap; font-weight: normal; text-transform: none"><span class="success">{{$value->ten_trang_thai_don_hang}}</span></td>
                                            <td style="min-width: 0; white-space: nowrap; font-weight: normal"><a href="{{route('client.order.detail', $value->id)}}" style="text-transform: none" class="view">Xem chi tiết</a></td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="5" style="text-transform: none">Bạn chưa có đơn hàng nào</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="address">
                            <p class="mb-0">Đây là địa chỉ nhận hàng mặc định của bạn</p>
                            <h4 class="billing-address">Địa chỉ nhận hàng</h4>
                            <form action="{{route('client.update.address')}}" method="post">
                            @csrf
                            <textarea name="address" class="form-control" placeholder="Nhập địa chỉ nhận hàng" id="" cols="30" rows="6">{{Auth::user()->dia_chi}}</textarea>
                            @if ($errors->has("address"))
                                <p class="text-danger mb-0">{{$errors->first("address")}}</p>
                            @endif
                            <button type="submit">Thay đổi</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- my account end   -->