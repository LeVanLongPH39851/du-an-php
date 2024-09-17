<!--shopping cart area start -->
<div class="shopping_cart_area mt-60">
    <div class="container">
        <form action="{{route('client.update.cart')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="table_desc">
                        <div class="cart_page table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="product_remove">Xóa</th>
                                        <th style="white-space: nowrap" class="product_name">Tên sản phẩm</th>
                                        <th style="white-space: nowrap" class="product_thumb">Ảnh</th>
                                        <th style="white-space: nowrap" class="product-price">Giá sản phẩm</th>
                                        <th style="white-space: nowrap" class="product_quantity">Số lượng</th>
                                        <th style="white-space: nowrap" class="product_total">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $tongTien = 0 ?>
                                    @forelse ($listCart as $key => $value)
                                    <tr>
                                        <td style="min-width: 0" class="product_remove"><a href="{{route('client.remove.cart', $value->id_ctgh)}}"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                        <td style="min-width: 0" class="product_name"><a style="text-transform: none" href="{{route('client.show', $value->id)}}">{{$value->ten_san_pham}}{{($value->ten_gia_tri_thuoc_tinh_bt!==NULL) ? ' ('.$value->ten_gia_tri_thuoc_tinh_bt.')' : "" }}</a></td>
                                        <td style="min-width: 0" class="product_thumb"><a href="{{route('client.show', $value->id)}}"><img
                                            src="{{'.'.Storage::url($value->anh_san_pham)}}" style="min-width: 80px; aspect-ratio: 1/1; object-fit: cover" alt=""></a></td>
                                        <td style="min-width: 0; white-space: nowrap" class="product_total">{{number_format($value->gia, 0, '', '.')}} VNĐ</td>
                                        <td style="min-width: 0; text-transform: none" class="product_quantity"><label style="font-weight: normal">Số lượng</label> <input min="1"
                                                max="50" name="quantity[{{$value->id_ctgh}}]" value="{{$value->so_luong}}" type="number">
                                                <input type="hidden" name="kieu_san_pham[{{$value->id_ctgh}}]" value="{{$value->kieu_san_pham}}">
                                                <input type="hidden" name="id_alt[{{$value->id_ctgh}}]" value="{{$value->id_alt}}">
                                        </td>
                                        <td style="min-width: 0; white-space: nowrap" class="product-price">{{number_format($value->gia * $value->so_luong, 0, '', '.')}} VNĐ</td>
                                    </tr>
                                    <?php
                                    $tongTien += $value->gia * $value->so_luong;
                                    ?>
                                    @empty
                                    <tr>
                                        <td class="text-center" colspan="6" style="text-transform: none; font-weight: normal">Bạn chưa có sản phẩm nào trong giỏ hàng</td>
                                      </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="cart_submit">
                            <button type="submit">cập nhật</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--coupon code area start-->
            <div class="coupon_area">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="coupon_code left">
                            <h3>Mã giảm giá</h3>
                            <div class="coupon_inner">
                                <p>Nhập mã phiếu giảm giá của bạn nếu bạn có</p>
                                <input id="ma-giam-gia" placeholder="Nhập mã giảm giá" type="text">
                                <button id="ma-giam-gia-submit" type="button">Áp dụng</button>
                                <p id="ma-giam-gia-text" class="text-danger mb-0"></p>
                            </div>
                        </div>
                    </div>
                    <script>
                       var maGiamGia = document.getElementById("ma-giam-gia");
                       var maGiamGiaSubmit = document.getElementById("ma-giam-gia-submit");
                       var maGiamGiaText = document.getElementById("ma-giam-gia-text");                       
                       maGiamGiaSubmit.addEventListener("click", () => {
                        if(maGiamGia.value == ""){
                        maGiamGiaText.innerText = "Vui lòng nhập mã giảm giá";
                        }else{
                        maGiamGiaText.innerText = "Mã giảm giá không hợp lệ";
                        }
                       })
                    </script>
                    <div class="col-lg-6 col-md-6">
                        <div class="coupon_code right">
                            <h3>Tổng giỏ hàng</h3>
                            <div class="coupon_inner">
                                <div class="cart_subtotal" style="border-bottom: 1px solid #ebebeb; margin-bottom: 20px">
                                    <p>Tổng Tiền</p>
                                    <p class="cart_amount">{{number_format($tongTien, 0, '', '.')}} VNĐ</p>
                                </div>
                                <div class="cart_subtotal">
                                    <p>Tổng Cộng</p>
                                    <p class="cart_amount text-primary">{{number_format($tongTien, 0, '', '.')}} VNĐ</p>
                                </div>
                                <div class="checkout_btn">
                                    <a href="{{route('client.checkout')}}">Thanh Toán</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--coupon code area end-->
        </form>
    </div>
</div>
<!--shopping cart area end -->