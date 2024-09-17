<?php

namespace App\Http\Controllers\admins\trashs;

use App\Models\DanhMuc;
use App\Models\SanPham;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SanPhamTrashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $active = "Thùng Rác Sản Phẩm";
    public function index(Request $request)
    {
        $keyWord = $request->query('keyword', '');
        $category = $request->query('category', 0);
        $perPage = $request->query('perpage', 8);
        $listDanhMuc = DanhMuc::orderByDesc('id')->get();
        $query = SanPham::select('san_phams.*', 'danh_mucs.ten_danh_muc')
        ->join('danh_mucs', 'san_phams.danh_muc_id', '=', 'danh_mucs.id');
        if ($category != 0) {
            $query->where('danh_mucs.id', $category);
        }
        if($keyWord != ''){
            $query->where('san_phams.ten_san_pham','LIKE', "%".$keyWord."%");
        }
        $listSanPhamTrash = $query->orderByDesc('deleted_at')
        ->onlyTrashed()->paginate($perPage);
        $template = 'admins.trashs.sanphams.list';
        return view('admins.layout', [
            'title' => 'Sản Phẩm Đã Xóa',
            'template' => $template,
            'active' => $this->active,
            'listSanPhamTrash' => $listSanPhamTrash,
            'listDanhMuc' => $listDanhMuc,
            'perPage' => $perPage,
            'category' => $category
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if($request->isMethod('PUT')){
            $sanPhamRestore = SanPham::onlyTrashed()->find($id);
            if($sanPhamRestore){
                $sanPhamRestore->restore();
                return redirect()->route("sanphamtrash.index")->with("success", "Khôi phục thành công");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sanPhamDelete = SanPham::onlyTrashed()->find($id);
        if($sanPhamDelete){
            $albumDelete = SanPham::onlyTrashed()
        ->join('album_anhs', 'album_anhs.san_pham_id', '=','san_phams.id')
        ->where('san_phams.id', $id)
        ->get(['album_anhs.duong_dan_anh']);
        $variantDelete = SanPham::onlyTrashed()
        ->join('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=','san_phams.id')
        ->where('san_phams.id', $id)
        ->get(['bien_the_san_phams.anh_bien_the_san_pham']);
        if(!empty($albumDelete)){
            foreach($albumDelete as $key => $value){
                if($value->duong_dan_anh && Storage::disk('public')->exists($value->duong_dan_anh)){
                    Storage::disk('public')->delete($value->duong_dan_anh);
              }
            }
        }
        if(!empty($variantDelete)){
            foreach($variantDelete as $key => $value){
                if($value->anh_bien_the_san_pham && Storage::disk('public')->exists($value->anh_bien_the_san_pham)){
                    Storage::disk('public')->delete($value->anh_bien_the_san_pham);
              }
            }
        }
                if($sanPhamDelete->anh_san_pham && Storage::disk('public')->exists($sanPhamDelete->anh_san_pham)){
                  Storage::disk('public')->delete($sanPhamDelete->anh_san_pham);
            }
                $sanPhamDelete->forceDelete();
                return redirect()->route("sanphamtrash.index")->with("success", "Xóa vĩnh viễn thành công");
            }
    }
}