<?php


namespace App\Http\Controllers;


class AuthController extends Controller
{
    public function index()
    {
        return view('templates.login');
    }

    public function register(Request $request)
    {
        /** @var AuthService $service */
        $service = app('AuthService');

        $user = $service->handlerRegister($request);

        if (!$user instanceof User) {
            return $this->responseAPI('Ошибка при создании пользователя', true);
        }

        return $this->responseAPI('Пользователь успешно создан', false, $user->toArray());
    }
}
