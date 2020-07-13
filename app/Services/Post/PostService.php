<?php


namespace App\Services\Post;


use App\Models\Posts\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class PostService
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;

    }

    public function handlerPost(Request $request)
    {

        //Валидируем запрос
        $request->validate([
            'message' => 'required|max:255'
        ]);

        if (Auth::check())
        {
            $id = Auth::user()->id;
            $Post = Post::create(array_merge(["user_id" => $id], $request->all()));
        }
        else{
            $Post = Post::create($request->all());
        }


        if (!$Post instanceof Post) {
            return false;
        }
        return true;
    }



}
