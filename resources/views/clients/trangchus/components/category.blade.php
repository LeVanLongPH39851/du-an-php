<!--top- category area start-->
<section class="top_category_product mb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-3">
                <div class="top_category_header">
                    <h3>Danh Mục</h3>
                    <p>Tất cả những danh mục</p>
                    <a href="{{route('client.shop')}}">Xem Tất Cả Danh Mục</a>
                </div>
            </div>
            <div class="col-lg-10 col-md-9">
                <div class="top_category_container category_column5 owl-carousel">
                    @foreach ($listDanhMuc as $key => $value)
                    <div class="col-lg-2">
                        <article class="single_category">
                            <figure>
                                <div class="category_thumb">
                                    <a href="{{route('client.shop')."?category=".$value->id}}"><img src="{{".".Storage::url($value->anh_danh_muc)}}" style="aspect-ratio: 1/1; object-fit: cover" alt=""></a>
                                </div>
                                <figcaption class="category_name">
                                    <h3><a href="{{route('client.shop')."?category=".$value->id}}">{{$value->ten_danh_muc}}</a></h3>
                                </figcaption>
                            </figure>
                        </article>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!--top- category area end-->