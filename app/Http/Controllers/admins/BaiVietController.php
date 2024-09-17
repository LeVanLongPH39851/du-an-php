<?php

namespace App\Http\Controllers\admins;

use App\Models\BaiViet;
use App\Models\SanPham;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BaiVietRequest;
use Illuminate\Support\Facades\Storage;

class BaiVietController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $active = "Danh Sách Bài Viết";
    public function index(Request $request)
    {   
        $keyWord = $request->query('keyword', '');
        $perPage = $request->query('perpage', 8);
        $orderBy = $request->query('version', "DESC");
        $query = BaiViet::select("bai_viets.*", "users.name")->join("users", "bai_viets.user_id", "=", "users.id");
        if($keyWord != ''){
            $query->where('tieu_de','LIKE', "%".$keyWord."%");
        }
        $listBaiViet= $query->orderBy('id', $orderBy)->paginate($perPage);
        $template = 'admins.baiviets.list';
        return view('admins.layout',[
            'title' => 'Danh Sách Bài Viết',
            'template' => $template,
            'active' => $this->active,
            'listBaiViet' => $listBaiViet,
            'keyWord' => $keyWord,
            'perPage' => $perPage,
            'orderBy' => $orderBy,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listSanPham = SanPham::orderByDesc('id')->get();
        $template = 'admins.baiviets.add';
        return view('admins.layout', [
            'title' => 'Thêm Bài Viết',
            'template' => $template,
            'active' => $this->active,
            'listSanPham' => $listSanPham
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BaiVietRequest $request)
    {
        if($request->hasFile("image")){
            $fileName = $request->file("image")->store("uploads/baiviet" , "public");
        }else{
            $fileName = NULL;
        }
        BaiViet::create([
            "ma_bai_viet" => "BV-".Str::random(6),
            "tieu_de" => $request->input("name"),
            "anh_bai_viet" => $fileName,
            "noi_dung" => $request->input("content"),
            "user_id" => Auth::id(),
            "san_pham_id" => $request->input("id_san_pham")
        ]);
        return redirect()->route("baiviet.index")->with("success", "Thêm bài viết thành công");
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
        $baiVietDetail = BaiViet::find($id);
        $listSanPham = SanPham::orderByDesc('id')->get();
        if(!$baiVietDetail){
            return redirect()->route("baiviet.index")->with("error", "Bài viết này không tồn tại");
        }else{
        $template = 'admins.baiviets.update';
        return view('admins.layout', ['title' => 'Sửa Bài Viết', 'template' => $template, 'active' => $this->active, 'baiVietDetail' => $baiVietDetail, 'listSanPham' => $listSanPham]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BaiVietRequest $request, string $id)
    {
        if($request->isMethod('PUT')){
            $baiVietUpdate = BaiViet::find($id);
            if($baiVietUpdate){
            if($request->hasFile('image')){
                if($baiVietUpdate->anh_bai_viet && Storage::disk('public')->exists($baiVietUpdate->anh_bai_viet)){
                    Storage::disk('public')->delete($baiVietUpdate->anh_bai_viet);
                }
                $fileName = $request->file('image')->store('uploads/baiviet', 'public');
            }else{
            $fileName = $baiVietUpdate->anh_bai_viet;
            }
            $baiVietUpdate->tieu_de = $request->input('name');
            $baiVietUpdate->anh_bai_viet = $fileName;
            $baiVietUpdate->noi_dung = $request->input('content');
            $baiVietUpdate->san_pham_id = $request->input('id_san_pham');
            $baiVietUpdate->save();
            return redirect()->route("baiviet.index")->with("success", "Cập nhật bài viết thành công");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $baiVietDelete = BaiViet::find($id);
            if($baiVietDelete){
                if($baiVietDelete->anh_bai_viet && Storage::disk('public')->exists($baiVietDelete->anh_bai_viet)){
                    Storage::disk('public')->delete($baiVietDelete->anh_bai_viet);
                   }
                $baiVietDelete->delete();
                return redirect()->route("baiviet.index")->with("success", "Xóa bài viết thành công");
            }
    }
}