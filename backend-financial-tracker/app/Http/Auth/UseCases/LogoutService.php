<?php

namespace App\Http\Auth\useCases;

use App\Exceptions\CustomError;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutService{

    public static function logout($data)
    {
        try {
            $token = $data->cookie('token');//token null si la cookie expiro

            if(!is_null($token)){
                JWTAuth::setToken($token)->invalidate(); // Invalida el token de la cookie    
            }
        } catch (\Exception $e) {
            throw new CustomError(
                "Ocurrio un error al cerrar sesión",
                404,
                $e
            );
        }
    }
}