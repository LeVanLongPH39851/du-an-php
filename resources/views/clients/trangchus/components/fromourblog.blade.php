<!--blog area start-->
<section class="blog_section mb-70">
  <div class="container">
      <div class="row">
          <div class="col-12">
              <div class="section_title">
                  <h2>Bài viết của chúng tôi</h2>
              </div>
          </div>
      </div>
      <div class="row">
          <div class="blog_carousel blog_column4 owl-carousel">
              @foreach ($listBaiViet as $key => $value)
              <div class="col-lg-3">
                <article class="single_blog">
                    <figure>
                        <div class="blog_thumb">
                            <a href="{{route('client.blog.detail', $value->id)}}"><img src="{{'.'.Storage::url($value->anh_bai_viet)}}" alt=""></a>
                        </div>
                        <figcaption class="blog_content">
                            <p class="post_author">By <a href="javascript:void(0)">{{$value->name}}</a>, Ngày {{date('d/m/Y', strtotime($value->ngay_dang))}}</p>
                            <h3 class="post_title"><a style="overflow-wrap: break-word; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; text-transform: none" href="{{route('client.blog.detail', $value->id)}}">{{$value->tieu_de}}</a></h3>
                        </figcaption>
                    </figure>
                </article>
            </div>
              @endforeach
          </div>
      </div>
  </div>
</section>
<!--blog area end-->