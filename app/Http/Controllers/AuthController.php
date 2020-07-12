<?php


namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('templates.login');
    }
    public function auth(Request $request){
        $service = app('AuthService');
        $authenticate = $service->authenticate($request);

        if (!$authenticate instanceof User) {
            return $this->responseAPI('Ошибка аутентификации', true);
        }

        return $this->responseAPI('Вы успешно авторизировались', false, $authenticate->toArray());
    }
}
