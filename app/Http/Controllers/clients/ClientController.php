<?php

namespace App\Http\Controllers\clients;

use App\Models\User;
use App\Models\DanhGia;
use App\Models\DanhMuc;
use App\Models\DonHang;
use App\Models\GioHang;
use App\Models\SanPham;
use App\Models\BinhLuan;
use App\Models\SlideShow;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BienTheSanPham;
use App\Models\ChiTietDonHang;
use App\Models\ChiTietGioHang;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\BaiViet;
use App\Models\HinhThucThanhToan;
use App\Models\SanPhamYeuThich;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    
    protected $listDanhMuc;
    protected $countSanPhamYeuThich;
    protected $listCart;
    public function __construct()
    {   
        $this->listDanhMuc = DanhMuc::where('danh_muc_cha_id', NULL)->orderByDesc('id')->get();
        $this->middleware(function ($request, $next) {
            $this->countSanPhamYeuThich = SanPhamYeuThich::where('user_id', Auth::id())->count();
            $this->listCart = GioHang::join('users', 'users.id', '=', 'gio_hangs.user_id')
        ->join('chi_tiet_gio_hangs','chi_tiet_gio_hangs.gio_hang_id', '=', 'gio_hangs.id')
        ->leftjoin('san_phams', 'san_phams.id', '=', 'chi_tiet_gio_hangs.san_pham_id')
        ->leftJoin('bien_the_san_phams', 'chi_tiet_gio_hangs.bien_the_san_pham_id', '=', 'bien_the_san_phams.id')
        ->leftJoin('san_phams as san_phams_alt', 'san_phams_alt.id', '=', 'bien_the_san_phams.san_pham_id')
        ->leftJoin('thuoc_tinh_bien_thes', 'bien_the_san_phams.id', '=', 'thuoc_tinh_bien_thes.bien_the_san_pham_id')
        ->leftJoin('thuoc_tinh_va_gia_tri_bien_thes', 'thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.thuoc_tinh_bien_the_id')
        ->leftJoin('gia_tri_thuoc_tinh_bien_thes', 'gia_tri_thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.gia_tri_thuoc_tinh_bien_the_id') 
        ->where('users.id' , Auth::id())
        ->groupBy(                                                                                                               
            'san_phams.ten_san_pham', 'san_phams_alt.ten_san_pham', 'san_phams.anh_san_pham',                     
            'bien_the_san_phams.anh_bien_the_san_pham', 'san_phams_alt.anh_san_pham',                  
            'san_phams.id', 'san_phams_alt.id', 'chi_tiet_gio_hangs.so_luong', 'chi_tiet_gio_hangs.id',
            'san_phams.gia', 'san_phams.gia_khuyen_mai', 'bien_the_san_phams.gia', 'san_phams.kieu_san_pham', 'san_phams_alt.kieu_san_pham',
            'bien_the_san_phams.id'                                                                  
        )                                                                                                                     
        ->orderByDesc('chi_tiet_gio_hangs.id')
        ->get(['chi_tiet_gio_hangs.so_luong', 'chi_tiet_gio_hangs.id as id_ctgh', 
        DB::raw('COALESCE(san_phams.id, san_phams_alt.id) as id'),
        DB::raw('COALESCE(san_phams.id, bien_the_san_phams.id) as id_alt'),
        DB::raw('COALESCE(san_phams.kieu_san_pham, san_phams_alt.kieu_san_pham) as kieu_san_pham'),
        DB::raw('COALESCE(san_phams.gia_khuyen_mai, san_phams.gia, bien_the_san_phams.gia) as gia'),
        DB::raw('COALESCE(san_phams.ten_san_pham, san_phams_alt.ten_san_pham) as ten_san_pham'),
        DB::raw('COALESCE(NULLIF(san_phams.anh_san_pham, ""), NULLIF(bien_the_san_phams.anh_bien_the_san_pham, ""), san_phams_alt.anh_san_pham) as anh_san_pham'),
        DB::raw('GROUP_CONCAT(DISTINCT thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the ORDER BY thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the SEPARATOR " - ") AS ten_thuoc_tinh_bien_the'), //thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the
        DB::raw('GROUP_CONCAT(DISTINCT gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt ORDER BY gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt SEPARATOR " - ") AS ten_gia_tri_thuoc_tinh_bt') //gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt
        ]);
            return $next($request);
        });
    }

    public function index(){
        $sanPhamKhuyenMai = SanPham::select(
            'san_phams.id', 
            'san_phams.ten_san_pham', 
            'san_phams.gia',
            'san_phams.gia_khuyen_mai',
            'san_phams.so_luong',
            'san_phams.ngay_ket_thuc_km',
            'san_phams.kieu_san_pham',
            'san_phams.mo_ta_ngan',
            DB::raw('MIN(bien_the_san_phams.gia) as gia_min'),
            DB::raw('MAX(bien_the_san_phams.gia) as gia_max'),
            DB::raw('SUM(bien_the_san_phams.so_luong) as sum_so_luong'),
            'san_phams.anh_san_pham',
            DB::raw('(SELECT album_anhs.duong_dan_anh 
                  FROM album_anhs 
                  WHERE album_anhs.san_pham_id = san_phams.id 
                  ORDER BY album_anhs.id ASC 
                  LIMIT 1) as duong_dan_anh')
        )
        ->leftJoin('bien_the_san_phams', 'san_phams.id', '=', 'bien_the_san_phams.san_pham_id')
        ->whereNotNull('san_phams.gia_khuyen_mai')
        ->groupBy('san_phams.ten_san_pham', 'san_phams.gia', 'san_phams.gia_khuyen_mai', 'san_phams.ngay_ket_thuc_km', 'san_phams.so_luong', 'san_phams.anh_san_pham', 'san_phams.id', 'san_phams.kieu_san_pham', 'san_phams.mo_ta_ngan')
        ->orderByDesc('san_phams.id')
        ->get();
        $sanPhamBanChay = SanPham::select(
            'san_phams.id', 
            'san_phams.ten_san_pham', 
            'san_phams.gia',
            'san_phams.gia_khuyen_mai',
            'san_phams.ngay_ket_thuc_km',
            'san_phams.so_luong',
            'san_phams.kieu_san_pham',
            'san_phams.mo_ta_ngan',
            DB::raw('MIN(bien_the_san_phams.gia) as gia_min'),
            DB::raw('MAX(bien_the_san_phams.gia) as gia_max'),
            DB::raw('SUM(bien_the_san_phams.so_luong) as sum_so_luong'),
            'san_phams.anh_san_pham',
            DB::raw('SUM(chi_tiet_don_hang_tong.so_luong) as ban_chay'),
            DB::raw('(SELECT album_anhs.duong_dan_anh 
                  FROM album_anhs 
                  WHERE album_anhs.san_pham_id = san_phams.id 
                  ORDER BY album_anhs.id ASC 
                  LIMIT 1) as duong_dan_anh')
        )
        ->leftJoin('bien_the_san_phams', 'san_phams.id', '=', 'bien_the_san_phams.san_pham_id')
        ->leftJoin(
        DB::raw('(SELECT san_pham_id, bien_the_san_pham_id, SUM(so_luong) as so_luong 
        FROM chi_tiet_don_hangs 
        GROUP BY san_pham_id, bien_the_san_pham_id) as chi_tiet_don_hang_tong'), function($join) {
        $join->on('chi_tiet_don_hang_tong.san_pham_id', '=', 'san_phams.id')
        ->orOn('chi_tiet_don_hang_tong.bien_the_san_pham_id', '=', 'bien_the_san_phams.id');
        })
        ->groupBy('san_phams.ten_san_pham', 'san_phams.gia', 'san_phams.gia_khuyen_mai', 'san_phams.ngay_ket_thuc_km', 'san_phams.so_luong', 'san_phams.anh_san_pham', 'san_phams.id', 'san_phams.kieu_san_pham', 'san_phams.mo_ta_ngan')
        ->orderByDesc('ban_chay')
        ->orderByDesc('san_phams.id')
        ->paginate(10);
        $sanPhamNoiBat  = SanPham::select(
            'san_phams.id', 
            'san_phams.ten_san_pham', 
            'san_phams.gia',
            'san_phams.gia_khuyen_mai',
            'san_phams.ngay_ket_thuc_km',
            'san_phams.so_luong',
            'san_phams.kieu_san_pham',
            'san_phams.mo_ta_ngan',
            DB::raw('MIN(bien_the_san_phams.gia) as gia_min'),
            DB::raw('MAX(bien_the_san_phams.gia) as gia_max'),
            DB::raw('SUM(bien_the_san_phams.so_luong) as sum_so_luong'),
            'san_phams.anh_san_pham',
            DB::raw('(SELECT album_anhs.duong_dan_anh 
                  FROM album_anhs 
                  WHERE album_anhs.san_pham_id = san_phams.id 
                  ORDER BY album_anhs.id ASC 
                  LIMIT 1) as duong_dan_anh')
        )->leftJoin('bien_the_san_phams', 'san_phams.id', '=', 'bien_the_san_phams.san_pham_id')
        ->where('san_phams.noi_bat', 1)
        ->groupBy('san_phams.ten_san_pham', 'san_phams.gia', 'san_phams.gia_khuyen_mai', 'san_phams.ngay_ket_thuc_km', 'san_phams.so_luong', 'san_phams.anh_san_pham', 'san_phams.id', 'san_phams.kieu_san_pham', 'san_phams.mo_ta_ngan')
        ->orderByDesc('san_phams.id')
        ->get();
        $sanPhamDanhGiaTot = SanPham::select(
            'san_phams.id', 
            'san_phams.ten_san_pham', 
            'san_phams.gia',
            'san_phams.gia_khuyen_mai',
            'san_phams.ngay_ket_thuc_km',
            'san_phams.so_luong',
            'san_phams.kieu_san_pham',
            'san_phams.mo_ta_ngan',
            DB::raw('MIN(bien_the_san_phams.gia) as gia_min'),
            DB::raw('MAX(bien_the_san_phams.gia) as gia_max'),
            DB::raw('SUM(bien_the_san_phams.so_luong) as sum_so_luong'),
            'san_phams.anh_san_pham',
            DB::raw('AVG(danh_gias.sao) as trung_binh_sao'),
            DB::raw('(SELECT album_anhs.duong_dan_anh 
                  FROM album_anhs 
                  WHERE album_anhs.san_pham_id = san_phams.id 
                  ORDER BY album_anhs.id ASC 
                  LIMIT 1) as duong_dan_anh')
        )
        ->leftJoin('bien_the_san_phams', 'san_phams.id', '=', 'bien_the_san_phams.san_pham_id')
        ->leftJoin('danh_gias', 'san_phams.id', '=', 'danh_gias.san_pham_id')
        ->groupBy('san_phams.ten_san_pham', 'san_phams.gia', 'san_phams.gia_khuyen_mai', 'san_phams.ngay_ket_thuc_km', 'san_phams.so_luong', 'san_phams.anh_san_pham', 'san_phams.id', 'san_phams.kieu_san_pham', 'san_phams.mo_ta_ngan')
        ->orderByDesc('trung_binh_sao')
        ->orderByDesc('san_phams.id')
        ->paginate(10);
        $idSanPhamKhuyenMai = $sanPhamKhuyenMai->pluck('id')->toArray();
        $idSanPhamBanChay = $sanPhamBanChay->pluck('id')->take(10)->toArray(); // Lấy ra 10 id
        $idSanPhamNoiBat = $sanPhamNoiBat->pluck('id')->toArray();
        $idSanPhamDanhGiaTot = $sanPhamDanhGiaTot->pluck('id')->take(10)->toArray();
        if(Auth::id()){
        $checkSanPhamYeuThichKhuyenMai = SanPham::join('san_pham_yeu_thichs', 'san_phams.id', '=', 'san_pham_yeu_thichs.san_pham_id')
        ->whereIn('san_phams.id', $idSanPhamKhuyenMai)
        ->where('san_pham_yeu_thichs.user_id', Auth::id())
        ->orderByDesc('san_pham_yeu_thichs.id')
        ->get(['san_phams.id as id_san_pham', 'san_pham_yeu_thichs.id as id_san_pham_yeu_thich'])->toArray();
        $checkSanPhamYeuThich = SanPham::join('san_pham_yeu_thichs', 'san_phams.id', '=', 'san_pham_yeu_thichs.san_pham_id')
        ->whereIn('san_phams.id', $idSanPhamBanChay)
        ->where('san_pham_yeu_thichs.user_id', Auth::id())
        ->orderByDesc('san_pham_yeu_thichs.id')
        ->get(['san_phams.id as id_san_pham', 'san_pham_yeu_thichs.id as id_san_pham_yeu_thich'])->toArray();
        $checkSanPhamYeuThichNoiBat = SanPham::join('san_pham_yeu_thichs', 'san_phams.id', '=', 'san_pham_yeu_thichs.san_pham_id')
        ->whereIn('san_phams.id', $idSanPhamNoiBat)
        ->where('san_pham_yeu_thichs.user_id', Auth::id())
        ->orderByDesc('san_pham_yeu_thichs.id')
        ->get(['san_phams.id as id_san_pham', 'san_pham_yeu_thichs.id as id_san_pham_yeu_thich'])->toArray();
        $checkSanPhamYeuThichDanhGiaTot = SanPham::join('san_pham_yeu_thichs', 'san_phams.id', '=', 'san_pham_yeu_thichs.san_pham_id')
        ->whereIn('san_phams.id', $idSanPhamDanhGiaTot)
        ->where('san_pham_yeu_thichs.user_id', Auth::id())
        ->orderByDesc('san_pham_yeu_thichs.id')
        ->get(['san_phams.id as id_san_pham', 'san_pham_yeu_thichs.id as id_san_pham_yeu_thich'])->toArray();
        }else{
            $checkSanPhamYeuThichKhuyenMai = []; 
            $checkSanPhamYeuThich = []; 
            $checkSanPhamYeuThichNoiBat = []; 
            $checkSanPhamYeuThichDanhGiaTot = []; 
        }
        $albumAnhSanPhamKhuyenMai = SanPham::leftJoin('album_anhs', 'san_phams.id', '=', 'album_anhs.san_pham_id')
        ->whereIn('san_phams.id', $idSanPhamKhuyenMai)
        ->get(['san_phams.id as id_san_pham', 'album_anhs.duong_dan_anh', 'album_anhs.id as id_album']);
        $albumAnhSanPhamBanChay = SanPham::leftJoin('album_anhs', 'san_phams.id', '=', 'album_anhs.san_pham_id')
        ->whereIn('san_phams.id', $idSanPhamBanChay)
        ->get(['san_phams.id as id_san_pham', 'album_anhs.duong_dan_anh', 'album_anhs.id as id_album']);
        $albumAnhSanPhamNoiBat = SanPham::leftJoin('album_anhs', 'san_phams.id', '=', 'album_anhs.san_pham_id')
        ->whereIn('san_phams.id', $idSanPhamNoiBat)
        ->get(['san_phams.id as id_san_pham', 'album_anhs.duong_dan_anh', 'album_anhs.id as id_album']);
        $albumAnhSanPhamDanhGiaTot = SanPham::leftJoin('album_anhs', 'san_phams.id', '=', 'album_anhs.san_pham_id')
        ->whereIn('san_phams.id', $idSanPhamDanhGiaTot)
        ->get(['san_phams.id as id_san_pham', 'album_anhs.duong_dan_anh', 'album_anhs.id as id_album']);
        $sanPhamBienTheKhuyenMai = SanPham::select(
            'san_phams.id as id_san_pham', 'bien_the_san_phams.id as id_bien_the',
            'bien_the_san_phams.anh_bien_the_san_pham as anh_bien_the_san_pham', 
            'thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the', 'gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt',
            )
            ->leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
            ->whereIn('san_phams.id', $idSanPhamKhuyenMai)
            ->leftJoin('thuoc_tinh_bien_thes', 'bien_the_san_phams.id', '=', 'thuoc_tinh_bien_thes.bien_the_san_pham_id')
            ->leftJoin('thuoc_tinh_va_gia_tri_bien_thes', 'thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.thuoc_tinh_bien_the_id')
            ->leftJoin('gia_tri_thuoc_tinh_bien_thes', 'gia_tri_thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.gia_tri_thuoc_tinh_bien_the_id') 
            ->get()->toArray();
            $resultKhuyenMai = [];
            foreach ($sanPhamBienTheKhuyenMai as $item) {
                $id_san_pham = $item['id_san_pham'];
                $id_bien_the = $item['id_bien_the'];
                $ten_thuoc_tinh = $item['ten_thuoc_tinh_bien_the'];
                $gia_tri_thuoc_tinh = $item['ten_gia_tri_thuoc_tinh_bt'];

                if ($id_bien_the !== null) {
                    if (!isset($resultKhuyenMai[$id_san_pham])) {
                        $resultKhuyenMai[$id_san_pham] = [];
                    }

                    if (!isset($resultKhuyenMai[$id_san_pham][$ten_thuoc_tinh])) {
                        $resultKhuyenMai[$id_san_pham][$ten_thuoc_tinh] = [];
                    }

                    if (!in_array($gia_tri_thuoc_tinh, $resultKhuyenMai[$id_san_pham][$ten_thuoc_tinh])) {
                        $resultKhuyenMai[$id_san_pham][$ten_thuoc_tinh][] = $gia_tri_thuoc_tinh;
                    }
                }
            }
        $sanPhamBienThe = SanPham::select(
            'san_phams.id as id_san_pham', 'bien_the_san_phams.id as id_bien_the',
            'bien_the_san_phams.anh_bien_the_san_pham as anh_bien_the_san_pham', 
            'thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the', 'gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt',
            )
            ->leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
            ->whereIn('san_phams.id', $idSanPhamBanChay)
            ->leftJoin('thuoc_tinh_bien_thes', 'bien_the_san_phams.id', '=', 'thuoc_tinh_bien_thes.bien_the_san_pham_id')
            ->leftJoin('thuoc_tinh_va_gia_tri_bien_thes', 'thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.thuoc_tinh_bien_the_id')
            ->leftJoin('gia_tri_thuoc_tinh_bien_thes', 'gia_tri_thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.gia_tri_thuoc_tinh_bien_the_id') 
            ->get()->toArray();
            $result = [];
            foreach ($sanPhamBienThe as $item) {
                $id_san_pham = $item['id_san_pham'];
                $id_bien_the = $item['id_bien_the'];
                $ten_thuoc_tinh = $item['ten_thuoc_tinh_bien_the'];
                $gia_tri_thuoc_tinh = $item['ten_gia_tri_thuoc_tinh_bt'];

                if ($id_bien_the !== null) {
                    if (!isset($result[$id_san_pham])) {
                        $result[$id_san_pham] = [];
                    }

                    if (!isset($result[$id_san_pham][$ten_thuoc_tinh])) {
                        $result[$id_san_pham][$ten_thuoc_tinh] = [];
                    }

                    if (!in_array($gia_tri_thuoc_tinh, $result[$id_san_pham][$ten_thuoc_tinh])) {
                        $result[$id_san_pham][$ten_thuoc_tinh][] = $gia_tri_thuoc_tinh;
                    }
                }
            }
            $sanPhamBienTheNoiBat = SanPham::select(
                'san_phams.id as id_san_pham', 'bien_the_san_phams.id as id_bien_the',
                'bien_the_san_phams.anh_bien_the_san_pham as anh_bien_the_san_pham', 
                'thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the', 'gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt',
                )
                ->leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
                ->whereIn('san_phams.id', $idSanPhamNoiBat)
                ->leftJoin('thuoc_tinh_bien_thes', 'bien_the_san_phams.id', '=', 'thuoc_tinh_bien_thes.bien_the_san_pham_id')
                ->leftJoin('thuoc_tinh_va_gia_tri_bien_thes', 'thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.thuoc_tinh_bien_the_id')
                ->leftJoin('gia_tri_thuoc_tinh_bien_thes', 'gia_tri_thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.gia_tri_thuoc_tinh_bien_the_id') 
                ->get()->toArray();
                $resultNoiBat = [];
                foreach ($sanPhamBienTheNoiBat as $item) {
                    $id_san_pham = $item['id_san_pham'];
                    $id_bien_the = $item['id_bien_the'];
                    $ten_thuoc_tinh = $item['ten_thuoc_tinh_bien_the'];
                    $gia_tri_thuoc_tinh = $item['ten_gia_tri_thuoc_tinh_bt'];
    
                    if ($id_bien_the !== null) {
                        if (!isset($resultNoiBat[$id_san_pham])) {
                            $resultNoiBat[$id_san_pham] = [];
                        }
    
                        if (!isset($resultNoiBat[$id_san_pham][$ten_thuoc_tinh])) {
                            $resultNoiBat[$id_san_pham][$ten_thuoc_tinh] = [];
                        }
    
                        if (!in_array($gia_tri_thuoc_tinh, $resultNoiBat[$id_san_pham][$ten_thuoc_tinh])) {
                            $resultNoiBat[$id_san_pham][$ten_thuoc_tinh][] = $gia_tri_thuoc_tinh;
                        }
                    }
                }
                $sanPhamBienTheDanhGiaTot = SanPham::select(
                    'san_phams.id as id_san_pham', 'bien_the_san_phams.id as id_bien_the',
                    'bien_the_san_phams.anh_bien_the_san_pham as anh_bien_the_san_pham', 
                    'thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the', 'gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt',
                    )
                    ->leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
                    ->whereIn('san_phams.id', $idSanPhamDanhGiaTot)
                    ->leftJoin('thuoc_tinh_bien_thes', 'bien_the_san_phams.id', '=', 'thuoc_tinh_bien_thes.bien_the_san_pham_id')
                    ->leftJoin('thuoc_tinh_va_gia_tri_bien_thes', 'thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.thuoc_tinh_bien_the_id')
                    ->leftJoin('gia_tri_thuoc_tinh_bien_thes', 'gia_tri_thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.gia_tri_thuoc_tinh_bien_the_id') 
                    ->get()->toArray();
                    $resultDanhGiaTot = [];
                    foreach ($sanPhamBienTheDanhGiaTot as $item) {
                        $id_san_pham = $item['id_san_pham'];
                        $id_bien_the = $item['id_bien_the'];
                        $ten_thuoc_tinh = $item['ten_thuoc_tinh_bien_the'];
                        $gia_tri_thuoc_tinh = $item['ten_gia_tri_thuoc_tinh_bt'];
        
                        if ($id_bien_the !== null) {
                            if (!isset($resultDanhGiaTot[$id_san_pham])) {
                                $resultDanhGiaTot[$id_san_pham] = [];
                            }
        
                            if (!isset($resultDanhGiaTot[$id_san_pham][$ten_thuoc_tinh])) {
                                $resultDanhGiaTot[$id_san_pham][$ten_thuoc_tinh] = [];
                            }
        
                            if (!in_array($gia_tri_thuoc_tinh, $resultDanhGiaTot[$id_san_pham][$ten_thuoc_tinh])) {
                                $resultDanhGiaTot[$id_san_pham][$ten_thuoc_tinh][] = $gia_tri_thuoc_tinh;
                            }
                        }
                    }
        $sanPhamBienTheKhuyenMaiShow = SanPham::select(
        'bien_the_san_phams.ma_bien_the_san_pham',
        'bien_the_san_phams.anh_bien_the_san_pham',
        'san_phams.id',
        'bien_the_san_phams.gia',
        'bien_the_san_phams.so_luong',
        DB::raw('GROUP_CONCAT(DISTINCT thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the ORDER BY thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the SEPARATOR " - ") AS ten_thuoc_tinh_bien_the'), //thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the
        DB::raw('GROUP_CONCAT(DISTINCT gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt ORDER BY gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt SEPARATOR " - ") AS ten_gia_tri_thuoc_tinh_bt'), //gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt
        )
        ->leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
        ->leftJoin('thuoc_tinh_bien_thes', 'bien_the_san_phams.id', '=', 'thuoc_tinh_bien_thes.bien_the_san_pham_id')
        ->leftJoin('thuoc_tinh_va_gia_tri_bien_thes', 'thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.thuoc_tinh_bien_the_id')
        ->leftJoin('gia_tri_thuoc_tinh_bien_thes', 'gia_tri_thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.gia_tri_thuoc_tinh_bien_the_id')
        ->whereIn('san_phams.id', $idSanPhamKhuyenMai)
        ->whereNotNull('bien_the_san_phams.id')
        ->groupBy(                                                                                                                
        'bien_the_san_phams.ma_bien_the_san_pham', 'bien_the_san_phams.gia', 'san_phams.id', 'bien_the_san_phams.so_luong', 'bien_the_san_phams.anh_bien_the_san_pham'
        )
        ->orderBy('bien_the_san_phams.id')
        ->get();
        $sanPhamBienTheBanChayShow = SanPham::select(
        'bien_the_san_phams.ma_bien_the_san_pham',
        'bien_the_san_phams.anh_bien_the_san_pham',
        'san_phams.id',
        'bien_the_san_phams.gia',
        'bien_the_san_phams.so_luong',
        DB::raw('GROUP_CONCAT(DISTINCT thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the ORDER BY thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the SEPARATOR " - ") AS ten_thuoc_tinh_bien_the'), //thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the
        DB::raw('GROUP_CONCAT(DISTINCT gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt ORDER BY gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt SEPARATOR " - ") AS ten_gia_tri_thuoc_tinh_bt'), //gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt
        )
        ->leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
        ->leftJoin('thuoc_tinh_bien_thes', 'bien_the_san_phams.id', '=', 'thuoc_tinh_bien_thes.bien_the_san_pham_id')
        ->leftJoin('thuoc_tinh_va_gia_tri_bien_thes', 'thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.thuoc_tinh_bien_the_id')
        ->leftJoin('gia_tri_thuoc_tinh_bien_thes', 'gia_tri_thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.gia_tri_thuoc_tinh_bien_the_id')
        ->whereIn('san_phams.id', $idSanPhamBanChay)
        ->whereNotNull('bien_the_san_phams.id')
        ->groupBy(                                                                                                                
        'bien_the_san_phams.ma_bien_the_san_pham', 'bien_the_san_phams.gia', 'san_phams.id', 'bien_the_san_phams.so_luong', 'bien_the_san_phams.anh_bien_the_san_pham'
        )
        ->orderBy('bien_the_san_phams.id')
        ->get();
        $sanPhamBienTheNoiBatShow = SanPham::select(
        'bien_the_san_phams.ma_bien_the_san_pham',
        'bien_the_san_phams.anh_bien_the_san_pham',
        'san_phams.id',
        'bien_the_san_phams.gia',
        'bien_the_san_phams.so_luong',
        DB::raw('GROUP_CONCAT(DISTINCT thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the ORDER BY thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the SEPARATOR " - ") AS ten_thuoc_tinh_bien_the'), //thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the
        DB::raw('GROUP_CONCAT(DISTINCT gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt ORDER BY gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt SEPARATOR " - ") AS ten_gia_tri_thuoc_tinh_bt'), //gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt
        )
        ->leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
        ->leftJoin('thuoc_tinh_bien_thes', 'bien_the_san_phams.id', '=', 'thuoc_tinh_bien_thes.bien_the_san_pham_id')
        ->leftJoin('thuoc_tinh_va_gia_tri_bien_thes', 'thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.thuoc_tinh_bien_the_id')
        ->leftJoin('gia_tri_thuoc_tinh_bien_thes', 'gia_tri_thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.gia_tri_thuoc_tinh_bien_the_id')
        ->whereIn('san_phams.id', $idSanPhamNoiBat)
        ->whereNotNull('bien_the_san_phams.id')
        ->groupBy(                                                                                                                
        'bien_the_san_phams.ma_bien_the_san_pham', 'bien_the_san_phams.gia', 'san_phams.id', 'bien_the_san_phams.so_luong', 'bien_the_san_phams.anh_bien_the_san_pham'
        )
        ->orderBy('bien_the_san_phams.id')
        ->get();
        $sanPhamBienTheDanhGiaTotShow = SanPham::select(
        'bien_the_san_phams.ma_bien_the_san_pham',
        'bien_the_san_phams.anh_bien_the_san_pham',
        'san_phams.id',
        'bien_the_san_phams.gia',
        'bien_the_san_phams.so_luong',
        DB::raw('GROUP_CONCAT(DISTINCT thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the ORDER BY thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the SEPARATOR " - ") AS ten_thuoc_tinh_bien_the'), //thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the
        DB::raw('GROUP_CONCAT(DISTINCT gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt ORDER BY gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt SEPARATOR " - ") AS ten_gia_tri_thuoc_tinh_bt'), //gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt
        )
        ->leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
        ->leftJoin('thuoc_tinh_bien_thes', 'bien_the_san_phams.id', '=', 'thuoc_tinh_bien_thes.bien_the_san_pham_id')
        ->leftJoin('thuoc_tinh_va_gia_tri_bien_thes', 'thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.thuoc_tinh_bien_the_id')
        ->leftJoin('gia_tri_thuoc_tinh_bien_thes', 'gia_tri_thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.gia_tri_thuoc_tinh_bien_the_id')
        ->whereIn('san_phams.id', $idSanPhamDanhGiaTot)
        ->whereNotNull('bien_the_san_phams.id')
        ->groupBy(                                                                                                                
        'bien_the_san_phams.ma_bien_the_san_pham', 'bien_the_san_phams.gia', 'san_phams.id', 'bien_the_san_phams.so_luong', 'bien_the_san_phams.anh_bien_the_san_pham'
        )
        ->orderBy('bien_the_san_phams.id')
        ->get();
        $albumAnhBienTheKhuyenMai = SanPham::leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
        ->whereIn('san_phams.id', $idSanPhamKhuyenMai)->get(['bien_the_san_phams.anh_bien_the_san_pham', 'san_phams.id as id_san_pham', 'bien_the_san_phams.id as id_bien_the']);
        $albumAnhBienThe = SanPham::leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
        ->whereIn('san_phams.id', $idSanPhamBanChay)->get(['bien_the_san_phams.anh_bien_the_san_pham', 'san_phams.id as id_san_pham', 'bien_the_san_phams.id as id_bien_the']);
        $albumAnhBienTheNoiBat = SanPham::leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
        ->whereIn('san_phams.id', $idSanPhamNoiBat)->get(['bien_the_san_phams.anh_bien_the_san_pham', 'san_phams.id as id_san_pham', 'bien_the_san_phams.id as id_bien_the']);
        $albumAnhBienTheDanhGiaTot = SanPham::leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
        ->whereIn('san_phams.id', $idSanPhamDanhGiaTot)->get(['bien_the_san_phams.anh_bien_the_san_pham', 'san_phams.id as id_san_pham', 'bien_the_san_phams.id as id_bien_the']);
        $danhGiaSanPhamDanhGiaTot = User::join("danh_gias", 'users.id', '=', 'danh_gias.user_id')
        ->join('san_phams', 'san_phams.id', '=', 'danh_gias.san_pham_id')
        ->whereIn('san_phams.id', $idSanPhamDanhGiaTot)
        ->orderByDesc('danh_gias.sao')
        ->orderByDesc('danh_gias.id')
        ->get(['users.anh_dai_dien', 'users.name', 'users.id as id_user', 'san_phams.id as id_san_pham', 'san_phams.ten_san_pham', 'danh_gias.sao', 'danh_gias.noi_dung']);
        $danhGiaSanPhamDanhGiaTotUniqueProduct = $danhGiaSanPhamDanhGiaTot->unique('id_san_pham');
        $danhGiaSanPhamDanhGiaTotUniqueProductUser = $danhGiaSanPhamDanhGiaTotUniqueProduct->unique('id_user');
        $danhGiaSanPhamDanhGiaTotUniqueFinal = $danhGiaSanPhamDanhGiaTotUniqueProductUser->take(3);
        $slideShow = SlideShow::where('active', 1)->get(['slide_shows.*']);
        $slideShowActive = SlideShow::select('album_anh_slide_shows.duong_dan_anh', 'album_anh_slide_shows.link')
        ->join('album_anh_slide_shows', 'slide_shows.id', '=', 'album_anh_slide_shows.slide_show_id')
        ->where('slide_shows.active', 1)->orderBy('order')->get();
        $listBaiViet = BaiViet::join("users", "bai_viets.user_id", "=", "users.id")->orderByDesc('bai_viets.id')->get(["bai_viets.*", "users.name"]);
        $template = 'clients.trangchus.index';
        return view('clients.layout', [
            'title' => 'Trang Chủ',
            'template' => $template,
            'listDanhMuc' => $this->listDanhMuc,
            'slideShowActive' => $slideShowActive,
            'sanPhamKhuyenMai' => $sanPhamKhuyenMai,
            'sanPhamBanChay' => $sanPhamBanChay,
            'sanPhamNoiBat' => $sanPhamNoiBat,
            'sanPhamDanhGiaTot' => $sanPhamDanhGiaTot,
            'slideShow' => $slideShow,
            'albumAnhSanPhamKhuyenMai' => $albumAnhSanPhamKhuyenMai,
            'albumAnhSanPhamBanChay' => $albumAnhSanPhamBanChay,
            'albumAnhSanPhamNoiBat' => $albumAnhSanPhamNoiBat,
            'albumAnhSanPhamDanhGiaTot' => $albumAnhSanPhamDanhGiaTot,
            'resultKhuyenMai' => $resultKhuyenMai,
            'result' => $result,
            'resultNoiBat' => $resultNoiBat,
            'resultDanhGiaTot' => $resultDanhGiaTot,
            'albumAnhBienTheKhuyenMai' => $albumAnhBienTheKhuyenMai,
            'albumAnhBienThe' => $albumAnhBienThe,
            'albumAnhBienTheNoiBat' => $albumAnhBienTheNoiBat,
            'albumAnhBienTheDanhGiaTot' => $albumAnhBienTheDanhGiaTot,
            'sanPhamBienTheKhuyenMaiShow' => $sanPhamBienTheKhuyenMaiShow,
            'sanPhamBienTheBanChayShow' => $sanPhamBienTheBanChayShow,
            'sanPhamBienTheNoiBatShow' => $sanPhamBienTheNoiBatShow,
            'sanPhamBienTheDanhGiaTotShow' => $sanPhamBienTheDanhGiaTotShow,
            'checkSanPhamYeuThichKhuyenMai' => $checkSanPhamYeuThichKhuyenMai,
            'checkSanPhamYeuThich' => $checkSanPhamYeuThich,
            'checkSanPhamYeuThichNoiBat' => $checkSanPhamYeuThichNoiBat,
            'checkSanPhamYeuThichDanhGiaTot' => $checkSanPhamYeuThichDanhGiaTot,
            'listBaiViet' => $listBaiViet,
            'danhGiaSanPhamDanhGiaTotUniqueFinal' => $danhGiaSanPhamDanhGiaTotUniqueFinal,
            'listCart' => $this->listCart,
            'countSanPhamYeuThich' => $this->countSanPhamYeuThich
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function shop(Request $request)
    {
            $perPage = $request->query('perpage', 12);
            $category = $request->query('category', 0);
            $orderBy = $request->query('orderby', 1);
            $loai = $request->query('loai', 0);
            $search = $request->query('search', '');
            $query = SanPham::select(
            'san_phams.id',
            'san_phams.ten_san_pham',
            DB::raw('COALESCE(san_phams.gia, MAX(bien_the_san_phams.gia)) as gia_filter'),
            'san_phams.gia',
            'san_phams.gia_khuyen_mai',
            'san_phams.ngay_ket_thuc_km',
            'san_phams.so_luong',
            'san_phams.anh_san_pham',
            'san_phams.kieu_san_pham',
            'san_phams.mo_ta_ngan',
            DB::raw('SUM(chi_tiet_don_hang_tong.so_luong) as ban_chay'),
            DB::raw('AVG(danh_gias_trung_binh.sao) as trungBinhSao'),
            DB::raw('MAX(bien_the_san_phams.gia) as gia_max'),
            DB::raw('MIN(bien_the_san_phams.gia) as gia_min'),
            DB::raw('SUM(bien_the_san_phams.so_luong) as sum_so_luong'),
            DB::raw('(SELECT album_anhs.duong_dan_anh 
                  FROM album_anhs 
                  WHERE album_anhs.san_pham_id = san_phams.id 
                  ORDER BY album_anhs.id ASC 
                  LIMIT 1) as duong_dan_anh')
        )
        ->leftJoin('bien_the_san_phams', 'san_phams.id', '=', 'bien_the_san_phams.san_pham_id')
        ->leftJoin(
        DB::raw('(SELECT san_pham_id, bien_the_san_pham_id, SUM(so_luong) as so_luong 
        FROM chi_tiet_don_hangs 
        GROUP BY san_pham_id, bien_the_san_pham_id) as chi_tiet_don_hang_tong'), function($join) {
        $join->on('chi_tiet_don_hang_tong.san_pham_id', '=', 'san_phams.id')
        ->orOn('chi_tiet_don_hang_tong.bien_the_san_pham_id', '=', 'bien_the_san_phams.id');
        })
        ->leftJoin(DB::raw('(SELECT san_pham_id, AVG(sao) as sao 
        FROM danh_gias
        GROUP BY san_pham_id) as danh_gias_trung_binh'), 'san_phams.id', '=', 'danh_gias_trung_binh.san_pham_id')
        ->groupBy('san_phams.ten_san_pham', 'san_phams.gia', 'san_phams.gia_khuyen_mai', 'san_phams.ngay_ket_thuc_km', 'san_phams.so_luong', 'san_phams.anh_san_pham', 'san_phams.id', 'san_phams.kieu_san_pham', 'san_phams.mo_ta_ngan');
        if($search != ''){
            $query->where('san_phams.ten_san_pham','LIKE', "%".$search."%");
        }
        if($orderBy == '1'){
            $query->orderByDesc('san_phams.id');
        }else if($orderBy == '2'){
            $query->orderBy('san_phams.id');
        }else if($orderBy == '3'){
            $query->orderByDesc('trungBinhSao');
        }else if($orderBy == '4'){
            $query->orderByDesc('ban_chay');
        }else if($orderBy == '5'){
            $query->orderBy('gia_filter');
        }else{
            $query->orderByDesc('gia_filter');
        }
        if($category!=0){
            $query->whereIn('san_phams.danh_muc_id', function ($subQuery) use ($category) {
                $subQuery->select('id')
                    ->from('danh_mucs')
                    ->where('danh_muc_cha_id', $category)
                    ->orWhere('id', $category);
            });
        }
        if($request->input('text')){
            function extractNumbers($text) {
                preg_match_all('/\d+(\.\d{3})*/', $text, $matches);
                $numbers = array_map(function($num) {
                    return (int) str_replace('.', '', $num);
                }, $matches[0]);
                return $numbers;
            }
            $numbers = extractNumbers($request->input('text'));
            $minPrice = $numbers[0];
            $maxPrice = $numbers[1];
            $query->havingBetween('gia_filter', [$minPrice, $maxPrice]);
        }
        if($request->input('loai')!=0){
            $query->where('kieu_san_pham', $request->input('loai'));
        }
        $allSanPham = $query->paginate($perPage);
        if(Auth::id()){
            $checkSanPhamYeuThich = SanPham::join('san_pham_yeu_thichs', 'san_phams.id', '=', 'san_pham_yeu_thichs.san_pham_id')
            ->where('san_pham_yeu_thichs.user_id', Auth::id())
            ->orderByDesc('san_pham_yeu_thichs.id')
            ->get(['san_phams.id as id_san_pham', 'san_pham_yeu_thichs.id as id_san_pham_yeu_thich'])->toArray();
            }else{
                $checkSanPhamYeuThich = [];
            }
        $albumAllSanPham = SanPham::leftJoin('album_anhs', 'san_phams.id', '=', 'album_anhs.san_pham_id')
        ->get(['san_phams.id as id_san_pham', 'album_anhs.duong_dan_anh', 'album_anhs.id as id_album']);
        $sanPhamBienThe = SanPham::select(
            'san_phams.id as id_san_pham', 'bien_the_san_phams.id as id_bien_the',
            'bien_the_san_phams.anh_bien_the_san_pham as anh_bien_the_san_pham', 
            'thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the', 'gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt',
            )
            ->leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
            ->leftJoin('thuoc_tinh_bien_thes', 'bien_the_san_phams.id', '=', 'thuoc_tinh_bien_thes.bien_the_san_pham_id')
            ->leftJoin('thuoc_tinh_va_gia_tri_bien_thes', 'thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.thuoc_tinh_bien_the_id')
            ->leftJoin('gia_tri_thuoc_tinh_bien_thes', 'gia_tri_thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.gia_tri_thuoc_tinh_bien_the_id') 
            ->get()->toArray();
            $result = [];
            foreach ($sanPhamBienThe as $item) {
                $id_san_pham = $item['id_san_pham'];
                $id_bien_the = $item['id_bien_the'];
                $ten_thuoc_tinh = $item['ten_thuoc_tinh_bien_the'];
                $gia_tri_thuoc_tinh = $item['ten_gia_tri_thuoc_tinh_bt'];

                if ($id_bien_the !== null) {
                    if (!isset($result[$id_san_pham])) {
                        $result[$id_san_pham] = [];
                    }

                    if (!isset($result[$id_san_pham][$ten_thuoc_tinh])) {
                        $result[$id_san_pham][$ten_thuoc_tinh] = [];
                    }

                    if (!in_array($gia_tri_thuoc_tinh, $result[$id_san_pham][$ten_thuoc_tinh])) {
                        $result[$id_san_pham][$ten_thuoc_tinh][] = $gia_tri_thuoc_tinh;
                    }
                }
            }
            $sanPhamBienTheAllShow = SanPham::select(
            'bien_the_san_phams.ma_bien_the_san_pham',
            'bien_the_san_phams.anh_bien_the_san_pham',
            'san_phams.id',
            'bien_the_san_phams.gia',
            'bien_the_san_phams.so_luong',
            DB::raw('GROUP_CONCAT(DISTINCT thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the ORDER BY thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the SEPARATOR " - ") AS ten_thuoc_tinh_bien_the'), //thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the
            DB::raw('GROUP_CONCAT(DISTINCT gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt ORDER BY gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt SEPARATOR " - ") AS ten_gia_tri_thuoc_tinh_bt'), //gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt
            )
            ->leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
            ->leftJoin('thuoc_tinh_bien_thes', 'bien_the_san_phams.id', '=', 'thuoc_tinh_bien_thes.bien_the_san_pham_id')
            ->leftJoin('thuoc_tinh_va_gia_tri_bien_thes', 'thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.thuoc_tinh_bien_the_id')
            ->leftJoin('gia_tri_thuoc_tinh_bien_thes', 'gia_tri_thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.gia_tri_thuoc_tinh_bien_the_id')
            ->whereNotNull('bien_the_san_phams.id')
            ->groupBy(                                                                                                                
            'bien_the_san_phams.ma_bien_the_san_pham', 'bien_the_san_phams.gia', 'san_phams.id', 'bien_the_san_phams.so_luong', 'bien_the_san_phams.anh_bien_the_san_pham'
            )
            ->orderBy('bien_the_san_phams.id')
            ->get();
            $albumAnhBienThe = SanPham::leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
            ->get(['bien_the_san_phams.anh_bien_the_san_pham', 'san_phams.id as id_san_pham', 'bien_the_san_phams.id as id_bien_the']);
        $count = SanPham::count();
        $template = 'clients.cuahangs.index';
        return view('clients.layout', [
            'title' => 'Cửa Hàng',
            'template' => $template,
            'listDanhMuc' => $this->listDanhMuc,
            'allSanPham' => $allSanPham,
            'perPage' => $perPage,
            'orderBy' => $orderBy,
            'category' => $category,
            'loai' => $loai,
            'count' =>  $count,
            'search' =>  $search,
            'albumAllSanPham' =>  $albumAllSanPham,
            'sanPhamBienThe' =>  $sanPhamBienThe,
            'albumAnhBienThe' =>  $albumAnhBienThe,
            'result' =>  $result,
            'checkSanPhamYeuThich' =>  $checkSanPhamYeuThich,
            'listCart' => $this->listCart,
            'countSanPhamYeuThich' => $this->countSanPhamYeuThich,
            'sanPhamBienTheAllShow' => $sanPhamBienTheAllShow
        ]);
    }

    public function login()
    {   
        $bien = "Đăng Nhập";
        $template = 'clients.login-signins.login';
        return view('clients.layout', [
            'title' => 'Đăng nhập',
            'template' => $template,
            'listDanhMuc' => $this->listDanhMuc,
            'bien' => $bien,
            'listCart' => $this->listCart,
            'countSanPhamYeuThich' => $this->countSanPhamYeuThich
        ]);
    }

    public function signin()
    {   
        $bien = "Đăng Ký";
        $template = 'clients.login-signins.signin';
        return view('clients.layout', [
            'title' => 'Đăng Ký',
            'template' => $template,
            'listDanhMuc' => $this->listDanhMuc,
            'bien' => $bien,
            'listCart' => $this->listCart,
            'countSanPhamYeuThich' => $this->countSanPhamYeuThich
        ]);
    }

    public function about()
    {   
        $template = 'clients.vechungtois.index';
        return view('clients.layout', [
            'title' => 'Về Chúng Tôi',
            'template' => $template,
            'listDanhMuc' => $this->listDanhMuc,
            'listCart' => $this->listCart,
            'countSanPhamYeuThich' => $this->countSanPhamYeuThich
        ]);
    }

    public function contact()
    {   
        $template = 'clients.lienhes.index';
        return view('clients.layout', [
            'title' => 'Liên Hệ',
            'template' => $template,
            'listDanhMuc' => $this->listDanhMuc,
            'listCart' => $this->listCart,
            'countSanPhamYeuThich' => $this->countSanPhamYeuThich
        ]);
    }

    public function blog(Request $request)
    {   
        $search = $request->query("search", "");
        $danhMucBlog = $request->query('danhmucblog', 0);
        $query = BaiViet::select("bai_viets.*", "users.name")->join("users", "bai_viets.user_id", "=", "users.id");
        if($danhMucBlog != 0){
            $idListSanPham = SanPham::where("danh_muc_id", $danhMucBlog)->get()->pluck('id')->toArray();
            $query->whereIn("bai_viets.san_pham_id", $idListSanPham);
        }
        if($search != ""){
            $query->where("bai_viets.tieu_de", "LIKE", "%".$search."%");
        }
        $listBaiViet = $query->orderByDesc("bai_viets.id")->paginate(6);
        $listBaiVietGanDay = BaiViet::select("bai_viets.*")->orderByDesc("bai_viets.id")->paginate(4);
        $module = 'clients.d_baiviets.components.content';
        $template = 'clients.d_baiviets.index';
        return view('clients.layout', [
            'title' => 'Bài Viết',
            'template' => $template,
            'listDanhMuc' => $this->listDanhMuc,
            'listCart' => $this->listCart,
            'countSanPhamYeuThich' => $this->countSanPhamYeuThich,
            'module' => $module,
            'listBaiViet' => $listBaiViet,
            'listBaiVietGanDay' => $listBaiVietGanDay,
            'search' => $search,
            'danhMucBlog' => $danhMucBlog
        ]);
    }

    public function blogDetail(string $id)
    {   
        $baiVietShow = BaiViet::findOrFail($id);
        if($baiVietShow){
            $next = BaiViet::where('id', '<', $id)
            ->orderBy('id', 'desc')
            ->take(3)
            ->get();
            if ($next->count() < 3) {
            $needed = 3 - $next->count();
            $additionalPosts = BaiViet::where('id', '>', $id)->orderBy('id', 'asc')->take($needed)->get();
            $next = $next->merge($additionalPosts);
            }
            $listBaiVietGanDay = BaiViet::select("bai_viets.*")->orderByDesc("bai_viets.id")->paginate(4);
            $user = User::findOrFail($baiVietShow->user_id);
            $module = 'clients.d_baiviets.components.detail';
            $template = 'clients.d_baiviets.index';
            return view('clients.layout', [
                'title' => 'Bài Viết',
                'template' => $template,
                'listDanhMuc' => $this->listDanhMuc,
                'listCart' => $this->listCart,
                'countSanPhamYeuThich' => $this->countSanPhamYeuThich,
                'baiVietShow' => $baiVietShow,
                'module' => $module,
                'user' => $user,
                'listBaiVietGanDay' => $listBaiVietGanDay,
                'next' => $next
            ]);
        }else{
            return redirect()->back()->with("error", "Không tìm thấy bài viết này");
        }
        
    }
    
    public function storeSignin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required_with:password|same:password'
        ], [
            'name.required' => 'Họ và tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email này đã được sử dụng',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password_confirmation.required_with' => 'Vui lòng xác nhận mật khẩu của bạn',
            'password_confirmation.same' => 'Mật khẩu xác nhận không khớp',
        ]);
        $password = $request->input('password');
        User::create([
            "ma_khach_hang" => "KH-".Str::random(6),
            'name' => $request->input('name'),   
            'email' => $request->input('email'),
            'mat_khau' => $password,
            'password' => Hash::make($password)
            ]
        );
        return redirect()->route('client.form.login')->with("success","Đăng ký thành công");
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ],
        [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
        ]);
        if(Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ])){ 
            return redirect()->route('client.index')->with("success","Đăng nhập thành công");
        }
        return redirect()->back()->with("error","Email hoặc mật khẩu không chính xác");
    }


    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route("client.form.login");
    }
    
    public function comment(Request $request, string $id)
    {   
        $request->validate([
            "comment" => "required",
        ],
        [
           "comment.required" => "Vui lòng nhập nội dung bình luận"
        ]
        );
        if($request->isMethod('POST')){
        if(Auth::id()){
            $sanPhamCheck = SanPham::find($id);
            if($sanPhamCheck){
            BinhLuan::create([
                "ma_binh_luan" => "BL-".Str::random(6),
                'user_id' => Auth::id(),
                'san_pham_id' => $id,
                'noi_dung' => $request->input('comment')
            ]);
        return redirect()->back()->with("success","Gửi bình luận thành công");
        }else{
        return redirect()->back()->with("error","Gửi bình luận không thành công");
        }
        }else{
        return redirect()->back()->with("error","Bạn phải đăng nhập để bình luận");
        }
        }
    }

    public function review(Request $request, string $id)
    {   
        $request->validate([
            "comment" => "required",
            "rating" => "required|in:1,2,3,4,5"
        ],
        [
           "comment.required" => "Vui lòng gửi nhận xét của bạn",
           "rating.*" => "Vui lòng chọn sao"
        ]
        );
        if($request->isMethod('POST')){
        if(Auth::id()){
            $checkDanhGia = SanPham::leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=','san_phams.id')
            ->join('chi_tiet_don_hangs', function($join) {
                $join->on('chi_tiet_don_hangs.san_pham_id', '=', 'san_phams.id')
                     ->orOn('chi_tiet_don_hangs.bien_the_san_pham_id', '=', 'bien_the_san_phams.id');
            })
            ->join('don_hangs', 'don_hangs.id', '=','chi_tiet_don_hangs.don_hang_id')
            ->join('users', 'users.id', '=', 'don_hangs.user_id')
            ->where('users.id', Auth::id())
            ->where('san_phams.id', $id)
            ->orderByDesc('chi_tiet_don_hangs.id')
            ->first(['chi_tiet_don_hangs.id as id_chi_tiet_don_hang', 'san_phams.id as id_san_pham', 'users.id as id_user', 'don_hangs.trang_thai_don_hang_id']);
            if($checkDanhGia === NULL){
            return redirect()->back()->with("error","Bạn chưa mua sản phẩm này");
            }else{
                $listDanhGia = DanhGia::get()->where('user_id', Auth::id())->where('san_pham_id', $id)->where('chi_tiet_don_hang_id', $checkDanhGia->id_chi_tiet_don_hang);
                if($listDanhGia->isEmpty()){
                    if($checkDanhGia->trang_thai_don_hang_id !== 5){
                    return redirect()->back()->with("error", "Đang hàng đang trong quá trình thực hiện");
                    }
                    else{
                        DanhGia::create([
                            "ma_danh_gia" => "DG-".Str::random(6),
                            'san_pham_id' => $id,
                            'user_id' => Auth::id(),
                            'chi_tiet_don_hang_id' => $checkDanhGia->id_chi_tiet_don_hang,
                            'sao' => $request->input('rating'),
                            'noi_dung' => $request->input('comment')
                           ]);
                       return redirect()->back()->with("success","Đánh giá thành công");
                    }
                }else{
                 return redirect()->back()->with("error","Bạn đã đánh giá sản phẩm này rồi");
                }
            }
        }else{
        return redirect()->back()->with("error","Bạn chưa đăng nhập");
        }
        }
    }

    public function addtocart(Request $request, string $id){        
        if(Auth::id()){
            $sanPham = SanPham::find($id);
            if($sanPham){
            if($sanPham->kieu_san_pham == 1){
            $request->validate([
                'quantity' => 'nullable|numeric|integer|min:1|max:50',
            ],
            [
                'quantity.numeric' => 'Số lượng phải là số',
                'quantity.integer' => 'Số lượng phải là số nguyên',
                'quantity.min' => 'Số lượng phải lớn hơn 0',
                'quantity.max' => 'Số lượng phải nhỏ hơn 50',
            ]
            );
            }else{
            $request->validate([
                'values' => 'required',
                'values.*' => 'required|not_in:0',
                'quantity' => 'required|numeric|integer|min:1|max:50',
            ],
            [
                'values.required' => 'Vui lòng chọn thuộc tính',
                'values.*' => 'Vui lòng chọn thuộc tính',
                'quantity.required' => 'Vui lòng nhập số lượng',
                'quantity.numeric' => 'Số lượng phải là số',
                'quantity.integer' => 'Số lượng phải là số nguyên',
                'quantity.min' => 'Số lượng phải lớn hơn 0',
                'quantity.max' => 'Số lượng phải nhỏ hơn 50',
                'quantity.integer' => 'Số lượng phải là số nguyên',
                'quantity.min' => 'Số lượng phải lớn hơn 0',
            ]
            );
            }
            $checkGioHang = GioHang::where('user_id', Auth::id())->get('id');
            if($checkGioHang->isEmpty()){
                $gioHang = GioHang::create(['ma_gio_hang' => "GH-".Str::random(6), 'user_id' => Auth::id()]);
                $gioHangId = $gioHang->id;
            }
            else{
                $gioHangId = $checkGioHang[0]->id;
            }
            if($request->input('quantity') !== null){
                if($request->input('quantity') <= 0){
                return redirect()->back()->with("error","Số lượng phải lớn hơn 0");
                }else{
                        $quantity = $request->input('quantity');
                }
             }else{
                $quantity = 1;
             }
            if($sanPham->kieu_san_pham == 1){
            $checkSanPham = GioHang::join('chi_tiet_gio_hangs', 'gio_hangs.id', '=','chi_tiet_gio_hangs.gio_hang_id')
            ->where('gio_hangs.user_id', Auth::id())
            ->where('chi_tiet_gio_hangs.san_pham_id', $sanPham->id)
            ->get('chi_tiet_gio_hangs.id');
            if(!$checkSanPham->isEmpty()){
                $chiTietGioHang = ChiTietGioHang::findOrFail($checkSanPham[0]->id);
                if($chiTietGioHang->so_luong + $quantity > $sanPham->so_luong){
                    return redirect()->back()->with("error","Số lượng đã vượt quá tồn kho");
                }else{
                $chiTietGioHang->so_luong += $quantity;
                $chiTietGioHang->save();
                }
            }else{
                    if($quantity > $sanPham->so_luong){
                        return redirect()->back()->with("error","Số lượng đã vượt quá tồn kho");
                    }else{
                    ChiTietGioHang::create([
                        'ma_chi_tiet_gio_hang' => "CTGH-".Str::random(5),
                        'gio_hang_id' => $gioHangId,
                        'san_pham_id' => $sanPham->id,
                        'so_luong' => $quantity,
                    ]);
                }
            }
        }else{
            // dd($request->post());
            $bienTheSanPham = SanPham::join('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
            ->join('thuoc_tinh_bien_thes', 'bien_the_san_phams.id', '=', 'thuoc_tinh_bien_thes.bien_the_san_pham_id')
            ->join('thuoc_tinh_va_gia_tri_bien_thes', 'thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.thuoc_tinh_bien_the_id')
            ->join('gia_tri_thuoc_tinh_bien_thes', 'gia_tri_thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.gia_tri_thuoc_tinh_bien_the_id')
            ->where('san_phams.id', $sanPham->id)
            ->groupBy('bien_the_san_phams.id', 'thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the', 'gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt')
            ->get(['bien_the_san_phams.id', 'thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the', 'gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt'])->toArray();
            $result = [];
            foreach ($bienTheSanPham as $item) {
                $idBienThe = $item['id'];
                if (!isset($result[$idBienThe])) {
                    $result[$idBienThe] = [
                        'id' => $idBienThe,
                        'ten_thuoc_tinh_bien_the' => [],
                        'ten_gia_tri_thuoc_tinh_bt' => [],
                    ];
                }
                $result[$idBienThe]['ten_thuoc_tinh_bien_the'][] = $item['ten_thuoc_tinh_bien_the'];
                $result[$idBienThe]['ten_gia_tri_thuoc_tinh_bt'][] = $item['ten_gia_tri_thuoc_tinh_bt'];
               }
            $result = array_values($result);
            $combined = [$request->input('atrributes'), $request->input('values')];

           $resultId = null;
           foreach ($result as $item) {
               if ($item['ten_thuoc_tinh_bien_the'] === $combined[0] && $item['ten_gia_tri_thuoc_tinh_bt'] === $combined[1]) {
                   $resultId = $item['id'];
                   break;
               }
           }
           if($resultId === null){
            return redirect()->back()->with("error", "Không tìm thấy biến thể này");
           }
           $checkBienTheSanPham = GioHang::join('chi_tiet_gio_hangs', 'gio_hangs.id', '=','chi_tiet_gio_hangs.gio_hang_id')
            ->where('gio_hangs.user_id', Auth::id())
            ->where('chi_tiet_gio_hangs.bien_the_san_pham_id', $resultId)
            ->get('chi_tiet_gio_hangs.id');
            $bienTheSanPham = BienTheSanPham::findOrFail($resultId);
            if(!$checkBienTheSanPham->isEmpty()){
                $chiTietGioHang = ChiTietGioHang::findOrFail($checkBienTheSanPham[0]->id);
                if($chiTietGioHang->so_luong + $quantity > $bienTheSanPham->so_luong){
                    return redirect()->back()->with("error","Số lượng đã vượt quá tồn kho");
                }else{
                $chiTietGioHang->so_luong += $quantity;
                $chiTietGioHang->save();
                }
            }else{
                if($quantity > $bienTheSanPham->so_luong){
                    return redirect()->back()->with("error","Số lượng đã vượt quá tồn kho");
                }else{
                ChiTietGioHang::create([
                    'ma_chi_tiet_gio_hang' => "CTGH-".Str::random(5),
                    'gio_hang_id' => $gioHangId,
                    'bien_the_san_pham_id' => $resultId,
                    'so_luong' => $quantity,
                ]);
            }
            } 
        }
          return redirect()->route('client.cart')->with("success","Thêm vào giỏ hàng thành công");
        }else{
          return redirect()->back()->with("error","Không tìm thấy sản phẩm");
        }  
        }else{
            return redirect()->back()->with("error","Vui lòng đăng nhập");
        }           
    }

    public function cart(){
        $module = 'clients.mytaikhoans.components.cart';
        $template = 'clients.mytaikhoans.index';
        return view('clients.layout', [
            'title' => 'Giỏ Hàng Của Tôi',
            'template' => $template,
            'module' => $module,
            'listDanhMuc' => $this->listDanhMuc,
            'listCart' => $this->listCart,
            'countSanPhamYeuThich' => $this->countSanPhamYeuThich
        ]);
    }
    
    public function removeCart(string $id){
        $checkChiTietGioHang = ChiTietGioHang::join('gio_hangs', 'chi_tiet_gio_hangs.gio_hang_id', '=', 'gio_hangs.id')
        ->where('chi_tiet_gio_hangs.id', $id)
        ->where('gio_hangs.user_id', Auth::id())
        ->get('chi_tiet_gio_hangs.id');
        if($checkChiTietGioHang->isEmpty()){
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập');
        }else{
            $chiTietGioHang =  ChiTietGioHang::findOrFail($id);
            $chiTietGioHang->delete();
            return redirect()->back()->with("success","Xóa thành công");
        }   
    }

    public function updateCart(Request $request){
        // dd($request->post());
        $checkGioHang = GioHang::join('users', 'gio_hangs.user_id', '=', 'users.id')
        ->join('chi_tiet_gio_hangs', 'chi_tiet_gio_hangs.gio_hang_id', '=', 'gio_hangs.id')
        ->where("users.id", Auth::id())
        ->orderByDesc("chi_tiet_gio_hangs.id")
        ->get(["chi_tiet_gio_hangs.id as id_ctgh", "chi_tiet_gio_hangs.san_pham_id as id_sp", "chi_tiet_gio_hangs.bien_the_san_pham_id as id_bt"]);
        foreach($checkGioHang as $key => $value){
            if(!isset($request->input("id_alt")[$value->id_ctgh]) || !isset($request->input("kieu_san_pham")[$value->id_ctgh]) || !isset($request->input("quantity")[$value->id_ctgh])){
                return redirect()->back()->with("error","Lỗi cập nhật giỏ hàng");
            }
        }
        $check = true;
        foreach($request->input('quantity') as $key => $value){
            if($value <= 0){
                $check = false;
            }
       }
       if($check){
        foreach($checkGioHang as $key => $value){
            $checkSanPhamInCart = false;
            foreach($request->input("id_alt") as $keyIdAlt => $valueIdAlt){
             if($value->id_sp == NULL && $request->input("kieu_san_pham")[$keyIdAlt] == 2){
                if($request->input("id_alt")[$keyIdAlt] == $value->id_bt){
                 $checkSanPhamInCart = true;
                break;
                }
             }else if($value->id_bt == NULL && $request->input("kieu_san_pham")[$keyIdAlt] == 1){
              if($request->input("id_alt")[$keyIdAlt] == $value->id_sp){
                $checkSanPhamInCart = true;
                break;
              }
             }
            }
            if($checkSanPhamInCart == false){
                return redirect()->back()->with("error","Lỗi cập nhật giỏ hàng");
             }
        }
        $iteration = 1;
        foreach($request->input('quantity') as $key => $value){
             $chiTietGioHang = ChiTietGioHang::findOrFail($key);
             if($request->input('kieu_san_pham')[$key] == 2){
                $bienTheSanPham = BienTheSanPham::findOrFail($request->input('id_alt')[$key]);
                if($bienTheSanPham->so_luong < $value){
                return redirect()->back()->with("error","Sản phẩm thứ ".$iteration." đã quá số lượng tồn kho");
                }else{
                    $chiTietGioHang->so_luong = $value;
                    $chiTietGioHang->save();
                }
             }else{
                $sanPham = SanPham::findOrFail($request->input('id_alt')[$key]);
                if($sanPham->so_luong < $value){
                    return redirect()->back()->with("error","Sản phẩm thứ ".$iteration." đã quá số lượng tồn kho");
                    }else{
                        $chiTietGioHang->so_luong = $value;
                        $chiTietGioHang->save();
                    }
             }
             $iteration ++;
        }
        return redirect()->back()->with("success","Cập nhật thành công");
       } else{
        return redirect()->back()->with("error","Số lượng phải lớn hơn 0");
       }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        $sanPhamCheck = SanPham::find($id);
        if(!$sanPhamCheck){
          return redirect()->back()->with('error', 'Không tìm thấy sản phẩm này');
        }
        $sanPhamCheck->luot_xem += 1;
        $sanPhamCheck->save();
        $next = SanPham::where('id', '<', $id)
            ->orderBy('id', 'desc')
            ->take(1)
            ->get('id');
        $nextAdditional = SanPham::where('id', '>', $id)
            ->orderBy('id', 'desc')
            ->take(1)
            ->get('id');
        $pre = SanPham::where('id', '>', $id)
            ->orderBy('id', 'asc')
            ->take(1)
            ->get('id');
        $preAdditional = SanPham::where('id', '<', $id)
            ->orderBy('id', 'asc')
            ->take(1)
            ->get('id');    
            $nextShow = $next->isEmpty() ? $nextAdditional : $next;
            $preShow = $pre->isEmpty() ? $preAdditional : $pre;
        $sanPhamDetail = SanPham::join('danh_mucs', 'danh_mucs.id', '=', 'san_phams.danh_muc_id')
        ->where('san_phams.id', $id)
        ->get(['san_phams.*', 'danh_mucs.ten_danh_muc', 'danh_mucs.id as id_danh_muc']);
        $sanPhamShow = SanPham::select(
            'bien_the_san_phams.ma_bien_the_san_pham',
            'bien_the_san_phams.anh_bien_the_san_pham',
             DB::raw('COALESCE(bien_the_san_phams.gia, san_phams.gia) as gia'),
             DB::raw('COALESCE(bien_the_san_phams.so_luong, san_phams.so_luong) as so_luong'),
             DB::raw('GROUP_CONCAT(DISTINCT thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the ORDER BY thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the SEPARATOR " - ") AS ten_thuoc_tinh_bien_the'), //thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the
             DB::raw('GROUP_CONCAT(DISTINCT gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt ORDER BY gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt SEPARATOR " - ") AS ten_gia_tri_thuoc_tinh_bt'), //gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt
         )
         ->leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
         ->leftJoin('thuoc_tinh_bien_thes', 'bien_the_san_phams.id', '=', 'thuoc_tinh_bien_thes.bien_the_san_pham_id')
         ->leftJoin('thuoc_tinh_va_gia_tri_bien_thes', 'thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.thuoc_tinh_bien_the_id')
         ->leftJoin('gia_tri_thuoc_tinh_bien_thes', 'gia_tri_thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.gia_tri_thuoc_tinh_bien_the_id')
         ->where('san_phams.id', $id)
         ->groupBy(                                                                                                                
             'bien_the_san_phams.ma_bien_the_san_pham', 'bien_the_san_phams.gia', 'san_phams.gia',
             'bien_the_san_phams.so_luong', 'san_phams.so_luong', 'bien_the_san_phams.anh_bien_the_san_pham',
         )
         ->orderBy('bien_the_san_phams.id')
         ->get();
        $danhMuc = DanhMuc::find($sanPhamDetail[0]->id_danh_muc);
        function getAllParents($danhMuc)
        {
            $parents = [];
            while ($danhMuc->parent) {
                $danhMuc = $danhMuc->parent;
                $parents[] = $danhMuc;
            }
            return $parents;
        }
        $allParents = getAllParents($danhMuc);
        if($sanPhamDetail[0]->kieu_san_pham == 2){
        $sanPhamBienThe = SanPham::select(
            DB::raw('COALESCE(bien_the_san_phams.anh_bien_the_san_pham, san_phams.anh_san_pham) as anh_bien_the_san_pham'),
            'thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the','bien_the_san_phams.id', 'gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt',
            )
            ->leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
            ->leftJoin('thuoc_tinh_bien_thes', 'bien_the_san_phams.id', '=', 'thuoc_tinh_bien_thes.bien_the_san_pham_id')
            ->leftJoin('thuoc_tinh_va_gia_tri_bien_thes', 'thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.thuoc_tinh_bien_the_id')
            ->leftJoin('gia_tri_thuoc_tinh_bien_thes', 'gia_tri_thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.gia_tri_thuoc_tinh_bien_the_id') 
            ->where('san_phams.id', $id)->get()->toArray();
            $minPrice = BienTheSanPham::where('san_pham_id', $id)->min('gia');
            $maxPrice = BienTheSanPham::where('san_pham_id', $id)->max('gia');
            $sumSoLuong = BienTheSanPham::where('san_pham_id', $id)->sum('so_luong');
            $result = [];
            foreach ($sanPhamBienThe as $item) {
                $tenThuocTinh = $item['ten_thuoc_tinh_bien_the'];
                $tenGiaTri = $item['ten_gia_tri_thuoc_tinh_bt'];
                
                if (!isset($result[$tenThuocTinh])) {
                    $result[$tenThuocTinh] = [];
                }
                
                if (!in_array($tenGiaTri, $result[$tenThuocTinh])) {
                    $result[$tenThuocTinh][] = $tenGiaTri;
                }
            }
        // dd($sanPhamBienThe, $minPrice, $maxPrice);
        }else{
            $sanPhamBienThe = NULL;
            $minPrice = NULL;
            $maxPrice = NULL;
            $sumSoLuong = NULL;
            $result = NULL;
        }
        $alBumAnh = SanPham::join('album_anhs', 'album_anhs.san_pham_id', '=', 'san_phams.id')
        ->where('san_phams.id', $id)->get(['album_anhs.duong_dan_anh']);
        $alBumAnhBienThe = SanPham::join('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
        ->where('san_phams.id', $id)->get(['bien_the_san_phams.anh_bien_the_san_pham']);
        $sanPhamCungLoai = SanPham::leftJoin('bien_the_san_phams', 'san_phams.id', '=', 'bien_the_san_phams.san_pham_id')
        ->orderBy('san_phams.id', 'desc')
        ->where('san_phams.id', '<>', $sanPhamDetail[0]->id)->where('danh_muc_id', $sanPhamDetail[0]->danh_muc_id)
        ->groupBy('san_phams.id', 'san_phams.ten_san_pham', 'san_phams.gia', 'san_phams.gia_khuyen_mai', 'san_phams.ngay_ket_thuc_km',
        'san_phams.so_luong', 'san_phams.kieu_san_pham', 'san_phams.mo_ta_ngan', 'san_phams.anh_san_pham')
        ->get([
            'san_phams.id', 
            'san_phams.ten_san_pham', 
            'san_phams.gia',
            'san_phams.gia_khuyen_mai',
            'san_phams.ngay_ket_thuc_km',
            'san_phams.so_luong',
            'san_phams.kieu_san_pham',
            'san_phams.mo_ta_ngan',
            DB::raw('MIN(bien_the_san_phams.gia) as gia_min'),
            DB::raw('MAX(bien_the_san_phams.gia) as gia_max'),
            DB::raw('SUM(bien_the_san_phams.so_luong) as sum_so_luong'),
            'san_phams.anh_san_pham',
            DB::raw('(SELECT album_anhs.duong_dan_anh 
                  FROM album_anhs 
                  WHERE album_anhs.san_pham_id = san_phams.id 
                  ORDER BY album_anhs.id ASC 
                  LIMIT 1) as duong_dan_anh')
        ]);
        $idSanPhamCungLoai = $sanPhamCungLoai->pluck('id')->toArray();
        if(Auth::id()){
        $checkSanPhamYeuThichCungLoai = SanPham::join('san_pham_yeu_thichs', 'san_phams.id', '=', 'san_pham_yeu_thichs.san_pham_id')
        ->whereIn('san_phams.id', $idSanPhamCungLoai)
        ->where('san_pham_yeu_thichs.user_id', Auth::id())
        ->orderByDesc('san_pham_yeu_thichs.id')
        ->get(['san_phams.id as id_san_pham', 'san_pham_yeu_thichs.id as id_san_pham_yeu_thich'])->toArray();
        
        }else{
            $checkSanPhamYeuThichCungLoai = []; 
        }
        $albumAnhSanPhamCungLoai = SanPham::leftJoin('album_anhs', 'san_phams.id', '=', 'album_anhs.san_pham_id')
        ->whereIn('san_phams.id', $idSanPhamCungLoai)
        ->get(['san_phams.id as id_san_pham', 'album_anhs.duong_dan_anh', 'album_anhs.id as id_album']);
        $sanPhamBienTheCungLoai = SanPham::select(
            'san_phams.id as id_san_pham', 'bien_the_san_phams.id as id_bien_the',
            'bien_the_san_phams.anh_bien_the_san_pham as anh_bien_the_san_pham', 
            'thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the', 'gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt',
            )
            ->leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
            ->whereIn('san_phams.id', $idSanPhamCungLoai)
            ->leftJoin('thuoc_tinh_bien_thes', 'bien_the_san_phams.id', '=', 'thuoc_tinh_bien_thes.bien_the_san_pham_id')
            ->leftJoin('thuoc_tinh_va_gia_tri_bien_thes', 'thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.thuoc_tinh_bien_the_id')
            ->leftJoin('gia_tri_thuoc_tinh_bien_thes', 'gia_tri_thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.gia_tri_thuoc_tinh_bien_the_id') 
            ->get()->toArray();
            $resultCungLoai = [];
            foreach ($sanPhamBienTheCungLoai as $item) {
                $id_san_pham = $item['id_san_pham'];
                $id_bien_the = $item['id_bien_the'];
                $ten_thuoc_tinh = $item['ten_thuoc_tinh_bien_the'];
                $gia_tri_thuoc_tinh = $item['ten_gia_tri_thuoc_tinh_bt'];

                if ($id_bien_the !== null) {
                    if (!isset($resultCungLoai[$id_san_pham])) {
                        $resultCungLoai[$id_san_pham] = [];
                    }

                    if (!isset($resultCungLoai[$id_san_pham][$ten_thuoc_tinh])) {
                        $resultCungLoai[$id_san_pham][$ten_thuoc_tinh] = [];
                    }

                    if (!in_array($gia_tri_thuoc_tinh, $resultCungLoai[$id_san_pham][$ten_thuoc_tinh])) {
                        $resultCungLoai[$id_san_pham][$ten_thuoc_tinh][] = $gia_tri_thuoc_tinh;
                    }
                }
            }
        $sanPhamBienTheCungLoaiShow = SanPham::select(
        'bien_the_san_phams.ma_bien_the_san_pham',
        'bien_the_san_phams.anh_bien_the_san_pham',
        'san_phams.id',
        'bien_the_san_phams.gia',
        'bien_the_san_phams.so_luong',
        DB::raw('GROUP_CONCAT(DISTINCT thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the ORDER BY thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the SEPARATOR " - ") AS ten_thuoc_tinh_bien_the'), //thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the
        DB::raw('GROUP_CONCAT(DISTINCT gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt ORDER BY gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt SEPARATOR " - ") AS ten_gia_tri_thuoc_tinh_bt'), //gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt
        )
        ->leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
        ->leftJoin('thuoc_tinh_bien_thes', 'bien_the_san_phams.id', '=', 'thuoc_tinh_bien_thes.bien_the_san_pham_id')
        ->leftJoin('thuoc_tinh_va_gia_tri_bien_thes', 'thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.thuoc_tinh_bien_the_id')
        ->leftJoin('gia_tri_thuoc_tinh_bien_thes', 'gia_tri_thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.gia_tri_thuoc_tinh_bien_the_id')
        ->whereIn('san_phams.id', $idSanPhamCungLoai)
        ->whereNotNull('bien_the_san_phams.id')
        ->groupBy(                                                                                                                
        'bien_the_san_phams.ma_bien_the_san_pham', 'bien_the_san_phams.gia', 'san_phams.id', 'bien_the_san_phams.so_luong', 'bien_the_san_phams.anh_bien_the_san_pham'
        )
        ->orderBy('bien_the_san_phams.id')
        ->get();
        $albumAnhBienTheCungLoai = SanPham::leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
        ->whereIn('san_phams.id', $idSanPhamCungLoai)->get(['bien_the_san_phams.anh_bien_the_san_pham', 'san_phams.id as id_san_pham', 'bien_the_san_phams.id as id_bien_the']);
        $listBinhLuan = SanPham::join('binh_luans', 'san_phams.id', '=', 'binh_luans.san_pham_id')
        ->join('users', 'binh_luans.user_id', '=', 'users.id')
        ->where('san_phams.id', $id)->get(['users.id','users.name','users.anh_dai_dien','binh_luans.noi_dung', 'binh_luans.thoi_gian']);
        $listDanhGia = DanhGia::join('san_phams', 'san_phams.id', '=', 'danh_gias.san_pham_id')
        ->join('users', 'danh_gias.user_id', '=', 'users.id')
        ->where('san_phams.id', $id)->get(['users.id','users.name','users.anh_dai_dien','danh_gias.noi_dung', 'danh_gias.ngay_danh_gia', 'danh_gias.sao']);
        $trungBinhSao = $listDanhGia->avg('sao');
        $template = 'clients.sanphamchitiets.index';
        return view('clients.layout', [
            'title' => 'Chi Tiết Sản Phẩm',
            'template' => $template,
            'listDanhMuc' => $this->listDanhMuc,
            'sanPhamDetail' => $sanPhamDetail,
            'alBumAnh' => $alBumAnh,
            'sanPhamDetail' => $sanPhamDetail,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'sumSoLuong' => $sumSoLuong,
            'result' => $result,
            'sanPhamCungLoai' => $sanPhamCungLoai,
            'listBinhLuan' => $listBinhLuan,
            'listDanhGia' => $listDanhGia,
            'trungBinhSao' => $trungBinhSao,
            'listCart' => $this->listCart,
            'countSanPhamYeuThich' => $this->countSanPhamYeuThich,
            'alBumAnhBienThe' => $alBumAnhBienThe,
            'nextShow' => $nextShow,
            'preShow' => $preShow,
            'allParents' => $allParents,
            'checkSanPhamYeuThichCungLoai' => $checkSanPhamYeuThichCungLoai,
            'albumAnhSanPhamCungLoai' => $albumAnhSanPhamCungLoai,
            'albumAnhBienTheCungLoai' => $albumAnhBienTheCungLoai,
            'resultCungLoai' => $resultCungLoai,
            'sanPhamShow' => $sanPhamShow,
            'sanPhamBienTheCungLoaiShow' => $sanPhamBienTheCungLoaiShow
        ]);
    }

    public function checkout(){
        if(count($this->listCart) <= 0){
            return redirect()->back()->with("error", "Bạn chưa có sản phẩm nào trong giỏ hàng");
        }
        $template = 'clients.thanhtoans.index';
        return view('clients.layout', [
            'title' => 'Thanh Toán',
            'template' => $template,
            'listDanhMuc' => $this->listDanhMuc,
            'listCart' => $this->listCart,
            'countSanPhamYeuThich' => $this->countSanPhamYeuThich
        ]);
    }

    public function checkoutPost(Request $request){
    if($request->isMethod("POST")){
        if(!preg_match('/^(?=(?:.*\d){10})[0-9a-zA-Z\(\)\+\.\-\s]*$/', $request->input("phone"))){
            $errorPhone = 'Số điện thoại phải có ít nhất 10 chữ số';
        }else if(!preg_match('/^\+?[0-9\s\(\)\-\.]{10,}$/', $request->input("phone"))){
            $errorPhone = 'Số điện thoại không đúng định dạng';
        }else{
            $errorPhone = '';
        }
    $request->validate([
        "name" => "required",
        "email" => "required|email",
        "phone" => [
            "required",
            "min:10",
            "max:20",
            "regex:/^(?=(?:.*\d){10})[0-9a-zA-Z\(\)\+\.\-\s]*$/",
            "regex:/^\+?[0-9\s\(\)\-\.]{10,}$/"
        ],
        "address" => "required",
        "pttt" => "required"
    ],
    [
        "name.required" => "Không được để trống họ và tên",
        "email.required" => "Không được để trống email",
        "email.email" => "Email không đúng định dạng",
        "phone.required" => "Không được để trống số điện thoại",
        "phone.min" => "Số điện thoại phải có ít nhất 10 ký tự",
        "phone.max" => "Số điện thoại không được quá 20 ký tự",
        "phone.regex" => $errorPhone,
        "address.required" => "Không được để trống địa chỉ",
        "pttt.required" => "Chọn phương thức thanh toán"
    ]
    );
    // $pttt = HinhThucThanhToan::get('id');
    // $checkPTTT = false;
    // foreach($pttt as $key => $value){
    //     if($value->id == $request->input('pttt')){
    //        $checkPTTT = true;
    //     }
    // }
    $listGioHang = GioHang::join('chi_tiet_gio_hangs' , 'chi_tiet_gio_hangs.gio_hang_id', '=', 'gio_hangs.id')
    ->leftjoin('san_phams', 'san_phams.id', '=', 'chi_tiet_gio_hangs.san_pham_id')
    ->leftJoin('bien_the_san_phams', 'chi_tiet_gio_hangs.bien_the_san_pham_id', '=', 'bien_the_san_phams.id')
    ->where('gio_hangs.user_id', Auth::id())
    ->orderByDesc('chi_tiet_gio_hangs.id')
    ->get(['chi_tiet_gio_hangs.*', DB::raw('COALESCE(san_phams.gia_khuyen_mai, san_phams.gia, bien_the_san_phams.gia) as gia')]);
    $idSanPhamDonGianGioHang = $listGioHang->pluck("san_pham_id")->toArray();
    $idSanPhamBienTheGioHang = $listGioHang->pluck("bien_the_san_pham_id")->toArray();
    $checkSoLuongDonGian = SanPham::whereIn("id", $idSanPhamDonGianGioHang)->orderByDesc("id")->get(["id", "so_luong"]);
    $checkSoLuongBienThe = BienTheSanPham::whereIn("id", $idSanPhamBienTheGioHang)->orderByDesc("id")->get(["id", "so_luong"]);
    $iteration = 1;
    foreach($listGioHang as $key => $value){
        if($value->san_pham_id != NULL){
        foreach($checkSoLuongDonGian as $keyDonGian => $valueDonGian){
            if($value->san_pham_id == $valueDonGian->id && $value->so_luong > $valueDonGian->so_luong){
            return redirect()->back()->with("error","Sản phẩm thứ ".$iteration." đã quá tồn kho");
            }
        }
        }else{
            foreach($checkSoLuongBienThe as $keyBienThe => $valueBienThe){
                if($value->bien_the_san_pham_id == $valueBienThe->id && $value->so_luong > $valueBienThe->so_luong){
                return redirect()->back()->with("error","Sản phẩm thứ ".$iteration." đã quá tồn kho");
                }
            }
        }
    $iteration ++;    
    }
    $tongTien = 0;
    foreach($listGioHang as $key => $value){
    $tongTien += $value->gia * $value->so_luong;
    }
     $donHang = DonHang::create([
        'ma_don_hang' => "DH-".Str::random(6),
        'user_id' => Auth::id(),
        'ten_nguoi_nhan' => $request->input('name'),
        'email_nguoi_nhan' => $request->input('email'),
        'so_dien_thoai_nguoi_nhan' => $request->input('phone'),
        'dia_chi_nguoi_nhan' => $request->input('address'),
        'tong_tien' => $tongTien,
        'ghi_chu' => $request->input('order_comments'),
        'phuong_thuc_thanh_toan_id' => 4,
        'trang_thai_don_hang_id' => 2,
     ]);
     $listGioHangAlt = GioHang::join('chi_tiet_gio_hangs' , 'chi_tiet_gio_hangs.gio_hang_id', '=', 'gio_hangs.id')
    ->leftjoin('san_phams', 'san_phams.id', '=', 'chi_tiet_gio_hangs.san_pham_id')
    ->leftJoin('bien_the_san_phams', 'chi_tiet_gio_hangs.bien_the_san_pham_id', '=', 'bien_the_san_phams.id')
    ->where('gio_hangs.user_id', Auth::id())
    ->orderBy('chi_tiet_gio_hangs.id')
    ->get(['chi_tiet_gio_hangs.*', DB::raw('COALESCE(san_phams.gia_khuyen_mai, san_phams.gia, bien_the_san_phams.gia) as gia')]);
     foreach($listGioHangAlt as $key => $value){
        $chiTietGioHangDelete = ChiTietGioHang::findOrFail($value->id);
        ChiTietDonHang::create([
        'ma_chi_tiet_don_hang' => "CTDH-".Str::random(5),
        'don_hang_id' => $donHang->id,
        'san_pham_id' => $value->san_pham_id,
        'bien_the_san_pham_id' => $value->bien_the_san_pham_id,
        'so_luong' => $value->so_luong,
        'gia' => $value->gia,
        'thanh_tien' => $value->gia * $value->so_luong
        ]);
        if($value->san_pham_id !== NULL){
        $sanPham = SanPham::findOrFail($value->san_pham_id);
        $sanPham->so_luong -= $value->so_luong;
        $sanPham->save();
        }else{
            $bienTheSanPham = BienTheSanPham::findOrFail($value->bien_the_san_pham_id);
            $bienTheSanPham->so_luong -= $value->so_luong;
            $bienTheSanPham->save();
        }
        $chiTietGioHangDelete->delete();
     }
     return redirect()->route('client.info.user')->with("success","Thanh toán thành công");
    }
}
}