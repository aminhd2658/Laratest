<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(15);
        return view('home', compact('posts'));
    }

}
