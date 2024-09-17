<?php

namespace App\Http\Controllers\admins\trashs;

use App\Http\Controllers\Controller;
use App\Models\HinhThucThanhToan;
use Illuminate\Http\Request;

class HinhThucThanhToanTrashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $active = "Thùng Rác Hình Thức Thanh Toán";
    public function index()
    {
        $listHinhThucThanhToanTrash = HinhThucThanhToan::onlyTrashed()->orderByDesc('deleted_at')->get();
        $template = 'admins.trashs.donhangs.hinhthucs.list';
        return view('admins.layout',[
            'title' => 'Hình Thức Thanh Toán Đã Xóa',
            'template' => $template,
            'active' => $this->active,
            'listHinhThucThanhToanTrash' => $listHinhThucThanhToanTrash
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
            $hinThucThanhToanRestore = HinhThucThanhToan::onlyTrashed()->find($id);
            if($hinThucThanhToanRestore){
                $hinThucThanhToanRestore->restore();
                return redirect()->route("hinhthucthanhtoantrash.index")->with("success", "Khôi phục thành công");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $hinThucThanhToanDelete = HinhThucThanhToan::onlyTrashed()->find($id);
            if($hinThucThanhToanDelete){
                $hinThucThanhToanDelete->forceDelete();
                return redirect()->route("hinhthucthanhtoantrash.index")->with("success", "Xóa vĩnh viễn thành công");
            }
    }
}