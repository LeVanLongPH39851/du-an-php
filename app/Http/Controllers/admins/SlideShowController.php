<?php

namespace App\Http\Controllers\admins;

use App\Models\SanPham;
use App\Models\SlideShow;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AlbumAnhSlideShow;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SlideShowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $active = 'Danh Sách Slide Show';
    public function index()
    {   
        $listSlideShow = SlideShow::orderByDesc('id')->paginate(4);
        $template = 'admins.slideshows.list';
        return view('admins.layout',[
            'title' => 'Danh Sách Slide Show',
            'template' => $template,
            'active' => $this->active,
            'listSlideShow' => $listSlideShow,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $template = 'admins.slideshows.add';
        return view('admins.layout',[
            'title' => 'Thêm mới Slide Show',
            'template' => $template,
            'active' => $this->active,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->isMethod('post')){
            $data = [
                'ma_slide_show' => "SLS-".Str::random(6),
                'ten_slide_show' => $request->input('name'),
                'active' => $request->input('optionsRadios')
            ];
            $slideShow = SlideShow::create($data);
            $slideShowId = $slideShow->id;
            if($request->input('optionsRadios') == 1){
                SlideShow::where('id', '<>', $slideShowId)
                ->where('active', 1)
                ->update(['active' => 0]);
            }
            if($request->hasFile("slides")){
                $order = 1;
                foreach($request->file("slides") as $file){
                       if($file){
                        $fileName = $file->store('uploads/anhslide/id_'. $slideShowId, "public");
                        AlbumAnhSlideShow::create([
                            'ma_album_anh_slide_show' => "ABSL-".Str::random(5),
                            'duong_dan_anh' => $fileName,
                            'order' => $order,
                            'slide_show_id' => $slideShowId
                        ]);
                        $order += 1;
                       }
                }
            }
            return redirect()->route('slideshow.index')->with('success','Thêm mới slide show thành công');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slideShowDetail = SlideShow::find($id);
        $listSanPham = SanPham::get();
        $listAnhSlideShowDetail = SlideShow::select('album_anh_slide_shows.id', 'album_anh_slide_shows.duong_dan_anh', 'album_anh_slide_shows.link', 'album_anh_slide_shows.order')
        ->join('album_anh_slide_shows', 'slide_shows.id', '=', 'album_anh_slide_shows.slide_show_id')
        ->where('slide_shows.id', $id)->orderBy('order')->get();
        $listOrder = SlideShow::select('album_anh_slide_shows.order')
        ->join('album_anh_slide_shows', 'slide_shows.id', '=', 'album_anh_slide_shows.slide_show_id')
        ->where('slide_shows.id', $id)->orderBy('order')->get()->toArray();
        // Sắp xếp các giá trị của trường "order"
        usort($listOrder, function ($a, $b) {
            return $a['order'] <=> $b['order'];
        });

        // Tạo mảng liên tục từ 1 đến số lượng phần tử của mảng phẳng
        foreach ($listOrder as $index => &$element) {
            $element['order'] = $index + 1;
        }
        // dd($listOrder);
        $template = 'admins.slideshows.update';
        return view('admins.layout',[
            'title' => 'Sửa Slide Show',
            'template' => $template,
            'active' => $this->active,
            'slideShowDetail' => $slideShowDetail,
            'listAnhSlideShowDetail' => $listAnhSlideShowDetail,
            'listSanPham' => $listSanPham,
            'listOrder' => $listOrder
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if($request->isMethod('PUT')){
            $slideShowUpdate = SlideShow::find($id);
            if($slideShowUpdate){
            if($request->has('update_ative')){
                $slideShowUpdate->active = 1;
                $slideShowUpdate->save(); 
                SlideShow::where('id', '<>', $id)
                ->where('active', 1)
                ->update(['active' => 0]);
            return redirect()->route('slideshow.index')->with('success','Apply thành công'); 
            }
            else{
            $slideShowUpdateId = $slideShowUpdate->id;
            if($request->input('optionsRadios') == 1){
                SlideShow::where('id', '<>', $slideShowUpdateId)
                ->where('active', 1)
                ->update(['active' => 0]);
            }
            if($request->has('arrows')){
                $slideShowUpdate->arrows = $request->input('arrows');
            }else{
                $slideShowUpdate->arrows = 0;

            }
            if($request->has('dots')){
                $slideShowUpdate->dots = $request->input('dots');
            }else{
                $slideShowUpdate->dots = 0;
            }
            if($request->has('autoplay')){
                $slideShowUpdate->auto_play = $request->input('autoplay');
            }else{
                $slideShowUpdate->auto_play = 0;
            }
            if($request->has('fade')){
                $slideShowUpdate->fade = $request->input('fade');
            }else{
                $slideShowUpdate->fade = 0;
            }
            if($request->has('infinite')){
                $slideShowUpdate->infinite = $request->input('infinite');
            }else{
                $slideShowUpdate->infinite = 0;
            }
            if($request->has('speed')){
                if($request->input('speed') === null){
                    $slideShowUpdate->speed = 300;
                }else{
                $slideShowUpdate->speed = $request->input('speed');
                }
            }
            $slideShowUpdate->ten_slide_show = $request->input('name');
            $slideShowUpdate->active = $request->input('optionsRadios') == 1 ? 1 : 0;
            $slideShowUpdate->save();
             // Xử lý link
             if($request->has('links')){
             foreach ($request->input('links') as $key => $value) {
                $AlbumAnh = AlbumAnhSlideShow::findOrFail($request->input('id_album_slide_show')[$key]);
                if($request->input('links')[$key] != 0){
                    $AlbumAnh->link = $value;
                    $AlbumAnh->save();
                }else{
                    $AlbumAnh->link = NULL;
                    $AlbumAnh->save();
                }
            }
            }

            // Xử lý order
            if($request->has('orders')){
            foreach ($request->input('orders') as $albumId => $orderValue) {
                // Cập nhật thứ tự cho từng album
                $album = AlbumAnhSlideShow::find($albumId);
                if ($album) {
                    $album->order = $orderValue;
                    $album->save();
                }
            }
            }

            //Xóa các ảnh đã chọn
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $imageId) {
                    $image = AlbumAnhSlideShow::findOrFail($imageId);
                    if($image->duong_dan_anh && Storage::disk('public')->exists($image->duong_dan_anh)){
                    Storage::disk('public')->delete($image->duong_dan_anh);
                    }
                    $image->forceDelete();
                }
             }

             // Thêm các hình ảnh mới
            if ($request->hasFile('slides')) {
            foreach ($request->file('slides') as $file) {
                $fileName = $file->store('uploads/anhslide/id_'. $slideShowUpdateId, "public");
                AlbumAnhSlideShow::create([
                    'ma_album_anh_slide_show' => "ABSL-".Str::random(5),
                    'duong_dan_anh' => $fileName,
                    'slide_show_id' => $slideShowUpdateId,
                ]);
            }
        }
        return redirect()->route('slideshow.index')->with('success','Cập nhật slide show thành công');
        }
        }
    }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slideShowDelete = SlideShow::find($id);
        $listAnhSlideShowDelete = SlideShow::select('album_anh_slide_shows.id', 'album_anh_slide_shows.duong_dan_anh', 'album_anh_slide_shows.link', 'album_anh_slide_shows.order')
        ->join('album_anh_slide_shows', 'slide_shows.id', '=', 'album_anh_slide_shows.slide_show_id')
        ->where('slide_shows.id', $id)->orderBy('order')->get();
        if($listAnhSlideShowDelete){
        foreach ($listAnhSlideShowDelete as $image) {
            if($image->duong_dan_anh && Storage::disk('public')->exists($image->duong_dan_anh)){
            Storage::disk('public')->delete($image->duong_dan_anh);
            }
            $image->forceDelete();
        }
        }
            if($slideShowDelete){
                $slideShowDelete->forceDelete();
                return redirect()->route("slideshow.index")->with("success", "Xóa slideshow thành công");
            }

    }
}