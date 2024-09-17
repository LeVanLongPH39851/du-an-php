<?php

use App\Http\Controllers\admins\BaiVietController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\IndexController;
use App\Http\Controllers\Admins\LoginController;
use App\Http\Controllers\admins\DanhMucController;
use App\Http\Controllers\admins\DonHangController;
use App\Http\Controllers\Admins\SanPhamController;
use App\Http\Controllers\Admins\KhachHangController;
use App\Http\Controllers\Admins\TrangThaiDonHangController;
use App\Http\Controllers\admins\HinhThucThanhToanController;
use App\Http\Controllers\admins\SlideShowController;
use App\Http\Controllers\admins\trashs\DanhMucTrashController;
use App\Http\Controllers\admins\trashs\SanPhamTrashController;
use App\Http\Controllers\admins\trashs\TrangThaiDonHangTrashController;
use App\Http\Controllers\admins\trashs\HinhThucThanhToanTrashController;
use App\Http\Controllers\admins\trashs\KhachHangTrashController;
use App\Http\Controllers\clients\ClientController;
use App\Http\Controllers\clients\TaiKhoanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Mỗi một route có thể trực tiếp dẫn đến 1 view hoặc 1 hàm controller

// Route dẫn đến View
// Route::get('/xin-chao', function () {
//     return view('xinchao');
// }); //Cách 1
// Route::view('/xin-chao', 'xinchao'); //Cách 2

//Truyền dữ liệu qua view
// Route::get('/xin-chao', function () {
//     $title = "Welcome";
//     $text = "Xin chào nhé!";
//     return view('xinchao', ['title' => $title,'text' => $text]);
// }); //Cách 1
Route::view('/xin-chao', 'xinchao', ['title'=> 'Welcome', 'text'=> 'Xin chào nhé!']); //Cách 2

//Route dẫn đến 1 hàm của Controller
Route::get('/admin/login',[LoginController::class, 'index'])->name('login')->middleware('auth.login');
Route::post('/admin/store',[LoginController::class, 'store'])->name('store');
Route::get('/admin/logout',[LoginController::class, 'logout'])->name('logout');
Route::middleware(['login'])->group(function(){
Route::prefix('/admin')->group(function(){
    Route::get("/index", [IndexController::class, 'index'])->name('admin');
    Route::resource('/danhmuc', DanhMucController::class);
    Route::resource('/sanpham', SanPhamController::class);
    Route::resource('/khachhang', KhachHangController::class);
    Route::resource('/trangthaidonhang', TrangThaiDonHangController::class);
    Route::resource('/hinhthucthanhtoan', HinhThucThanhToanController::class);
    Route::resource('/donhang', DonHangController::class);
    Route::resource('/hinhthucthanhtoantrash', HinhThucThanhToanTrashController::class);
    Route::resource('/trangthaidonhangtrash', TrangThaiDonHangTrashController::class);
    Route::resource('/sanphamtrash', SanPhamTrashController::class);
    Route::resource('/khachhangtrash', KhachHangTrashController::class);
    Route::resource('/danhmuctrash', DanhMucTrashController::class);
    Route::resource('/slideshow', SlideShowController::class);
    Route::resource('/baiviet', BaiVietController::class);
    //Route resource
    // Route::get("/sanpham/test", [SanPhamController::class, 'test'])->name('admin.sanpham.test');
    //Thêm route ngoài cần viết lên trên
});
});
// Route clients 
Route::get('/',[ClientController::class, 'index'])->name('client.index');
Route::get('/ve-chung-toi',[ClientController::class, 'about'])->name('client.about');
Route::get('/lien-he',[ClientController::class, 'contact'])->name('client.contact');
Route::get('/bai-viet',[ClientController::class, 'blog'])->name('client.blog');
Route::get('/chi-tiet-bai-viet/{id}',[ClientController::class, 'blogDetail'])->name('client.blog.detail');
Route::get('/chi-tiet-san-pham/{id}',[ClientController::class, 'show'])->name('client.show');
Route::get('/cua-hang',[ClientController::class, 'shop'])->name('client.shop');
Route::get('/form-dang-nhap',[ClientController::class, 'login'])->name('client.form.login');
Route::get('/form-dang-ky',[ClientController::class, 'signin'])->name('client.form.signin');
Route::post('/dang-ky',[ClientController::class, 'storeSignin'])->name('client.signin');
Route::post('/dang-nhap',[ClientController::class, 'store'])->name('client.login');
Route::post('/binh-luan/{id}',[ClientController::class, 'comment'])->name('client.comment');
Route::get('/logout',[ClientController::class, 'logout'])->name('client.logout');
Route::post('/danh-gia/{id}',[ClientController::class, 'review'])->name('client.review');
Route::middleware(['user.login'])->group(function(){
Route::prefix('/tai-khoan')->group(function(){
Route::get("/chi-tiet-don-hang/{id}", [TaiKhoanController::class, 'orderDetail'])->name('client.order.detail');
Route::post("/huy-don-hang/{id}", [TaiKhoanController::class, 'cancelOrder'])->name('client.cancel.order');
Route::post("/add-to-cart/{id}", [ClientController::class, 'addtocart'])->name('client.addtocart');
Route::get("/cart", [ClientController::class, 'cart'])->name('client.cart');
Route::get("/remove-cart/{id}", [ClientController::class, 'removeCart'])->name('client.remove.cart');
Route::post("/update-cart", [ClientController::class, 'updateCart'])->name('client.update.cart');
Route::get("/checkout", [ClientController::class, 'checkout'])->name('client.checkout');
Route::post("/checkout-post", [ClientController::class, 'checkoutPost'])->name('client.checkout.post');
Route::get("/info-user", [TaiKhoanController::class, 'infoUser'])->name('client.info.user');
Route::post("/update-user", [TaiKhoanController::class, 'updateUser'])->name('client.update.user');
Route::post("/update-address", [TaiKhoanController::class, 'updateAddress'])->name('client.update.address');
Route::get("/san-pham-yeu-thich", [TaiKhoanController::class, 'wishlist'])->name('client.wishlist');
Route::get("/favorite/{id}", [TaiKhoanController::class, 'favoriteProduct'])->name('client.favorite');
Route::get("/delete-favorite/{id}", [TaiKhoanController::class, 'deleteFavoriteProduct'])->name('client.delete.favorite');
});
});