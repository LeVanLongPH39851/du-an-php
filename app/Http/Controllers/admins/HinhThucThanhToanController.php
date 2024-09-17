<?php

namespace App\Http\Controllers\admins;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\HinhThucThanhToan;
use App\Http\Controllers\Controller;
use App\Http\Requests\HinhThucThanhToanRequest;

class HinhThucThanhToanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $active = "Hình Thức Thanh Toán";
    public function index()
    {
        $listHinhThucThanhToan = HinhThucThanhToan::orderByDesc('id')->get();
        $template = 'admins.donhangs.hinhthucs.list';
        return view('admins.layout',[
            'title' => 'Hình Thức Thanh Toán',
            'template' => $template,
            'active' => $this->active,
            'listHinhThucThanhToan' => $listHinhThucThanhToan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $template = 'admins.donhangs.hinhthucs.add';
        return view('admins.layout',[
            'title' => 'Thêm Hình Thức Thanh Toán',
            'template' => $template,
            'active' => $this->active,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HinhThucThanhToanRequest $request)
    {
        if($request->isMethod('POST')){
            $data = [
                "ma_phuong_thuc_thanh_toan" => "TTDH-".Str::random(5),
                'ten_phuong_thuc_thanh_toan' => $request->input('name')
            ];
            HinhThucThanhToan::create($data);
            return redirect()->route('hinhthucthanhtoan.index')->with('success', 'Thêm mới hình thức thành công');
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
        $hinhThucThanhToanDetail = HinhThucThanhToan::find($id);
        if(!$hinhThucThanhToanDetail){
            return redirect()->route("hinhthucthanhtoan.index")->with("error", "Hình thức này không tồn tại");
        }else{
        $template = 'admins.donhangs.hinhthucs.update';
        return view('admins.layout',['title' => 'Sửa Hình Thức Thanh Toán', 'template' => $template, 'active' => $this->active,'hinhThucThanhToanDetail' => $hinhThucThanhToanDetail]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HinhThucThanhToanRequest $request, string $id)
    {
        if($request->isMethod('PUT')){
            $hingThucThanhToanUpdate = HinhThucThanhToan::find($id);
            if($hingThucThanhToanUpdate){
            $hingThucThanhToanUpdate->ten_phuong_thuc_thanh_toan = $request->input('name');
            $hingThucThanhToanUpdate->save();
            return redirect()->route("hinhthucthanhtoan.index")->with("success", "Cập nhật hình thức thành công");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hinhThucThanhToanDelete = HinhThucThanhToan::find($id);
        if($hinhThucThanhToanDelete){
            $hinhThucThanhToanDelete->delete();
            return redirect()->route("hinhthucthanhtoan.index")->with("success", "Chuyển vào thùng rác thành công");
        }
    }
}