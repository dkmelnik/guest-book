<?php


namespace App\Http\Controllers;


use App\Services\Auth\AuthService;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('templates.login');
    }
    public function auth(Request $request){
        /** @var AuthService $service */
        $service = app('AuthService');
        $authenticate = $service->authenticate($request);
        //Добавляем урл переадресации к ответу сервера
        $addResponse = [
            'link' => route('index')
        ];

        if (!$authenticate instanceof User) {
            return $this->responseAPI('Ошибка аутентификации', true);
        }

        return $this->responseAPI('Авторизация успешна', false, array_merge($authenticate->toArray(), $addResponse));
    }
}
