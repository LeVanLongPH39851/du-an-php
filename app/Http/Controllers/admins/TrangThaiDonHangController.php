<?php

namespace App\Http\Controllers\admins;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TrangThaiDonHang;
use App\Http\Controllers\Controller;
use App\Http\Requests\TrangThaiDonHangRequest;

class TrangThaiDonHangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $active = "Trạng Thái Đơn Hàng";
    public function index()
    {
        $listTrangThaiDonHang = TrangThaiDonHang::orderByDesc('id')->get();
        $template = 'admins.donhangs.trangthais.list';
        return view('admins.layout',[
            'title' => 'Trạng Thái Đơn Hàng',
            'template' => $template,
            'active' => $this->active,
            'listTrangThaiDonHang' => $listTrangThaiDonHang,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $template = 'admins.donhangs.trangthais.add';
        return view('admins.layout',[
            'title' => 'Thêm Trạng Thái Đơn Hàng',
            'template' => $template,
            'active' => $this->active,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TrangThaiDonHangRequest $request)
    {
        if($request->isMethod('POST')){
        $data = [
            "ma_trang_thai_don_hang" => "TTDH-".Str::random(5),
            'ten_trang_thai_don_hang' => $request->input('name')
        ];
        TrangThaiDonHang::create($data);
        return redirect()->route('trangthaidonhang.index')->with('success', 'Thêm mới trạng thái thành công');
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
        $trangThaiDonHangDetail = TrangThaiDonHang::find($id);
        if(!$trangThaiDonHangDetail){
            return redirect()->route("trangthaidonhang.index")->with("error", "Trạng thái này không tồn tại");
        }else{
        $template = 'admins.donhangs.trangthais.update';
        return view('admins.layout',['title' => 'Sửa Trạng Thái Đơn Hàng', 'template' => $template, 'active' => $this->active,'trangThaiDonHangDetail' => $trangThaiDonHangDetail]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TrangThaiDonHangRequest $request, string $id)
    {
        if($request->isMethod('PUT')){
            $trangThaiDonHangUpdate = TrangThaiDonHang::find($id);
            if($trangThaiDonHangUpdate){
            $trangThaiDonHangUpdate->ten_trang_thai_don_hang = $request->input('name');
            $trangThaiDonHangUpdate->save();
            return redirect()->route("trangthaidonhang.index")->with("success", "Cập nhật trạng thái thành công");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trangThaiDonHangDelete = TrangThaiDonHang::find($id);
        if($trangThaiDonHangDelete){
            $trangThaiDonHangDelete->delete();
            return redirect()->route("trangthaidonhang.index")->with("success", "Chuyển vào thùng rác thành công");
        }
    }
}