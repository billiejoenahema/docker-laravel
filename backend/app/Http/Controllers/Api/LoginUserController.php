<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoginUserResource;
use Illuminate\Support\Facades\Auth;

class LoginUserController extends Controller
{
    /**
     * ログインユーザーの情報を返します。
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return new LoginUserResource(Auth::user());
    }
}
