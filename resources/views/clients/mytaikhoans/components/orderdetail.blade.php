<!--shopping cart area start -->
<div class="shopping_cart_area mt-60">
    <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="table_desc mb-3">
                        <div class="cart_page table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th style="white-space: nowrap" class="product_name">Tên Sản Phẩm</th>
                                        <th style="white-space: nowrap" class="product_thumb">Ảnh</th>
                                        <th style="white-space: nowrap" class="product-price">Giá</th>
                                        <th style="white-space: nowrap" class="product_quantity">Số Lượng</th>
                                        <th style="white-space: nowrap" class="product_total">Thành Tiền</th>
                                        <th style="white-space: nowrap" class="product_total">Tổng Tiền</th>
                                        <th style="white-space: nowrap">Hình Thức Thanh Toán</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($donHangShow as $key => $value)
                                    <tr>
                                        <td style="min-width: 0; text-transform: none" class="product_name">
                                            <a href="{{route('client.show', $value->id_san_pham)}}">{{$value->ten_san_pham}}{{($value->ten_gia_tri_thuoc_tinh_bt!==NULL) ? ' ('.$value->ten_gia_tri_thuoc_tinh_bt.')' : "" }}</a>
                                        </td>
                                        <td style="min-width: 0;" class="product_thumb">
                                            <a href="{{route('client.show', $value->id_san_pham)}}"><img src="{{".".Storage::url($value->anh_san_pham)}}" style="min-width: 80px; object-fit: cover; aspect-ratio: 1/1;" alt="Ảnh sản phẩm"></a>
                                        </td>
                                        <td style="min-width: 0; white-space: nowrap; font-weight: normal">
                                            {{number_format($value->gia, 0, '', '.')}} VNĐ
                                        </td>
                                        <td style="min-width: 0; font-weight: normal">
                                                {{$value->so_luong}}
                                        </td>
                                        <td style="min-width: 0; white-space: nowrap; border-right: 1px solid #ebebeb">
                                            {{number_format($value->thanh_tien, 0, '', '.')}} VNĐ
                                        </td>
                                        @if($loop->first)
                                        <td style="min-width: 0; white-space: nowrap;" class="product_total" rowspan="{{ $loop->count }}"><strong>{{number_format($donHangDetail->tong_tien, 0, '', '.')}} VNĐ</strong></td>
                                        <td style="min-width: 0; font-weight: normal; text-transform: none" rowspan="{{ $loop->count }}" >{{$value->ten_phuong_thuc_thanh_toan}}</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td style="min-width: 0; border-bottom: 0; text-transform: none" class="text-start" colspan="5">Ghi chú: <span style="font-weight: normal">{{$donHangDetail->ghi_chu === NULL ? 'Không có ghi chú' : $value->ghi_chu}}</span></td>
                                        <td style="min-width: 0; border-bottom: 0; text-transform: none">Ngày đặt: <span style="font-weight: normal">{{date('d/m/Y', strtotime($donHangDetail->ngay_dat))}}</span></td>
                                        <td style="min-width: 0; border-bottom: 0; text-transform: none">Trạng thái: <span style="font-weight: normal">{{$value->ten_trang_thai_don_hang}}</span></td>
                                    </tr>    
                                </tbody>
                            </table>
                        </div>
                    </div>     
                    <form action="{{route('client.cancel.order', $donHangDetail->id)}}" method="post" style="margin-bottom: 60px; text-align: end">@csrf<button type="submit" {{$value->ten_trang_thai_don_hang !== 'Đang chờ xác nhận' ? 'disabled' : ''}} class="btn btn-danger">{{$value->ten_trang_thai_don_hang == 'Đã hủy' ? 'Đã hủy' : 'Hủy đơn hàng'}}</button></form>
                </div>
            </div>
    </div>
</div>
<!--shopping cart area end -->