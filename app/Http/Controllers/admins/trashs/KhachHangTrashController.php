<?php

namespace App\Http\Controllers\admins\trashs;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class KhachHangTrashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $active = "Thùng Rác Khách Hàng";
    public function index(Request $request)
    {
        $keyWord = $request->query('keyword', '');
        $role = $request->query('role', 0);
        $perPage = $request->query('perpage', 8);
        $query = User::select("*");
        if ($role != 0) {
            $query->where('vai_tro', $role);
        }
        if($keyWord != ''){
            $query->where('name','LIKE', "%".$keyWord."%");
        }
        $listKhachHangTrash = $query->orderByDesc('deleted_at')->onlyTrashed()->paginate($perPage);
        $template = 'admins.trashs.khachhangs.list';
        return view('admins.layout',[
            'title' => 'Khách Hàng Đã Xóa',
            'template' => $template,
            'active' => $this->active,
            'listKhachHangTrash' => $listKhachHangTrash,
            'perPage' => $perPage,
            'role' => $role
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
            $khachHangStore = User::onlyTrashed()->find($id);
            if($khachHangStore){
                $khachHangStore->restore();
                return redirect()->route("khachhangtrash.index")->with("success", "Khôi phục thành công");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $khachHangDelete = User::onlyTrashed()->find($id);
            if($khachHangDelete){
                if($khachHangDelete->anh_dai_dien && Storage::disk('public')->exists($khachHangDelete->anh_dai_dien)){
                Storage::disk('public')->delete($khachHangDelete->anh_dai_dien);
               }
                $khachHangDelete->forceDelete();
                return redirect()->route("khachhangtrash.index")->with("success", "Xóa vĩnh viễn thành công");
            }
    }
}