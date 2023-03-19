<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        Post::create($data);
    }
}
