<div class="blog_details mt-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-12">
                <!--blog grid area start-->
                <div class="blog_wrapper">
                    <article class="single_blog">
                        <figure>
                            <div class="post_header mb-0">
                                <h3 class="post_title">{{$baiVietShow->tieu_de}}</h3>
                                <div class="blog_meta">
                                    <span class="author">Người đăng : <a href="javascript:void(0)">{{$user->name}}</a> / </span>
                                    <span class="post_date">Ngày đăng : <a href="javascript:void(0)">{{date('d/m/Y', strtotime($baiVietShow->ngay_dang))}}</a></span>
                                </div>
                            </div>
                            {{-- <div class="blog_thumb">
                                <a href="#"><img src="assets/img/blog/blog-big1.jpg" alt=""></a>
                            </div> --}}
                            <figcaption class="blog_content">
                                <div class="post_content pb-4">
                                    {!!$baiVietShow->noi_dung!!}
                                </div>
                            </figcaption>
                        </figure>
                    </article>
                    <div class="related_posts">
                        <h3>Bài viết liên quan</h3>
                        <div class="row">
                            @foreach ($next as $key => $value)
                            @php
                                $user = DB::table("users")->find($value->user_id);
                            @endphp
                            <div class="col-lg-4 col-md-6">
                                <article class="single_related">
                                    <figure>
                                        <div class="related_thumb">
                                            <img src="{{'.'.Storage::url($value->anh_bai_viet)}}" alt="">
                                        </div>
                                        <figcaption class="related_content">
                                            <div class="blog_meta">
                                                <span class="author">Người đăng : <a href="javascript:void(0)">{{$user->name}}</a> / </span>
                                                <span class="post_date"> Ngày {{date('d/m/Y', strtotime($baiVietShow->ngay_dang))}} </span>
                                            </div>
                                            <h4><a href="{{route('client.blog.detail', $value->id)}}" style="overflow-wrap: break-word; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; text-transform: none">{{$value->tieu_de}}</a></h4>
                                        </figcaption>
                                    </figure>
                                </article>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    {{-- <div class="comments_box">
                        <h3>3 Comments </h3>
                        <div class="comment_list">
                            <div class="comment_thumb">
                                <img src="assets/img/blog/comment3.png.jpg" alt="">
                            </div>
                            <div class="comment_content">
                                <div class="comment_meta">
                                    <h5><a href="#">Admin</a></h5>
                                    <span>October 16, 2022 at 1:38 am</span>
                                </div>
                                <p>But I must explain to you how all this mistaken idea of denouncing pleasure</p>
                                <div class="comment_reply">
                                    <a href="#">Reply</a>
                                </div>
                            </div>

                        </div>
                        <div class="comment_list list_two">
                            <div class="comment_thumb">
                                <img src="assets/img/blog/comment3.png.jpg" alt="">
                            </div>
                            <div class="comment_content">
                                <div class="comment_meta">
                                    <h5><a href="#">Demo</a></h5>
                                    <span>October 16, 2022 at 1:38 am</span>
                                </div>
                                <p>Quisque semper nunc vitae erat pellentesque, ac placerat arcu consectetur</p>
                                <div class="comment_reply">
                                    <a href="#">Reply</a>
                                </div>
                            </div>
                        </div>
                        <div class="comment_list">
                            <div class="comment_thumb">
                                <img src="assets/img/blog/comment3.png.jpg" alt="">
                            </div>
                            <div class="comment_content">
                                <div class="comment_meta">
                                    <h5><a href="#">Admin</a></h5>
                                    <span>October 16, 2022 at 1:38 am</span>
                                </div>
                                <p>Quisque orci nibh, porta vitae sagittis sit amet, vehicula vel mauris. Aenean at
                                </p>
                                <div class="comment_reply">
                                    <a href="#">Reply</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="comments_form">
                        <h3>Leave a Reply </h3>
                        <p>Your email address will not be published. Required fields are marked *</p>
                        <form action="#">
                            <div class="row">
                                <div class="col-12">
                                    <label for="review_comment">Comment </label>
                                    <textarea name="comment" id="review_comment"></textarea>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <label for="author">Name</label>
                                    <input id="author" type="text">

                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <label for="email">Email </label>
                                    <input id="email" type="text">
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <label for="website">Website </label>
                                    <input id="website" type="text">
                                </div>
                            </div>
                            <button class="button" type="submit">Post Comment</button>
                        </form>
                    </div> --}}
                </div>
                <!--blog grid area start-->
            </div>
            <div class="col-lg-3 col-md-12">
                <div class="blog_sidebar_widget">
                    <div class="widget_list widget_search">
                        <h3>Tìm kiếm</h3>
                        <form action="{{route('client.blog')}}" method="get">
                            <input placeholder="Tìm kiếm..." type="text" name="search">
                            <button type="submit">Tìm kiếm</button>
                        </form>
                    </div>
                    <div class="widget_list widget_post">
                        <h3>Bài viết gần đây</h3>
                        @foreach ($listBaiVietGanDay as $key => $value)
                        <div class="post_wrapper">
                            <div class="post_thumb">
                                <a href="{{route("client.blog.detail", $value->id)}}"><img src="{{".".Storage::url($value->anh_bai_viet)}}" alt="" style="aspect-ratio: 1/1; object-fit: cover"></a>
                            </div>
                            <div class="post_info">
                                <h3><a href="{{route("client.blog.detail", $value->id)}}" style="overflow-wrap: break-word; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; text-transform: none">{{$value->tieu_de}}</a></h3>
                                <span>{{date('d/m/Y', strtotime($value->ngay_dang))}}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="widget_list widget_categories">
                        <h3>Danh mục</h3>
                        <ul>
                            <li class="widget_sub_categories"><a href="{{route('client.blog')}}">Tất cả danh mục</a></li>
                            @php
                            function printCategoryList($danhMuc) {
                                $hasChildren = $danhMuc->children->count() > 0;                                
                                $href = $hasChildren ? 'javascript:void(0)' : route('client.blog') .'?danhmucblog='. $danhMuc->id;
                                $class = $hasChildren ? 'parent_custom' : "";
                                echo '<li class="widget_sub_categories">';
                                echo '<a href="'. $href .'" class="'.$class.'">'. str_repeat('--', $danhMuc->level) .' '. $danhMuc->ten_danh_muc .'</a>';
                                
                                if ($hasChildren) {
                                    echo '<ul class="widget_dropdown_categories">';
                                    foreach ($danhMuc->children as $child) {
                                        printCategoryList($child);
                                    }
                                    echo '</ul>';
                                }
                                
                                echo '</li>';
                            }
                            @endphp

                            @foreach ($listDanhMuc as $danhMuc)
                                @if ($danhMuc->danh_muc_cha_id == null) <!-- Chỉ hiển thị danh mục cha -->
                                    @php printCategoryList($danhMuc); @endphp
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>