<?php
/**
 * Created by PhpStorm.
 * User: cjbm2994
 * Date: 13/03/2018
 * Time: 11:58 AM
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use function response;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(['posts' => Post::all()->toJson()]);
    }

    public function store(PostRequest $request)
    {
        $data = $request->all();
        Post::create($data);
        return response()->json(['status' => 'success']);
    }

    public function show(Post $post)
    {
        return response()->json(['post' => $post]);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->all());

        return response()->json(['status' => 'success']);
    }
}