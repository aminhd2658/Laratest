<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class SingleController extends Controller
{
    public function index(Post $post)
    {
        $comments = $post->comments()->latest()->paginate(15);
        return view('single', compact('post', 'comments'));
    }

    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'text' => 'required'
        ]);

        $post->comments()->create([
            'user_id' => auth()->user()->id,
            'text' => $request->input('text')
        ]);

        return [
            'created' => true
        ];
    }
}
