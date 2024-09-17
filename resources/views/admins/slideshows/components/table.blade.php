    <div class="col-sm-12" style="display: flex; justify-content: end; margin-bottom: 8px;">
        <a href="{{route('slideshow.create')}}"><button type="button" style="border-radius: 3px" class="btn btn-primary"><i
            class="fa fa-plus mr5"></i>Thêm slide show</button></a>
    </div>
    @forelse ($listSlideShow as $listSlide => $slide)
    @php
        $listAnhSlideShow = DB::table('slide_shows')->select('album_anh_slide_shows.duong_dan_anh', 'album_anh_slide_shows.link', 'album_anh_slide_shows.order')
        ->join('album_anh_slide_shows', 'slide_shows.id', '=', 'album_anh_slide_shows.slide_show_id')
        ->where('slide_shows.id', $slide->id)->orderBy('order')->get();
    @endphp
    <div class="col-lg-6">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>{{$slide->ten_slide_show}}</h5>
            @include('admins.slideshows.components.toolbox')
        </div>
        <div class="ibox-content ">
            <div class="carousel slide" id="carousel{{$slide->id}}">
                <ol class="carousel-indicators">
                @forelse ($listAnhSlideShow as $listAlbum => $album)
                <li data-slide-to="{{$loop->iteration - 1}}" data-target="#carousel{{$slide->id}}" class="{{$loop->first ? 'active' : ''}}"></li>
                @empty
                <li data-slide-to="0" data-target="#carousel{{$slide->id}}" class="active"></li>
                <li data-slide-to="1" data-target="#carousel{{$slide->id}}" class=""></li>
                <li data-slide-to="2" data-target="#carousel{{$slide->id}}" class=""></li>
                @endforelse
            </ol>
            <div class="carousel-inner">
                @forelse ($listAnhSlideShow as $listAlbum => $album)
                <div class="item {{$loop->first ? 'active' : ''}}">
                    <a href="{{$album->link === null ? "javascript:void(0)" : asset('admin/sanpham/'.$album->link)}}">
                    <img alt="image" style="width: 100%;" class="img-responsive" src="{{'.'.Storage::url($album->duong_dan_anh)}}">
                    </a>
                </div>
                @empty
                <div class="item active">
                    <img alt="image" style="width: 100%; object-fit: cover" class="img-responsive" src="./storage/uploads/anhslide/image-default.jpg">
                </div>
                <div class="item">
                    <img alt="image" style="width: 100%; object-fit: cover" class="img-responsive" src="./storage/uploads/anhslide/image-default.jpg">
                </div>
                <div class="item">
                    <img alt="image" style="width: 100%; object-fit: cover" class="img-responsive" src="./storage/uploads/anhslide/image-default.jpg">
                </div>
                @endforelse
            </div>
                <a data-slide="prev" href="#carousel{{$slide->id}}" class="left carousel-control">
                    <span class="icon-prev"></span>
                </a>
                <a data-slide="next" href="#carousel{{$slide->id}}" class="right carousel-control">
                    <span class="icon-next"></span>
                </a>
            </div>
            <form action="{{route('slideshow.update', $slide->id)}}" method="post" style="display: inline-block; margin-top: 7px; margin-right: 2px">
                @csrf
                @method('PUT')
                <button type="submit" {{$slide->active == 1 ? 'disabled' : ''}} name='update_ative' style="border-radius: 3px" class="btn btn-success">{{$slide->active == 1 ? 'Applying' : 'Apply'}}</button>
            </form>
        <a href="{{route('slideshow.edit', $slide->id)}}" style="display: inline-block; margin-top: 7px; margin-right: 2px"><button type="button" style="border-radius: 3px" class="btn btn-info"><i class="fa fa-edit"></i></button></a>
        <form action="{{route('slideshow.destroy', $slide->id)}}" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không')" style="display: inline-block; margin-top: 7px;">
            @csrf
            @method('delete')
            <button type="submit" style="border-radius: 3px" class="btn btn-danger"><i class="fa fa-trash"></i></button>
        </form>
        </div>
    </div>
</div>
@empty
Chưa có slide show nào
@endforelse
<div class="col-sm-12">
    {{$listSlideShow->links('pagination::bootstrap-4')}}
</div>