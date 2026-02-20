<?php

namespace App\Http\Auth\UseCases;

use App\Models\Auth\User;
// use App\Models\Persona;
use App\Exceptions\CustomError;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
//se encarga de cachar los errores usando try catch ademas de 
//realizar las operaciones que se necesiten hacer ya sea
//guardar archivos y manipular los datos

class Token
{

  public static function create($data)
  {
    
    try {
      $token = JWTAuth::fromUser($data); // Crear un nuevo token 
      return $token;
      
    } catch (JWTException $e) {
       throw new CustomError( // manejar mejor los errores, poner por defecto la logica que se usa en whatsapp
        "Algo salió mal al crear el token",
        403,
        $e
      );
        } catch (\Throwable $th) {
       throw new CustomError( // manejar mejor los errores, poner por defecto la logica que se usa en whatsapp
        "Ocurrio un error al crear el token",
        401,
        $th
      );
        }catch (\Exception $e) {
      throw new CustomError( // manejar mejor los errores, poner por defecto la logica que se usa en whatsapp
        "Ocurrio un error al crear el token",
        404,
        $e
      );
    }
  }
}
