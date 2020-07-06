<?php


namespace App\Services\AddPost;


class AddPost
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;

    }
    public function handlerPost(Request $request)
    {
        dd($request);
        //Валидируем запрос
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|max:255',
            'message' => 'required|max:255'
        ]);


    }
}
