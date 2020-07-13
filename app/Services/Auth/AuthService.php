<?php


namespace App\Services\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;

    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        $first_input = $request->post('email');
        $password = $request->post('password');

        $attempt = Auth::attempt(['email' => $first_input, 'password' => $password]);
        if ($attempt) {
            //Возвращаем авторизованного пользователя если авторизация прошла успешна
            return Auth::user();
        }
        return false;


    }
}
