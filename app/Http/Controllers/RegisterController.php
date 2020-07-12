<?php


namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use App\Services\Register\RegistrationService;

class RegisterController extends Controller
{
    public function index()
    {
        return view('templates.register');
    }

    public function register(Request $request)
    {
        /** @var RegistrationService $service */

        $service = app('Register');

        $user = $service->handlerRegister($request);


        if (!$user instanceof User) {
            return $this->responseAPI('Ошибка при создании пользователя', true);
        }

        return $this->responseAPI('Пользователь успешно создан', false, $user->toArray());
    }
}
