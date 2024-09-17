<!--product area start-->
<section class="product_area mb-46">
  <div class="container">
      <div class="row">
          <div class="col-lg-9 col-md-12">
              <div class="product_left_area">
                  <div class="section_title">
                      <h2>Sản phẩm được đánh giá tốt</h2>
                  </div>
                  <div class="product_carousel product_column4 owl-carousel">
                    @foreach ($sanPhamDanhGiaTot as $key => $value)
                    <form action="{{route('client.addtocart', $value->id)}}" method="post">
                        @csrf
                      <article class="single_product">
                          <figure>
                              <div class="product_thumb">
                                <a class="primary_img" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden" href="{{route('client.show', $value->id)}}"><img
                                    src="{{'.'.Storage::url($value->anh_san_pham)}}" style="width: 100%" alt=""></a>
                                    @if($value->duong_dan_anh !== NULL)
                                    <a class="secondary_img" style="display: flex; justify-content: center; align-items: center; aspect-ratio: 1/1; overflow: hidden" href="{{route('client.show', $value->id)}}"><img
                                            src="{{'.'.Storage::url($value->duong_dan_anh)}}" style="width: 100%" alt=""></a>
                                            @endif
                                            @if ($value->gia_khuyen_mai != NULL)
                                            <div class="label_product">
                                                <span class="label_sale">-{{round(($value->gia - $value->gia_khuyen_mai) / $value->gia * 100)}}%</span>
                                            </div>
                                            @endif
                                  <div class="action_links">
                                      <ul>
                                        <li class="wishlist">
                                            @php
                                            $love = false;
                                            @endphp
        
                                            @foreach ($checkSanPhamYeuThichDanhGiaTot as $valueYeuThichDanhGiaTot)
                                            @if ($valueYeuThichDanhGiaTot['id_san_pham'] == $value->id)
                                                <a href="javascript:void(0)" title="Yêu thích"><i class="fa fa-heart" aria-hidden="true"></i></a>
                                                @php
                                                    $love = true;
                                                @endphp
                                                @break
                                            @endif
                                            @endforeach
        
                                            @if (!$love)
                                            <a href="{{ route('client.favorite', $value->id) }}" title="Yêu thích"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                            @endif
                                            </li>
                                            <li class="quick_button"><a href="#" data-bs-toggle="modal" data-bs-target="#modal_box_danh_gia_tot_{{$value->id}}"
                                                title="Xem nhanh"> <span class="ion-ios-search-strong"></span></a></li>
                                      </ul>
                                  </div>
                                  <div class="add_to_cart">
                                    @if($value->kieu_san_pham == 1)
                                       @if ($value->so_luong > 0)
                                        <button type="submit" title="Thêm giỏ hàng" style="border: none">Thêm Giỏ Hàng</button>
                                       @else
                                       <button disabled title="Hết hàng" style="border: none; cursor: not-allowed">Hết Hàng</button>
                                    @endif
                                    @else
                                    @if ($value->sum_so_luong > 0)
                                    <a href="{{route('client.show', $value->id)}}" title="Xem tùy chọn">Xem Tùy Chọn</a>
                                    @else    
                                    <button disabled title="Hết hàng" style="border: none; cursor: not-allowed">Hết Hàng</button>
                                    @endif
                                    @endif
                                </div>
                                  @if ($value->gia_khuyen_mai != NULL && $value->ngay_ket_thuc_km != NULL)
                                  <div class="product_timing">
                                    @php
                                        $timestamp = strtotime($value->ngay_ket_thuc_km);
                                        $newTimestamp = strtotime('+1 day', $timestamp);
                                        $promotionEndDate = date('Y-m-d', $newTimestamp);
                                    @endphp
                                    <div data-countdown="{{$promotionEndDate}}"></div>
                                  </div>
                                  @endif
                              </div>
                              <figcaption class="product_content">
                                  <div class="price_box" style="margin-bottom: 7px">
                                    @if($value->gia_khuyen_mai !== NULL)
                                    <span class="old_price">{{number_format($value->gia, 0, '', '.')}}đ</span>
                                    <span class="current_price" style="font-size: 14px">{{number_format($value->gia_khuyen_mai, 0, '', '.')}}đ</span>
                                    @else
                                    <span class="current_price" style="font-size: 14px">{{$value->gia == NULL ? number_format($value->gia_min, 0, '', '.').'đ - '. number_format($value->gia_max, 0, '', '.') : number_format($value->gia, 0, '', '.')}}đ</span>
                                    @endif
                                  </div>
                                  <div class="product_ratings">
                                    <ul class="justify-content-center">
                                        <?php
                                            $danhGia = $value->trung_binh_sao;
                                            // Làm tròn giá trị $danhGia lên 0.5
                                            $danhGia = round($danhGia * 2) / 2;

                                            // Khởi tạo số lượng sao đầy, sao rưỡi, và sao trống
                                            $fullStars = floor($danhGia);
                                            $halfStar = ($danhGia - $fullStars >= 0.5) ? 1 : 0;
                                            $emptyStars = 5 - $fullStars - $halfStar;

                                            // In sao đầy
                                            for ($i = 0; $i < $fullStars; $i++) {
                                                echo '<li><a href="#"><i class="ion-android-star text-warning"></i></a></li>';
                                            }

                                            // In sao rưỡi
                                            if ($halfStar) {
                                                echo '<li><a href="#"><i class="ion-android-star-half text-warning"></i></a></li>';
                                            }

                                            // In sao trống
                                            for ($i = 0; $i < $emptyStars; $i++) {
                                                echo '<li><a href="#"><i class="ion-android-star-outline text-warning"></i></a></li>';
                                            }
                                        ?>
                                    </ul>
                                </div>
                                  <h3 class="product_name"><a href="{{route('client.show', $value->id)}}">{{$value->ten_san_pham}}</a></h3>
                              </figcaption>
                          </figure>
                      </article>
                    </form>
                    @endforeach
                  </div>
              </div>
          </div>
          <div class="col-lg-3 col-md-12">
              <!--testimonials section start-->
              <div class="testimonial_are">
                  <div class="section_title">
                      <h2>Ý Kiến Khách Hàng</h2>
                  </div>
                  <div class="testimonial_active owl-carousel">
                    @foreach ($danhGiaSanPhamDanhGiaTotUniqueFinal as $key => $value)
                    <article class="single_testimonial">
                        <figure>
                            <div class="testimonial_thumb">
                                <a href="#"><img src="{{$value->anh_dai_dien != NULL ? ".".Storage::url($value->anh_dai_dien) : "./storage/uploads/khachhang/avatar.png"}}" alt=""></a>
                            </div>
                            <figcaption class="testimonial_content">
                              <h3>
                                <?php
                                    $danhGia = $value->sao;
                                    // Làm tròn giá trị $danhGia lên 0.5
                                    $danhGia = round($danhGia * 2) / 2;

                                    // Khởi tạo số lượng sao đầy, sao rưỡi, và sao trống
                                    $fullStars = floor($danhGia);
                                    $halfStar = ($danhGia - $fullStars >= 0.5) ? 1 : 0;
                                    $emptyStars = 5 - $fullStars - $halfStar;

                                    // In sao đầy
                                    for ($i = 0; $i < $fullStars; $i++) {
                                        echo '<i class="ion-android-star text-warning"></i> ';
                                    }

                                    // In sao rưỡi
                                    if ($halfStar) {
                                        echo '<i class="ion-android-star-half text-warning"></i> ';
                                    }

                                    // In sao trống
                                    for ($i = 0; $i < $emptyStars; $i++) {
                                        echo '<i class="ion-android-star-outline text-warning"></i> ';
                                    }
                                ?>
                                  <br>
                                  <strong>{{$value->name}}</strong><span style="text-transform: none"> đánh giá <strong style="font-weight: 500">{{$value->sao}}</strong> sao<br>
                                  <a href="#" class="me-0">{{$value->ten_san_pham}}</a></span>
                              </h3>
                                <p>{{$value->noi_dung}}</p>
                            </figcaption>

                        </figure>
                    </article>
                    @endforeach
                      {{-- <article class="single_testimonial">
                          <figure>
                              <div class="testimonial_thumb">
                                  <a href="#"><img src="assets/img/about/testimonial2.jpg" alt=""></a>
                              </div>
                              <figcaption class="testimonial_content">
                                  <p>Perfect Themes and the best of all that you have many options to choose! Best
                                      Support team ever! Thank you very much!</p>
                                  <h3><a href="#">John Sullivan</a><span> - Customer</span></h3>
                              </figcaption>

                          </figure>
                      </article>
                      <article class="single_testimonial">
                          <figure>
                              <div class="testimonial_thumb">
                                  <a href="#"><img src="assets/img/about/testimonial3.jpg" alt=""></a>
                              </div>
                              <figcaption class="testimonial_content">
                                  <p>Code, template and others are very good. The support has served me
                                      immediately and solved my problems when I need help. Are to be
                                      congratulated.</p>
                                  <h3><a href="#">Jenifer Brown</a><span> - Manager of AZ</span></h3>
                              </figcaption>

                          </figure>
                      </article> --}}
                  </div>
              </div>
              <!--testimonials section end-->
          </div>
      </div>
  </div>
</section>
<!--product area end-->