<?php

namespace App\Http\Controllers\admins;

use App\Models\User;
use App\Models\DonHang;
use Illuminate\Http\Request;
use App\Models\TrangThaiDonHang;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DonHangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $active = "Danh Sách Đơn Hàng";
    public function index(Request $request)
    {
        $keyWord = $request->query('keyword', '');
        $statusOrder = $request->query('status_order', 0);
        $perPage = $request->query('perpage', 8);
        $orderBy = $request->query('version', "DESC");
        $query = DonHang::select('don_hangs.*','trang_thai_don_hangs.ten_trang_thai_don_hang')
        ->join('trang_thai_don_hangs', 'don_hangs.trang_thai_don_hang_id', '=', 'trang_thai_don_hangs.id');
        if ($statusOrder != 0) {
            $query->where('trang_thai_don_hangs.id', $statusOrder);
        }
        if($keyWord != ''){
            $query->where('don_hangs.ma_don_hang','LIKE', "%".$keyWord."%");
        }
        $listDonHang = $query->orderBy('don_hangs.id', $orderBy)->paginate($perPage);
        $listTrangThaiDonHang = TrangThaiDonHang::orderBy('id')->get();
        $template = 'admins.donhangs.list';
        return view('admins.layout',[
            'title' => 'Danh Sách Đơn Hàng',
            'template' => $template,
            'active' => $this->active,
            'listDonHang' => $listDonHang,
            'keyWord' => $keyWord,
            'statusOrder' => $statusOrder,
            'perPage' => $perPage,
            'orderBy' => $orderBy,
            'listTrangThaiDonHang' => $listTrangThaiDonHang,
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
    // <th>Tên sản phẩm</th>
    //         <th>Ảnh</th>
    //         <th>Giá</th>
    //         <th>Số lượng</th>
    //         <th>Thành tiền</th>
    //         <th>Tổng tiền</th>
    //         <th>Hình thức thanh toán</th>
    public function show(string $id)
    {
        $donHangShow = DonHang::select(
            DB::raw('COALESCE(san_phams.id, san_phams_alt.id) as id_san_pham'),
            DB::raw('COALESCE(san_phams.ten_san_pham, san_phams_alt.ten_san_pham) as ten_san_pham'),
            DB::raw('COALESCE(NULLIF(san_phams.anh_san_pham, ""), NULLIF(bien_the_san_phams.anh_bien_the_san_pham, ""), san_phams_alt.anh_san_pham) as anh_san_pham'),
            'chi_tiet_don_hangs.gia as gia', 'chi_tiet_don_hangs.so_luong',
            'chi_tiet_don_hangs.thanh_tien', 'don_hangs.tong_tien', 'don_hangs.ghi_chu',
            'phuong_thuc_thanh_toans.ten_phuong_thuc_thanh_toan', 'trang_thai_don_hangs.ten_trang_thai_don_hang',
            DB::raw('GROUP_CONCAT(DISTINCT thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the ORDER BY thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the SEPARATOR " - ") AS ten_thuoc_tinh_bien_the'), //thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the
            DB::raw('GROUP_CONCAT(DISTINCT gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt ORDER BY gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt SEPARATOR " - ") AS ten_gia_tri_thuoc_tinh_bt') //gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt
            )
            ->join('trang_thai_don_hangs', 'don_hangs.trang_thai_don_hang_id', '=', 'trang_thai_don_hangs.id')
            ->join('phuong_thuc_thanh_toans', 'don_hangs.phuong_thuc_thanh_toan_id', '=', 'phuong_thuc_thanh_toans.id')
            ->join('chi_tiet_don_hangs', 'don_hangs.id', '=', 'chi_tiet_don_hangs.don_hang_id')
            ->leftJoin('san_phams', 'san_phams.id', '=', 'chi_tiet_don_hangs.san_pham_id')
            ->leftJoin('bien_the_san_phams', 'chi_tiet_don_hangs.bien_the_san_pham_id', '=', 'bien_the_san_phams.id')
            ->leftJoin('san_phams as san_phams_alt', 'san_phams_alt.id', '=', 'bien_the_san_phams.san_pham_id')
            ->leftJoin('thuoc_tinh_bien_thes', 'bien_the_san_phams.id', '=', 'thuoc_tinh_bien_thes.bien_the_san_pham_id')
            ->leftJoin('thuoc_tinh_va_gia_tri_bien_thes', 'thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.thuoc_tinh_bien_the_id')
            ->leftJoin('gia_tri_thuoc_tinh_bien_thes', 'gia_tri_thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.gia_tri_thuoc_tinh_bien_the_id') 
            ->where('don_hangs.id', $id)
            ->groupBy(                                                                                                                //
                'don_hangs.id', 'san_phams.ten_san_pham', 'san_phams_alt.ten_san_pham', 'san_phams.anh_san_pham',                     //
                'bien_the_san_phams.anh_bien_the_san_pham', 'san_phams_alt.anh_san_pham', 'chi_tiet_don_hangs.gia',                   //
                'chi_tiet_don_hangs.so_luong', 'chi_tiet_don_hangs.thanh_tien', 'don_hangs.tong_tien', 'don_hangs.ghi_chu',           //
                'phuong_thuc_thanh_toans.ten_phuong_thuc_thanh_toan', 'trang_thai_don_hangs.ten_trang_thai_don_hang',                 //
                'san_phams.id', 'san_phams_alt.id'                                                                                    //
            )                                                                                                                         //
            ->get();
        $thongTinKhachHang = User::select('users.*', 'don_hangs.ma_don_hang', 'don_hangs.ngay_dat')->join('don_hangs', 'don_hangs.user_id', '=', 'users.id')->where('don_hangs.id', $id)->get();   
        $template = 'admins.donhangs.show';
        return view('admins.layout',[
            'title' => 'Chi Tiết Đơn Hàng',
            'template' => $template,
            'active' => $this->active,
            'donHangShow' => $donHangShow,
            'thongTinKhachHang' => $thongTinKhachHang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $listTrangThaiDonHang = TrangThaiDonHang::get();
        $donHangDetail = DonHang::findOrFail($id);
        $template = 'admins.donhangs.update';
        return view('admins.layout',[
            'title' => 'Sửa Đơn Hàng',
            'template' => $template,
            'active' => $this->active,
            'donHangDetail' => $donHangDetail,
            'listTrangThaiDonHang' => $listTrangThaiDonHang
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $donHangUpdate = DonHang::findOrFail($id);
        $donHangUpdate->trang_thai_don_hang_id = $request->input('status_order');
        $donHangUpdate->save();
        return redirect()->route('donhang.index')->with('success', 'Cập nhật trạng thái đơn hàng thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}