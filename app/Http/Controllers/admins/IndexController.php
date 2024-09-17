<?php

namespace App\Http\Controllers\Admins;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    protected $active = "Trang Chủ";
    public function index(){
        $template = 'admins.components.index';
        return view('admins.layout', ['title' => 'Admin', 'template' => $template, 'active' => $this->active]);
    }
}