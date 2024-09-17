<?php

namespace App\Http\Controllers\Admins;

use App\Models\DanhGia;
use App\Models\DanhMuc;
use App\Models\SanPham;
use App\Models\AlbumAnh;
use App\Models\BinhLuan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\BienTheSanPham;
use App\Models\ThuocTinhBienThe;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\GiaTriThuocTinhBienThe;
use Illuminate\Support\Facades\Storage;
use App\Models\ThuocTinhVaGiaTriBienThe;
use App\Http\Requests\SanPhams\FormAddRequest;
use App\Http\Requests\SanPhams\FormUpdateRequest;
use App\Mail\MailConfirm;

class SanPhamController extends Controller
{
    // construct sử dụng khi dùng SQL thuần và Query Builder
    // protected $sanPham;
    /**
     * Display a listing of the resource.
     */
    // public function __construct() //Khởi tạo mội đối tượng khởi tạo model
    // {
    //     $this->sanPham = new SanPham();
    // }
    protected $active = "Danh Sách Sản Phẩm";
    public function index(Request $request)
    {
        //Lấy dữ liệu
        // $listSanPham = $this->sanPham->getAll();
        $keyWord = $request->query('keyword', '');
        $category = $request->query('category', 0);
        $perPage = $request->query('perpage', 8);
        $orderBy = $request->query('version', "DESC");
        //Sử dụng Eloquent
        $listDanhMuc = DanhMuc::where("danh_muc_cha_id", NULL)->with(['children' => function ($queryFunction) {
            $queryFunction->orderBy('id', 'DESC'); // Sắp xếp theo tên danh mục giảm dần
        }])->orderByDesc('id')->get();
        $query = SanPham::select('san_phams.id', 'san_phams.ma_san_pham','san_phams.ten_san_pham', 'san_phams.anh_san_pham',
        'san_phams.gia', 'san_phams.gia_khuyen_mai', 'san_phams.ngay_nhap','danh_mucs.ten_danh_muc',
        DB::raw('COALESCE(SUM(bien_the_san_phams.so_luong), san_phams.so_luong) as so_luong'),
        DB::raw('MAX(bien_the_san_phams.gia) as gia_max'),
        DB::raw('MIN(bien_the_san_phams.gia) as gia_min')
        )
        ->join('danh_mucs', 'san_phams.danh_muc_id', '=', 'danh_mucs.id')
        ->leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
        ->groupBy('san_phams.id', 'san_phams.ma_san_pham','san_phams.ten_san_pham', 'san_phams.anh_san_pham','san_phams.gia', 'san_phams.gia_khuyen_mai', 'san_phams.ngay_nhap', 'danh_mucs.ten_danh_muc', 'san_phams.so_luong');
        if ($category != 0) {
            $query->whereIn('san_phams.danh_muc_id', function ($subQuery) use ($category) {
                $subQuery->select('id')
                    ->from('danh_mucs')
                    ->where('danh_muc_cha_id', $category)
                    ->orWhere('id', $category);
            });
        }
        if($keyWord != ''){
            $query->where('san_phams.ten_san_pham','LIKE', "%".$keyWord."%");
        }
        $listSanPham = $query->orderBy('san_phams.id', $orderBy)
        ->paginate($perPage);
        // toArray để lấy ra mảng dữ liệu
        // $listSanPham->appends(['perpage' => $perPage, 'version' => $orderBy], 'category' => $category, 'keyword' => $keyWord); //Không có cũng đc
        $template = 'admins.sanphams.list';
        return view('admins.layout', [
            'title' => 'Danh Sách Sản Phẩm',
            'template' => $template,
            'active' => $this->active,
            'listSanPham' => $listSanPham,
            'listDanhMuc' => $listDanhMuc,
            'perPage' => $perPage,
            'orderBy' => $orderBy,
            'category' => $category
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $listDanhMuc = DanhMuc::where("danh_muc_cha_id", NULL)->with(['children' => function ($query) {
            $query->orderBy('id', 'DESC'); // Sắp xếp theo tên danh mục giảm dần
        }])->orderByDesc('id')->get();
        $template = 'admins.sanphams.add';
        return view('admins.layout', ['title' => 'Thêm Sản Phẩm', 'template' => $template, 'active' => $this->active, 'listDanhMuc' => $listDanhMuc]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormAddRequest $request)
    {
        // dd($request->post());
       //Kiểm tra người dùng có sử dụng form để gửi dữ liệu lên không
       if($request->isMethod('POST')){
        // $params = $request->post();
        // // unset($params['_token']); // xóa _token cách 1
        // $params = $request->except('_token'); //xóa _token cách 2
        // $this->sanPham->createSanPham($params);
        //Quay lại trang danh sách và bắn thông báo
        // Thêm hình ảnh
        $success = false;
        if($request->input('type') == 1){
        
        if($request->hasFile("image")){
            // Thêm hình ảnh
            $fileName = $request->file('image')->store('uploads/sanpham', "public");
        }else{
            $fileName = NULL;
        }
        $featured = $request->has("featured") ? 1 : 0;
        // php artisan storage:link
        $data = [
            "ma_san_pham" => "SP-".Str::random(6),
            "ten_san_pham" => $request->input('name'),
            "anh_san_pham" => $fileName,
            "gia" => $request->input('price'),
            "gia_khuyen_mai" => $request->input('promotion_price'),
            "ngay_ket_thuc_km" => $request->input('promotion_end_date'),
            "so_luong" => $request->input('quantity'),
            "mo_ta_ngan" => $request->input('short-description'),
            "mo_ta" => $request->input('description'),
            "danh_muc_id" => $request->input('category'),
            "noi_bat" => $featured
        ];
        $sanPham = SanPham::create($data);
        $sanPhamId = $sanPham->id;
        if($request->hasFile("album_anhs")){
            foreach($request->file("album_anhs") as $file){
                   if($file){
                    $fileName = $file->store('uploads/hinhanhsanpham/id_'. $sanPhamId, "public");
                    AlbumAnh::create([
                        'ma_album_anh' => "ABLA-".Str::random(5),
                        'duong_dan_anh' => $fileName,
                        'san_pham_id' => $sanPhamId
                    ]);
                   }
            }
           
        }
        //Sau khi thêm sản phẩm thì sẽ gửi mail thông tin sản phẩm đó về
        // Mail::to(Auth::user()->email)->send(new MailConfirm($sanPham));
        $success = true;
       }else{
        // $variants = $request->input('variants');
        // $valueNames = [];
        // foreach ($request->input('value_names') as $key => $value) {
        //     // Tách các giá trị dựa trên dấu phân cách '|'
        //     $parts = explode('|', $value);
        //     // Kết hợp các giá trị vào mảng mới
        //     $valueNames[$key] = $parts;
        // }
        // dd($request->post(), $valueNames);
        // if($request->hasFile("image")){
        //     // Thêm hình ảnh
        //     $fileName = $request->file('image')->store('uploads/sanpham', "public");
        // }else{
        //     $fileName = NULL;
        // }
        // // php artisan storage:link
        // $data = [
        //     "ma_san_pham" => "SP-".Str::random(6),
        //     "ten_san_pham" => $request->input('name'),
        //     "anh_san_pham" => $fileName,
        //     "mo_ta_ngan" => $request->input('short-description'),
        //     "mo_ta" => $request->input('description'),
        //     "danh_muc_id" => $request->input('category'),
        // ];
        // $product = SanPham::create($data);
        // $productId = $product->id;
        // foreach ($variants as $key) {
        //   if($request->hasFile('image-variant')){
        //     if(isset($request->file('image-variant')[$key])){
        //         $fileNameVariant = $request->file('image-variant')[$key]->store('uploads/bienthesanpham/'.$$productId, "public");
        //     }else{
        //         $fileNameVariant = NULL;
        //     }
        //   }else{
        //     $fileNameVariant = NULL;
        //   }
        //     $dataVariant = [
        //     'ma_bien_the_san_pham' => "BTSP-".Str::random(5),
        //     'anh_bien_the_san_pham' => $fileNameVariant,
        //     'san_pham_id' => $productId,
        //     'gia' => $request->input('price-variant')[$key],
        //     'so_luong' =>$request->input('quantity-variant')[$key],
        //     ];
        //      $productVariant = BienTheSanPham::create($dataVariant);
        //      $productVariantId = $productVariant->id;
        //      foreach($request->input('atrribute_name') as $key){
        //         $dataAtrribute = [
        //          'ma_thuoc_tinh_bien_the' => "TTBT-".Str::random(5),
        //          'ten_thuoc_tinh_bien_the' => $request->input('atrribute_name')[$key],
        //          'bien_the_san_pham_id' => $productVariantId,
        //         ];
        //         $atrributeVariant = ThuocTinhBienThe::create($dataAtrribute);
        //         foreach($valueNames as $key => $value){
        //             $dataValue = [
        //                 'ma_gia_tri_thuoc_tinh_bt' => "GTTT-".Str::random(5),
        //                 'ten_gia_tri_thuoc_tinh_bt' => $valueNames[$key]
        //             ];
        //               $valueVariant = GiaTriThuocTinhBienThe::create($dataValue);
        //         }
        //         $atrributeVariantId = $atrributeVariant->id;
        //         $valueVariantId = $valueVariant->id;
        //         $dataAtrributeValue = [
        //             'ma_thuoc_tinh_va_gia_tri' => "TTGT-".Str::random(5),
        //             'thuoc_tinh_bien_the_id' => $atrributeVariantId,
        //             'gia_tri_thuoc_tinh_bien_the_id' => $valueVariantId,
        //         ];
        //         ThuocTinhVaGiaTriBienThe::create($dataAtrributeValue);
        //      }
        //   }
     

        $variants = $request->input('variants');
        $valueNames = [];
        foreach ($request->input('value_names') as $key => $value) {
            $parts = explode('|', $value);
            $valueNames[$key] = $parts;
        }
        
        // Thêm sản phẩm
        if ($request->hasFile("image")) {
            $fileName = $request->file('image')->store('uploads/sanpham', "public");
        } else {
            $fileName = NULL;
        }
        $featured = $request->has("featured") ? 1 : 0;
        $data = [
            "ma_san_pham" => "SP-" . Str::random(6),
            "ten_san_pham" => $request->input('name'),
            "anh_san_pham" => $fileName,
            "mo_ta_ngan" => $request->input('short-description'),
            "mo_ta" => $request->input('description'),
            "danh_muc_id" => $request->input('category'),
            "noi_bat" => $featured,
            "kieu_san_pham" => $request->input('type')
        ];
        $product = SanPham::create($data);
        $productId = $product->id;
        
        // Tạo và lưu giá trị thuộc tính biến thể
        $valueVariants = [];
        foreach ($valueNames as $valueArray) {
            foreach ($valueArray as $value) {
                if (!isset($valueVariants[$value])) {
                    $dataValue = [
                        'ma_gia_tri_thuoc_tinh_bt' => "GTTT-" . Str::random(5),
                        'ten_gia_tri_thuoc_tinh_bt' => $value,
                    ];
                    $valueVariant = GiaTriThuocTinhBienThe::create($dataValue);
                    $valueVariants[$value] = $valueVariant->id;
                }
            }
        }
        
        // Lưu các thuộc tính biến thể đã tạo ra để đảm bảo tính duy nhất
        $attributeVariants = [];
        $attributeIndexMap = [];
        
        // Thêm biến thể sản phẩm
        foreach ($variants as $index => $variant) {
            $fileNameVariant = NULL;
            if ($request->hasFile('image-variant')) {
                if (isset($request->file('image-variant')[$index])) {
                    $fileNameVariant = $request->file('image-variant')[$index]->store('uploads/bienthesanpham/id_'.$productId, "public");
                }
            }
        
            $dataVariant = [
                'ma_bien_the_san_pham' => "BTSP-" . Str::random(5),
                'anh_bien_the_san_pham' => $fileNameVariant,
                'san_pham_id' => $productId,
                'gia' => $request->input('price-variant')[$index],
                'so_luong' => $request->input('quantity-variant')[$index],
            ];
            $productVariant = BienTheSanPham::create($dataVariant);
            $productVariantId = $productVariant->id;
        
            // Thêm thuộc tính biến thể và liên kết với giá trị
            $valueParts = explode(' ', $variant);
            foreach ($request->input('atrribute_name') as $attrIndex => $attrName) {
                // Kiểm tra và chỉ tạo một lần nếu thuộc tính biến thể chưa tồn tại
                if (!isset($attributeVariants[$attrName])) {
                    $dataAtrribute = [
                        'ma_thuoc_tinh_bien_the' => "TTBT-" . Str::random(5),
                        'ten_thuoc_tinh_bien_the' => $attrName,
                        'bien_the_san_pham_id' => $productVariantId,
                    ];
                    $atrributeVariant = ThuocTinhBienThe::create($dataAtrribute);
                    $attributeVariants[$attrName] = $atrributeVariant->id;
                } else {
                    $dataAtrribute = [
                        'ma_thuoc_tinh_bien_the' => "TTBT-" . Str::random(5),
                        'ten_thuoc_tinh_bien_the' => $attrName,
                        'bien_the_san_pham_id' => $productVariantId,
                    ];
                    $atrributeVariant = ThuocTinhBienThe::create($dataAtrribute);
                }
        
                $atrributeVariantId = $atrributeVariant->id;
        
                // Tìm giá trị thuộc tính tương ứng với tên thuộc tính
                $value = isset($valueParts[$attrIndex]) ? $valueParts[$attrIndex] : null;
        
                if ($value && isset($valueVariants[$value])) {
                    $dataAtrributeValue = [
                        'ma_thuoc_tinh_va_gia_tri' => "TTGT-" . Str::random(5),
                        'thuoc_tinh_bien_the_id' => $atrributeVariantId,
                        'gia_tri_thuoc_tinh_bien_the_id' => $valueVariants[$value],
                    ];
                    ThuocTinhVaGiaTriBienThe::create($dataAtrributeValue);
                }
            }
        }
        if($request->hasFile("album_anhs")){
            foreach($request->file("album_anhs") as $file){
                   if($file){
                    $fileName = $file->store('uploads/hinhanhsanpham/id_'. $productId, "public");
                    AlbumAnh::create([
                        'ma_album_anh' => "ABLA-".Str::random(5),
                        'duong_dan_anh' => $fileName,
                        'san_pham_id' => $productId
                    ]);
                   }
            }
           
        }
          $success = true;
       }
       if($success){
        return redirect()->route('sanpham.index')->with('success', 'Thêm mới sản phẩm thành công');
       }
       }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sanPhamCheck = SanPham::find($id);
        if($sanPhamCheck){
            $sanPham = SanPham::select('san_phams.*', 'danh_mucs.id as id_danh_muc', 'danh_mucs.ten_danh_muc')
             ->join('danh_mucs', 'danh_mucs.id', '=', 'san_phams.danh_muc_id')
             ->where('san_phams.id', $id)->get();
            $albumAnh = SanPham::select('album_anhs.*')
             ->join('album_anhs', 'san_phams.id', '=', 'album_anhs.san_pham_id')
             ->where('san_phams.id', $id)->get();
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
        $countBienThe = count($sanPhamShow);
        $totalQuantity = $sanPhamShow->sum('so_luong');
        $giaMin = $sanPhamShow->min('gia');
        $giaMax = $sanPhamShow->max('gia');
        $sanPhamThongKe = SanPham::select(
            'chi_tiet_don_hangs.*'
        )
        ->leftJoin('bien_the_san_phams', 'san_phams.id', '=', 'bien_the_san_phams.san_pham_id')
        ->leftJoin('chi_tiet_don_hangs', function($join) {
            $join->on('chi_tiet_don_hangs.san_pham_id', '=', 'san_phams.id')
                 ->orOn('chi_tiet_don_hangs.bien_the_san_pham_id', '=', 'bien_the_san_phams.id');
        })
        ->where('san_phams.id', $id)
        ->get();
        $daBan = $sanPhamThongKe->sum('so_luong');
        $doanhThu = $sanPhamThongKe->sum('thanh_tien');
        $listBinhLuan = BinhLuan::select('binh_luans.ma_binh_luan', 'binh_luans.noi_dung', 'binh_luans.thoi_gian',
        'users.id as id_user', 'users.name', 'users.anh_dai_dien')
        ->join('users', 'users.id', '=', 'binh_luans.user_id')
        ->join('san_phams', 'binh_luans.san_pham_id', '=', 'san_phams.id')
        ->orderByDesc('thoi_gian')->where('san_phams.id', $id)->get();
        $listDanhGia = DanhGia::select('danh_gias.sao', 'danh_gias.noi_dung', 'danh_gias.ngay_danh_gia',
        'users.name', 'users.id as id_user', 'users.anh_dai_dien')
        ->join('users', 'danh_gias.user_id', '=', 'users.id')
        ->join('san_phams', 'danh_gias.san_pham_id', '=', 'san_phams.id')
        ->where('san_phams.id', $id)
        ->get();
        $trungBinhSao = $listDanhGia->avg('sao');
        $khachHangVip = SanPham::select('users.id','users.name', 'users.anh_dai_dien', DB::raw('SUM(chi_tiet_don_hangs.so_luong) as sum_so_luong'))
         ->leftJoin('bien_the_san_phams', 'bien_the_san_phams.san_pham_id', '=', 'san_phams.id')
         ->leftJoin('chi_tiet_don_hangs', function($join) {
            $join->on('chi_tiet_don_hangs.san_pham_id', '=', 'san_phams.id')
                 ->orOn('chi_tiet_don_hangs.bien_the_san_pham_id', '=', 'bien_the_san_phams.id');
        })
        ->leftJoin('don_hangs', 'don_hangs.id', '=', 'chi_tiet_don_hangs.don_hang_id')
        ->leftJoin('users', 'users.id', '=', 'don_hangs.user_id')
        ->where('san_phams.id', $id)
        ->whereNotNull('users.id')  // Loại bỏ các khách hàng có users.id là null
        ->groupBy('users.id', 'users.name', 'users.anh_dai_dien')
        ->orderBy('sum_so_luong', 'DESC')
        ->get()
        ->first();
        $template = 'admins.sanphams.show';
        return view('admins.layout', [
            'title' => 'Chi Tiết Sản Phẩm',
            'template' => $template,
            'active' => $this->active,
            'sanPhamShow' => $sanPhamShow,
            'sanPham' => $sanPham,
            'countBienThe' => $countBienThe,
            'totalQuantity' => $totalQuantity,
            'daBan' => $daBan,
            'doanhThu' => $doanhThu,
            'listBinhLuan' => $listBinhLuan,
            'listDanhGia' => $listDanhGia,
            'khachHangVip' => $khachHangVip,
            'albumAnh' => $albumAnh,
            'giaMin' => $giaMin,
            'giaMax' => $giaMax,
            'trungBinhSao' => $trungBinhSao
        ]);
    }else{
        return redirect()->route('sanpham.index')->with('error', 'Không có sản phẩm này');
    }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {   
        $listDanhMuc = DanhMuc::where("danh_muc_cha_id", NULL)->with(['children' => function ($query) {
            $query->orderBy('id', 'DESC'); // Sắp xếp theo tên danh mục giảm dần
        }])->orderByDesc('id')->get();
        $sanPhamDetail = SanPham::find($id);
        $listAlbumAnh = AlbumAnh::select('album_anhs.*')->where('album_anhs.san_pham_id', $id)->get();
        if(!$sanPhamDetail){
            return redirect()->route("sanpham.index")->with("error", "Sản phẩm này không tồn tại");
        }
        else{
        $template = 'admins.sanphams.update';
        return view('admins.layout', ['title' => 'Sửa Sản Phẩm', 'template' => $template, 'active' => $this->active, 'sanPhamDetail' => $sanPhamDetail, 'listDanhMuc' => $listDanhMuc, 'listAlbumAnh' => $listAlbumAnh]);
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormUpdateRequest $request, string $id)
    {
        if($request->isMethod('PUT')){
            $sanPhamUpdate = SanPham::find($id);
            if($sanPhamUpdate){
              $sanPhamId = $sanPhamUpdate->id;
                // Nếu có ảnh thì xóa đi
             if ($request->hasFile('image')) {
                if($sanPhamUpdate->anh_san_pham && Storage::disk('public')->exists($sanPhamUpdate->anh_san_pham)){
                   Storage::disk('public')->delete($sanPhamUpdate->anh_san_pham);
                }
                   //Lưu ảnh mới
                   $fileName = $request->file('image')->store("uploads/sanpham", "public");
             }else{
               $fileName = $sanPhamUpdate->anh_san_pham;
             }
            $featured = $request->has("featured") ? 1 : 0;
            $sanPhamUpdate->ten_san_pham = $request->input('name');
            $sanPhamUpdate->anh_san_pham = $fileName;
            $sanPhamUpdate->gia = $request->input('price');
            $sanPhamUpdate->gia_khuyen_mai = $request->input('promotion_price');
            $sanPhamUpdate->ngay_ket_thuc_km = $request->input('promotion_end_date');
            $sanPhamUpdate->so_luong = $request->input('quantity');
            $sanPhamUpdate->mo_ta_ngan = $request->input('short-description');
            $sanPhamUpdate->mo_ta = $request->input('description');
            $sanPhamUpdate->danh_muc_id = $request->input('category');
            $sanPhamUpdate->noi_bat = $featured;
            $sanPhamUpdate->save();
              
             // Xóa các hình ảnh đã chọn
           if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = AlbumAnh::findOrFail($imageId);
                if($image->duong_dan_anh && Storage::disk('public')->exists($image->duong_dan_anh)){
                Storage::disk('public')->delete($image->duong_dan_anh);
                }
                $image->forceDelete();
            }
        }
           
        // Thêm các hình ảnh mới
        if ($request->hasFile('album_anhs')) {
            foreach ($request->file('album_anhs') as $file) {
                $fileName = $file->store('uploads/hinhanhsanpham/id_'. $sanPhamId, "public");
                AlbumAnh::create([
                    'ma_album_anh' => "ABLA-".Str::random(5),
                    'duong_dan_anh' => $fileName,
                    'san_pham_id' => $sanPhamId,
                ]);
            }
        }
            return redirect()->route("sanpham.index")->with("success", "Cập nhật sản phẩm thành công");
        }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // xóa cứng
        // $sanPhamTrash = SanPham::find($id);
        // if($sanPhamTrash->anh_san_pham && Storage::disk('public')->exists($sanPhamTrash->anh_san_pham)){
        //     Storage::disk('public')->delete($sanPhamTrash->anh_san_pham);
        // }
        // return redirect()->route('sanpham.index')->with('success', 'Xóa sản phẩm thành công');

        // xóa mềm
        $sanPhamTrash = SanPham::find($id);
        if($sanPhamTrash){
            $sanPhamTrash->delete();
            return redirect()->route("sanpham.index")->with("success", "Chuyển vào thùng rác thành công");
        }
    }
}