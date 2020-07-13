<?php


namespace App\Http\Controllers;

use App\Models\Posts\Post;
use App\Services\Post\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PostsController extends Controller
{

    public function index()
    {
        return view('templates.posts');
    }

    public function send(Request $request)
    {
        /** @var PostService $service */
        $service = app('Post');
        $created = $service->handlerPost($request);

        if ($created) {
            return $this->responseAPI('Комментарий создан');
        }
        return $this->responseAPI('Ошибка в создании комментария');


    }

    public function getPosts()
    {
        return Post::with('user')->get();
    }

    public function deletePost(Request $request){


        $user = Auth::user();
        $post = Post::where('id', $request->id)->delete();

        if ($user->id === $post->id) {
            return $post->delete();
        }

    }

}
