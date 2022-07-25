<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    // 6-5 add関数を追加
    public function add()
    {
        return view('admin.news.create');
    }
}
