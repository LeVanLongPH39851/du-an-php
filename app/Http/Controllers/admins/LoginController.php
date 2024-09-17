<?php

namespace App\Http\Controllers\Admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FormLoginRequest;

class LoginController extends Controller
{
    public function index(){
        if(Auth::check() == true && Auth::user()->vai_tro == 2){
            return redirect()->route("admin"); //nếu id của Auth > 0 thì chuyển đến giao diện admin
        }
        return view('admins.components.login', ['title' => 'Login']);
    }
    public function store(FormLoginRequest $request){
        //Nó phải vượt qua validte thì mới check câu if dưới
        if(Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ])){ //Kiểm tra xem email và mật khẩu có đúng không, và check xem có ghi nhớ password không
            if (Auth::user()->vai_tro == 2) {
            //Đăng nhập thành công chuyển sang trang giao diện admin và tạo biến success = 'Logged in successfully'
                return redirect()->route('admin')->with('success', 'Đăng nhập thành công');
            }
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->back()->with("error", "Email hoặc mật khẩu không chính xác");
            //Đăng nhập không thành công trở lại chính trang đấy và tạo biến error = 'Email or password is incorrect'
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route("login");
        //Đăng xuất và chuyển đến form đăng nhập admin
    }
}