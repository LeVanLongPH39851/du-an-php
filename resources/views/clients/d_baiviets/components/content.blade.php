<div class="blog_page_section blog_reverse mt-60 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="blog_sidebar_widget">
                    <div class="widget_list widget_search">
                        <h3>Tìm kiếm</h3>
                        <form action="{{route('client.blog')}}" method="get">
                            <input placeholder="Tìm kiếm..." type="text" value="{{$search}}" name="search">
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
                            <li class="widget_sub_categories"><a href="{{route('client.blog')}}" style="{{$danhMucBlog == 0 ? "color: #0063d1" : ""}}">Tất cả danh mục</a></li>
                            @php
                            function printCategoryList($danhMuc, $danhMucBlog) {
                                $hasChildren = $danhMuc->children->count() > 0;
                                $isActive = ($danhMucBlog == $danhMuc->id) ? 'color: #0063d1' : '';
                                
                                $href = $hasChildren ? 'javascript:void(0)' : route('client.blog') .'?danhmucblog='. $danhMuc->id;
                                $class = $hasChildren ? 'parent_custom' : "";
                                
                                echo '<li class="widget_sub_categories">';
                                echo '<a style="'. $isActive .'" href="'. $href .'" class="'.$class.'">'. str_repeat('--', $danhMuc->level) .' '. $danhMuc->ten_danh_muc .'</a>';
                                
                                if ($hasChildren) {
                                    echo '<ul class="widget_dropdown_categories">';
                                    foreach ($danhMuc->children as $child) {
                                        printCategoryList($child, $danhMucBlog);
                                    }
                                    echo '</ul>';
                                }
                                
                                echo '</li>';
                            }
                            @endphp

                            @foreach ($listDanhMuc as $danhMuc)
                                @if ($danhMuc->danh_muc_cha_id == null) <!-- Chỉ hiển thị danh mục cha -->
                                    @php printCategoryList($danhMuc, $danhMucBlog); @endphp
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="blog_wrapper blog_wrapper_sidebar">
                    <div class="blog_header">
                        <h1>Bài Viết</h1>
                    </div>
                    <div class="row">
                        @forelse ($listBaiViet as $key => $value)
                        <div class="col-lg-6 col-md-6">
                            <article class="single_blog mb-60">
                                <figure>
                                    <div class="blog_thumb">
                                        <a href="{{route("client.blog.detail", $value->id)}}"><img src="{{'.'.Storage::url($value->anh_bai_viet)}}" alt=""></a>
                                    </div>
                                    <figcaption class="blog_content">
                                        <h3><a href="{{route("client.blog.detail", $value->id)}}" style="overflow-wrap: break-word; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; text-transform: none">{{$value->tieu_de}}</a></h3>
                                        <div class="blog_meta">
                                            <span class="author">Người đăng : <a href="javascript:void(0)">{{$value->name}}</a> / </span>
                                            <span class="post_date">Ngày đăng : <a href="javascript:void(0)">{{date('d/m/Y', strtotime($value->ngay_dang))}}</a></span>
                                        </div>
                                        <footer class="readmore_button">
                                            <a href="{{route("client.blog.detail", $value->id)}}">Xem Chi Tiết</a>
                                        </footer>
                                    </figcaption>
                                </figure>
                            </article>
                        </div>
                        @empty
                        <p class="text-center">Không có bài viết nào</p>
                        @endforelse
                        {{ $listBaiViet->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
