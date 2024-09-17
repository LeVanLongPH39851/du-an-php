<div class="wishlist_area mt-60">
    <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="table_desc wishlist">
                        <div class="cart_page table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="product_remove">Xóa</th>
                                        <th class="product_name">Tên Sản Phẩm</th>
                                        <th class="product_thumb">Ảnh</th>
                                        <th class="product-price">Giá</th>
                                        <th class="product_total">Xem sản phẩm</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($wishList as $key => $value)
                                    <tr>
                                        <td style="min-width: 0" class="product_remove"><a href="{{route('client.delete.favorite', $value->id_san_pham_yeu_thich)}}">X</a></td>
                                        <td style="min-width: 0" class="product_name"><a href="{{route('client.show', $value->id_san_pham)}}" style="text-transform: none">{{$value->ten_san_pham}}</a></td>
                                        <td style="min-width: 0" class="product_thumb"><a href="{{route('client.show', $value->id_san_pham)}}"><img style="min-width: 80px; aspect-ratio: 1/1; object-fit: cover" src="{{".".Storage::url($value->anh_san_pham)}}" alt=""></a></td>
                                        <td style="min-width: 0; font-size: 14px" class="product-price">
                                            @if ($value->gia_khuyen_mai != NULL)
                                                <del>{{number_format($value->gia, 0, '', '.')}} VNĐ</del> <span style="color: #0063d1">{{number_format($value->gia_khuyen_mai, 0, '', '.')}} VNĐ</span>
                                            @elseif($value->gia != NULL)
                                                <span style="color: #0063d1">{{number_format($value->gia, 0, '', '.')}} VNĐ</span>
                                            @else
                                            <span style="color: #0063d1">{{number_format($value->gia_min, 0, '', '.').' VNĐ - '.number_format($value->gia_max, 0, '', '.').' VNĐ'}}</span>
                                            @endif
                                        </td>
                                        <td style="min-width: 0" class="product_total">
                                            @if ($value->kieu_san_pham==1)
                                            <form action="{{route('client.addtocart', $value->id_san_pham)}}" method="post">
                                                @csrf
                                                <button type="submit" style="border: none">Thêm giỏ hàng</button>
                                                </form>
                                            @else
                                               <a href="{{route('client.show', $value->id_san_pham)}}">Xem tùy chọn</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Chưa có sản phẩm yêu thích nào</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
    </div>
</div>