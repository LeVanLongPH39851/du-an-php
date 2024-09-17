<?php

namespace App\Http\Controllers\admins\trashs;

use App\Models\DanhMuc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DanhMucTrashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $active = "Thùng Rác Danh Mục";
    public function index(Request $request)
    {
        $keyWord = $request->query('keyword', '');
        $perPage = $request->query('perpage', 5);
        $query = DanhMuc::select("*");
        if($keyWord != ''){
            $query->where('ten_danh_muc','LIKE', "%".$keyWord."%");
        }
        $listDanhMucTrash = $query->orderByDesc('deleted_at')->onlyTrashed()->paginate($perPage);
        $template = 'admins.trashs.danhmucs.list';
        return view('admins.layout',[
            'title' => 'Danh Mục Đã Xóa',
            'template' => $template,
            'active' => $this->active,
            'listDanhMucTrash' => $listDanhMucTrash,
            'perPage' => $perPage,
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
            $danhmucStore = DanhMuc::onlyTrashed()->find($id);
            if($danhmucStore){
                $danhmucStore->restore();
                return redirect()->route("danhmuctrash.index")->with("success", "Khôi phục thành công");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $danhMucDelete = DanhMuc::onlyTrashed()->find($id);
            if($danhMucDelete){
                if($danhMucDelete->anh_danh_muc && Storage::disk('public')->exists($danhMucDelete->anh_danh_muc)){
                    Storage::disk('public')->delete($danhMucDelete->anh_danh_muc);
                   }
                $danhMucDelete->forceDelete();
                return redirect()->route("danhmuctrash.index")->with("success", "Xóa vĩnh viễn thành công");
            }
    }
}