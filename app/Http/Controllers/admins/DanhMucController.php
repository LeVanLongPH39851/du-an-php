<?php

namespace App\Http\Controllers\admins;

use App\Models\DanhMuc;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DanhMucRequest;
use Illuminate\Support\Facades\Storage;

class DanhMucController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $active = 'Danh Sách Danh Mục';
    public function index(Request $request)
    {
        $keyWord = $request->query('keyword', '');
        $perPage = $request->query('perpage', 5);
        $orderBy = $request->query('version', "DESC");
        $query = DanhMuc::select("*")->where('danh_muc_cha_id', NULL)->with(['children' => function ($queryFunction) use ($orderBy) {
            $queryFunction->orderBy('id', $orderBy);
        }]);
        if($keyWord != ''){
            $query->where('ten_danh_muc','LIKE', "%".$keyWord."%");
        }
        $listDanhMuc = $query->orderBy('id', $orderBy)->paginate($perPage);
        $template = 'admins.danhmucs.list';
        return view('admins.layout',[
            'title' => 'Danh Sách Danh Mục',
            'template' => $template,
            'active' => $this->active,
            'listDanhMuc' => $listDanhMuc,
            'perPage' => $perPage,
            'orderBy' => $orderBy,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listDanhMuc = DanhMuc::where('danh_muc_cha_id', NULL)->with(['children' => function ($query) {
            $query->orderBy('id', "DESC");
        }])->orderByDesc('id')->get();
        $template = 'admins.danhmucs.add';
        return view('admins.layout',['title' => 'Thêm Danh Mục', 'template' => $template, 'listDanhMuc' => $listDanhMuc, 'active' => $this->active]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DanhMucRequest $request)
    {
        if($request->isMethod('POST')){
            if($request->hasFile('image')){
              $fileName = $request->file('image')->store('uploads/danhmuc', 'public');
            }else{
                $fileName = NULL;
            }
            $danhMucCha = $request->input('parent_id') == 0 ? NULL : $request->input('parent_id');
        $data = [
            "ma_danh_muc" => "DM-".Str::random(6),
            "ten_danh_muc" => $request->input('name'),
            "anh_danh_muc" => $fileName,
            "danh_muc_cha_id" => $danhMucCha,
        ];
        DanhMuc::create($data);
        return redirect()->route('danhmuc.index')->with('success','Thêm mới danh mục thành công');
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
        $danhMucDetail = DanhMuc::find($id);
        if(!$danhMucDetail){
            return redirect()->route("danhmuc.index")->with("error", "Danh mục này không tồn tại");
        }else{
            $listDanhMuc = DanhMuc::where('danh_muc_cha_id', NULL)->with(['children' => function ($query) {
                $query->orderBy('id', "DESC");
            }])->orderByDesc('id')->get();
        $template = 'admins.danhmucs.update';
        return view('admins.layout',['title' => 'Sửa Danh Mục', 'template' => $template, 'listDanhMuc' => $listDanhMuc, 'active' => $this->active,'danhMucDetail' => $danhMucDetail]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DanhMucRequest $request, string $id)
    {
        if($request->isMethod('PUT')){
            $danhMucUpdate = DanhMuc::find($id);
            if($danhMucUpdate){
            if($request->hasFile('image')){
                if($danhMucUpdate->anh_danh_muc && Storage::disk('public')->exists($danhMucUpdate->anh_danh_muc)){
                    Storage::disk('public')->delete($danhMucUpdate->anh_danh_muc);
                }
                $fileName = $request->file('image')->store('uploads/danhmuc', 'public');
            }else{
            $fileName = $danhMucUpdate->anh_danh_muc;
            }
            $danhMucCha = $request->input('parent_id') == 0 ? NULL : $request->input('parent_id');
            $danhMucUpdate->ten_danh_muc = $request->input('name');
            $danhMucUpdate->anh_danh_muc = $fileName;
            $danhMucUpdate->danh_muc_cha_id = $danhMucCha;
            $danhMucUpdate->save();
            return redirect()->route("danhmuc.index")->with("success", "Cập nhật danh mục thành công");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $danhMucTrash = DanhMuc::find($id);
        if($danhMucTrash){
            $danhMucTrash->delete();
            return redirect()->route("danhmuc.index")->with("success", "Chuyển vào thùng rác thành công");
        }
    }
}