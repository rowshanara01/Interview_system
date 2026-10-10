<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function posts()
    {
        $posts = Cache::remember('popular_posts', 600, function () {
            \Log::info('Database থেকে Post লোড হলো!');
            return Post::paginate(10000);
        });


        return view('post', compact('posts'));
    }
}
