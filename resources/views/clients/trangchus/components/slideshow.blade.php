<!--slider area start-->
<section class="slider_section mb-70">
  <div class="slider_area owl-carousel">
    @foreach ($slideShowActive as $key=>$value)
      <div class="single_slider d-flex align-items-center" data-bgimg="{{'.'.Storage::url($value->duong_dan_anh)}}">
        @if ($value->link)
            <div class="container">
              <div class="row">
                  <div class="col-12">
                      <div class="slider_content">
                          @php
                            $sanPham = DB::table('san_phams')->where("id", $value->link)->get();
                            $danhMuc = DB::table('danh_mucs')->where("id", $sanPham[0]->danh_muc_id)->first();
                            while ($danhMuc && $danhMuc->danh_muc_cha_id) {
                                $danhMuc = DB::table('danh_mucs')->where('id', $danhMuc->danh_muc_cha_id)->first();
                            }
                          @endphp
                          <h1 style="text-transform: none">{{$danhMuc->ten_danh_muc}}</h1>
                          <h3>{{$sanPham[0]->ten_san_pham}}</h3>
                          <p style="text-transform: none">@if ($sanPham[0]->gia_khuyen_mai)
                            Giảm giá <span> {{round(($sanPham[0]->gia - $sanPham[0]->gia_khuyen_mai) / $sanPham[0]->gia * 100)}}% </span> cho đến {{date('d/m/Y', strtotime($sanPham[0]->ngay_ket_thuc_km))}}
                            @else
                            Sản phẩm chính hãng 100%
                            @endif</p>
                          <a class="button" href="{{$value->link === NULL ? 'javascript:void(0)' : route('client.show', $value->link)}}">Mua ngay</a>
                      </div>
                  </div>
              </div>
          </div>
        @endif
      </div>
      @endforeach
      {{-- <div class="single_slider d-flex align-items-center" data-bgimg="assets/img/slider/slider2.jpg">
          <div class="container">
              <div class="row">
                  <div class="col-12">
                      <div class="slider_content">
                          <h1>Dual Front</h1>
                          <h2>camera 20mp</h2>
                          <p>exclusive offer <span> 20% off </span> this week</p>
                          <a class="button" href="shop.html">shopping now</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="single_slider d-flex align-items-center" data-bgimg="assets/img/slider/slider3.jpg">
          <div class="container">
              <div class="row">
                  <div class="col-12">
                      <div class="slider_content">
                          <h1>Hurry Up!</h1>
                          <h2>IN THE WORD 2022</h2>
                          <p>exclusive offer <span> 20% off </span> this week</p>
                          <a class="button" href="shop.html">shopping now</a>
                      </div>
                  </div>
              </div>
          </div>
      </div> --}}
  </div>
  @section('script')
    <script>
        /*---slider activation---*/
        var $slider = $(".slider_area");
        if ($slider.length > 0) {
            $slider.owlCarousel({
                animateOut: '<?php echo $slideShow[0]->fade == 1 ? "fadeOut" : "false"; ?>',
                loop: {{$slideShow[0]->infinite==1 ? 'true' : 'false'}},
                nav: {{$slideShow[0]->arrows==1 ? 'true' : 'false'}},
                navText: [
                    '<div style="width: 40px; height: 40px; border-radius: 50%; background-color: #0063d1" class="d-flex justify-content-center align-items-center"><i class="fa fa-chevron-left text-white"></i></div>', // Icon cho nút "Prev"
                    '<div style="width: 40px; height: 40px; border-radius: 50%; background-color: #0063d1" class="d-flex justify-content-center align-items-center"><i class="fa fa-chevron-right text-white"></i></div>', // Icon cho nút "Next"
                ],
                autoplay: {{$slideShow[0]->auto_play==1 ? 'true' : 'false'}},
                smartSpeed: 500,
                autoplayTimeout: {{$slideShow[0]->speed}},
                items: 1,
                dots: {{$slideShow[0]->dots==1 ? 'true' : 'false'}},
            });
        }
    </script>
    @endsection
</section>
<!--slider area end-->