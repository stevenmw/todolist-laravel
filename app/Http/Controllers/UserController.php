<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService) //dependencies injection
    {
        $this->userService = $userService;
    }

    public function login(): Response
    {
        return response()
            ->view("user.login", [
                "title" => "login"
            ]);
    }

    public function doLogin(Request $request): Response|RedirectResponse
    {
        $user = $request->input('user');
        $password = $request->input('password');

        //validate_input
        if(empty($user) || empty($password)) {
            return response()->view("user.login", [
                "title" => "login",
                "error" => "User or password is required"
            ]);
        }

        //if login success
        if ($this->userService->login($user, $password)) {
            $request->session()->put("user", $user);
            return redirect("/");
        }

        //if login failed
        return response()->view("user.login", [
            "title" => "login",
            "error" => "User or password is wrong"
        ]);
    }

    public function doLogout(Request $request): RedirectResponse
    {
        $request->session()->forget("user");
        return redirect("/");
    }
}
