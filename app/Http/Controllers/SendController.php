<?php


namespace App\Http\Controllers;


use App\Services\AddPost\AddPost;
use Illuminate\Http\Request;

class SendController
{
    public function send(Request $request){

        /** @var AddPost $service */
        $service = app('AddPost');

        $post = $service->handlerPost($request);

        dd($post);

    }
}
