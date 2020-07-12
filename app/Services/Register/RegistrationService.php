<?php


namespace App\Services\Register;

use App\User;
use Auth;
use Exception;
use Illuminate\Http\Request;

class RegistrationService
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;

    }

    public function handlerRegister(Request $request)
    {
        //Валидируем запрос
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6'
        ]);
        $userFields = $request->all();
        //Создаем пользователя
        return User::create($userFields);

    }
}
