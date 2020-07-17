<?php


namespace App\Http\Controllers;

use App\Jobs\NotifyEmailAdmin;
use App\Models\Posts\Post;
use App\Services\Post\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


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
            $job = new NotifyEmailAdmin('У вас новый пост!', 'ml.dmitriymelnik@yandex.ru');
            $this->dispatch($job);
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
        $postQuery = Post::where('id', $request->id);
        $post = $postQuery->first();
        $sudo = $user->sudo;

        $diffTime = $this->diffTime($post);

        if (($user->id === $post->user_id && $diffTime <= 2) || $sudo) {
            $postQuery->delete();
            return $this->responseAPI('Комментарий удален', false);
        }
            return $this->responseAPI('Вы не можете удалить комментарий по истечении 2 часов', true);


    }

    public function editPost(Request $request){
        $user = Auth::user();
        $postQuery = Post::where('id', $request->id);
        $post = $postQuery->first();
        $sudo = $user->sudo;

        $diffTime = $this->diffTime($post);

        if (($user->id === $post->user_id && $diffTime <= 2) || $sudo) {
            $post->update(['message' => $request->message]);
            return $this->responseAPI('Комментарий редактирован', false);
        }
            return $this->responseAPI('Вы не можете редактировать комментарий по истечении 2 часов', true);


    }

    public function diffTime($post){
        $now = Carbon::now();
        $timeCreationPost = $post->created_at;
        return Carbon::parse($timeCreationPost)->floatDiffInHours($now);
    }

}
