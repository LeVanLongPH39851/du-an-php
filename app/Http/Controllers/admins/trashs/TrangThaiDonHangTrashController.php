<?php

namespace App\Http\Controllers\admins\trashs;

use App\Http\Controllers\Controller;
use App\Models\TrangThaiDonHang;
use Illuminate\Http\Request;

class TrangThaiDonHangTrashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $active = "Thùng Rác Trạng Thái Đơn Hàng";
    public function index()
    {
        $listTrangThaiDonHangTrash = TrangThaiDonHang::onlyTrashed()->orderByDesc('deleted_at')->get();
        $template = 'admins.trashs.donhangs.trangthais.list';
        return view('admins.layout',[
            'title' => 'Trạng Thái Đơn Hàng Đã Xóa',
            'template' => $template,
            'active' => $this->active,
            'listTrangThaiDonHangTrash' => $listTrangThaiDonHangTrash
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
            $trangThaiDonHangRestore = TrangThaiDonHang::onlyTrashed()->find($id);
            if($trangThaiDonHangRestore){
                $trangThaiDonHangRestore->restore();
                return redirect()->route("trangthaidonhangtrash.index")->with("success", "Khôi phục thành công");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trangThaiDonHangDelete = TrangThaiDonHang::onlyTrashed()->find($id);
            if($trangThaiDonHangDelete){
                $trangThaiDonHangDelete->forceDelete();
                return redirect()->route("trangthaidonhangtrash.index")->with("success", "Xóa vĩnh viễn thành công");
            }
    }
}