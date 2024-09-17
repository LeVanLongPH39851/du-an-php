<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SanPhamResource;
use App\Models\SanPham;
use Illuminate\Http\Request;

class ApiSanPhamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listSanPham = SanPham::get();
        //Trả ra dữ liệu dưới dạng Json thông qua SanPhamResource
        return SanPhamResource::collection($listSanPham);
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
        $sanPhamShow = SanPham::findOrFail($id);
        if($sanPhamShow){
            return new SanPhamResource($sanPhamShow);
        }
        return response()->json(['message' => 'Sản phầm không tồn tại'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}