<?php

namespace App\Http\Controllers\admins;

use App\Models\User;
use App\Models\DonHang;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\KhachHangs\FormAddRequest;
use App\Http\Requests\KhachHangs\FormUpdateRequest;

class KhachHangController extends Controller
{
    protected $active = "Danh Sách Khách Hàng";
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $keyWord = $request->query('keyword', '');
        $role = $request->query('role', 0);
        $perPage = $request->query('perpage', 8);
        $orderBy = $request->query('version', "DESC");
        $query = User::select("*");
        if ($role != 0) {
            $query->where('vai_tro', $role);
        }
        if($keyWord != ''){
            $query->where('name','LIKE', "%".$keyWord."%");
        }
        $listKhachHang = $query->orderBy('id', $orderBy)->paginate($perPage);
        $template = 'admins.khachhangs.list';
        return view('admins.layout',[
            'title' => 'Danh Sách Khách Hàng',
            'template' => $template,
            'active' => $this->active,
            'listKhachHang' => $listKhachHang,
            'perPage' => $perPage,
            'orderBy' => $orderBy,
            'role' => $role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $template = 'admins.khachhangs.add';
        return view('admins.layout',['title' => 'Thêm Khách Hàng', 'template' => $template, 'active' => $this->active]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormAddRequest $request)
    {
        if($request->isMethod('POST')){
            if($request->hasFile("image")){
                // Thêm hình ảnh
                $fileName = $request->file('image')->store('uploads/khachhang', "public");
            }else{
                $fileName = NULL;
            }
            
            $data = [
                "ma_khach_hang" => "KH-".Str::random(6),
                "name" => $request->input('name'),
                "so_dien_thoai" => $request->input('phone'),
                "email" => $request->input('email'),
                "dia_chi" => $request->input('address'),
                "anh_dai_dien" => $fileName,
                "vai_tro" => $request->input('role'),
                "mat_khau" => $request->input('password'),
                "password" => Hash::make($request->input('password')),
            ];
            User::create($data);
            return redirect()->route('khachhang.index')->with('success','Thêm mới khách hàng thành công');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $khachHangShowOrder = User::select(   
        DB::raw('COALESCE(san_phams.ten_san_pham, san_phams_alt.ten_san_pham) as ten_san_pham'),
        DB::raw('COALESCE(san_phams.id, san_phams_alt.id) as id_san_pham'),
        'bien_the_san_phams.id as id_bien_the',
        DB::raw('COALESCE(NULLIF(san_phams.anh_san_pham, ""), NULLIF(bien_the_san_phams.anh_bien_the_san_pham, ""), san_phams_alt.anh_san_pham) as anh_san_pham'),
        DB::raw('COALESCE(san_phams.gia, bien_the_san_phams.gia) as gia'),
        DB::raw('GROUP_CONCAT(DISTINCT thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the ORDER BY thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the SEPARATOR " - ") AS ten_thuoc_tinh_bien_the'), //thuoc_tinh_bien_thes.ten_thuoc_tinh_bien_the
        DB::raw('GROUP_CONCAT(DISTINCT gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt ORDER BY gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt SEPARATOR " - ") AS ten_gia_tri_thuoc_tinh_bt'), //gia_tri_thuoc_tinh_bien_thes.ten_gia_tri_thuoc_tinh_bt
        DB::raw('COALESCE(danh_mucs.ten_danh_muc, danh_mucs_alt.ten_danh_muc) as ten_danh_muc')
        )
        ->leftJoin('don_hangs', 'users.id' , '=', 'don_hangs.user_id')
        ->leftJoin('chi_tiet_don_hangs' ,'don_hangs.id', '=', 'chi_tiet_don_hangs.don_hang_id')
        ->leftJoin('san_phams', 'san_phams.id', '=', 'chi_tiet_don_hangs.san_pham_id')
        ->leftJoin('danh_mucs', 'danh_mucs.id', '=', 'san_phams.danh_muc_id')
        ->leftJoin('bien_the_san_phams', 'chi_tiet_don_hangs.bien_the_san_pham_id', '=', 'bien_the_san_phams.id')
        ->leftJoin('san_phams as san_phams_alt', 'san_phams_alt.id', '=', 'bien_the_san_phams.san_pham_id')
        ->leftJoin('danh_mucs as danh_mucs_alt', 'danh_mucs_alt.id', '=', 'san_phams_alt.danh_muc_id')
        ->leftJoin('thuoc_tinh_bien_thes', 'bien_the_san_phams.id', '=', 'thuoc_tinh_bien_thes.bien_the_san_pham_id')
        ->leftJoin('thuoc_tinh_va_gia_tri_bien_thes', 'thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.thuoc_tinh_bien_the_id')
        ->leftJoin('gia_tri_thuoc_tinh_bien_thes', 'gia_tri_thuoc_tinh_bien_thes.id', '=', 'thuoc_tinh_va_gia_tri_bien_thes.gia_tri_thuoc_tinh_bien_the_id')
        ->where('users.id', '=', $id)
        ->groupBy(                                                                                  
            'users.id', 'san_phams.ten_san_pham', 'san_phams_alt.ten_san_pham',
            'san_phams.anh_san_pham', 'bien_the_san_phams.anh_bien_the_san_pham', 
            'san_phams_alt.anh_san_pham', 'san_phams.gia', 'bien_the_san_phams.gia',
            'danh_mucs.ten_danh_muc', 'danh_mucs_alt.ten_danh_muc', 'san_phams.id',
            'san_phams_alt.id', 'bien_the_san_phams.id'
        )->distinct()->paginate(3);
        $khachHangShow = User::find($id);
        $khachHangShowOther = User::select(
        DB::raw('COUNT(users.id) as so_don_hang'),
        DB::raw('SUM(don_hangs.tong_tien) AS tong_tien_tat_ca_don_hang'))
        ->join('don_hangs', 'users.id' , '=', 'don_hangs.user_id')->where('users.id', $id)->get();
        $soLuongSanPham = User::select(   
            DB::raw('SUM(chi_tiet_don_hangs.so_luong) as so_luong')
            )
            ->leftJoin('don_hangs', 'users.id' , '=', 'don_hangs.user_id')
            ->leftJoin('chi_tiet_don_hangs' ,'don_hangs.id', '=', 'chi_tiet_don_hangs.don_hang_id')
            ->leftJoin('san_phams', 'san_phams.id', '=', 'chi_tiet_don_hangs.san_pham_id')
            ->leftJoin('bien_the_san_phams', 'chi_tiet_don_hangs.bien_the_san_pham_id', '=', 'bien_the_san_phams.id')
            ->where('users.id', '=', $id)
            ->get();
        $rankedUsers = User::select('users.id','users.name', DB::raw('SUM(don_hangs.tong_tien) as total_amount'))
        ->leftJoin('don_hangs', 'users.id', '=', 'don_hangs.user_id')
        ->groupBy('users.id', 'users.name')
        ->orderByDesc('total_amount')
        ->get()
        ->map(function ($user, $index) {
        $user->rank = $index + 1;
        return $user;
        })->toArray();
        $userRank = array_filter($rankedUsers, function ($user) use ($id) {
            return $user['id'] == $id;
        });
        $userRank = array_shift($userRank);
        $khachHangComentReview =  User::select(
        DB::raw('COUNT(DISTINCT binh_luans.id) as binh_luans_count'),
        DB::raw('COUNT(DISTINCT danh_gias.id) as danh_gias_count'))
        ->leftJoin('binh_luans', 'users.id' , '=', 'binh_luans.user_id')
        ->leftJoin('danh_gias', 'users.id' , '=', 'danh_gias.user_id')
        ->where('users.id', $id)
        ->get();
        // dd($khachHangShow, $khachHangShowOrder, $khachHangShowOther, $soLuongSanPham, $userRank);
        
        // Lấy 5 bản ghi có ID lớn hơn ID hiện tại
        $above = User::where('id', '>', $id)
        ->orderBy('id', 'asc')
        ->take(5)
        ->get();
        // Lấy 5 bản ghi có ID nhỏ hơn ID hiện tại
        $below = User::where('id', '<', $id)
        ->orderBy('id', 'desc')
        ->take(5)
        ->get();
        // Kết hợp kết quả và sắp xếp lại
        $khachHangLienQuan = $below->merge($above)->sortBy('id')->values();
        $template = 'admins.khachhangs.show';
        return view('admins.layout',[
            'title' => 'Chi Tiết Khách Hàng',
            'template' => $template,
            'active' => $this->active,
            'khachHangShow' => $khachHangShow,
            'khachHangShowOrder' => $khachHangShowOrder,
            'khachHangShowOther' => $khachHangShowOther,
            'soLuongSanPham' => $soLuongSanPham,
            'userRank' => $userRank,
            'khachHangComentReview' => $khachHangComentReview,
            'khachHangLienQuan' => $khachHangLienQuan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $khachHangDetail = User::find($id);
        if(!$khachHangDetail){
            return redirect()->route("khachhang.index")->with("error", "Khách hàng này không tồn tại");
        }else{
        $template = 'admins.khachhangs.update';
        return view('admins.layout',['title' => 'Sửa Khách Hàng', 'template' => $template, 'active' => $this->active, 'khachHangDetail' => $khachHangDetail]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormUpdateRequest $request, string $id)
    {
        if($request->isMethod('PUT')){
            $khachHangUpdate = User::find($id);
            if($khachHangUpdate){
              if ($request->hasFile('image')) {  
                if($khachHangUpdate->anh_dai_dien && Storage::disk('public')->exists($khachHangUpdate->anh_dai_dien)){
                    Storage::disk('public')->delete($khachHangUpdate->anh_dai_dien);
                } 
                   //Lưu ảnh mới
                   $fileName = $request->file('image')->store("uploads/khachhang", "public");
                }else{
                   $fileName = $khachHangUpdate->anh_dai_dien;
                }
            $khachHangUpdate->name = $request->input('name');
            $khachHangUpdate->so_dien_thoai = $request->input('phone');
            $khachHangUpdate->email = $request->input('email');
            $khachHangUpdate->dia_chi = $request->input('address');
            $khachHangUpdate->anh_dai_dien = $fileName;
            $khachHangUpdate->vai_tro = $request->input('role');
            $khachHangUpdate->mat_khau = $request->input('password');
            $khachHangUpdate->password = Hash::make($request->input('password'));
            $khachHangUpdate->save();
            return redirect()->route("khachhang.index")->with("success", "Cập nhật khách hàng thành công");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $khachHangTrash = User::find($id);
        if($khachHangTrash){
            $khachHangTrash->delete();
            return redirect()->route("khachhang.index")->with("success", "Chuyển vào thùng rác thành công");
        }
    }
}