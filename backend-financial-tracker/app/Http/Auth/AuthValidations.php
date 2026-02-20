<?php

namespace App\Http\Auth;

use Illuminate\Support\Facades\Hash;
use App\Http\Auth\UseCases\LoginService;
use App\Http\Auth\UseCases\CreateAccess;
use App\Http\Auth\UseCases\LogoutService;
use App\Http\Auth\UseCases\ActiveAccess;
use App\Http\Auth\useCases\updateAccount;
use App\Http\Auth\useCases\updatePassword;
use App\Exceptions\CustomError;
use App\Models\Cuenta;
use App\Models\Auth\User;

//esta capa solo se encarga de validar el payload y los valores no requeridos
//se establecen como nullable
//cabe resaltar, si es necesario despues de la validacion del payload
//se puede ocupar esta capa para validar valores usando la bd

class AuthValidations
{

  public function signIn($data)
  {

    $access = User::where('name', $data->name)->first();

    if ($access == null) { // Valida la cuenta
      throw new CustomError(
        "La cuenta o constraseña son incorrectas.",
        401
      );
    }

    if (!Hash::check($data->password, $access->password)) { // Valida la contraseña
      throw new CustomError(
        "La cuenta o constraseña son incorrectas.",
        404
      );
    }

    return $access;
  }

  public function refreshTokenValidation($request)
  {
    $validatedData = $request->validate(
      [
        'password'         => 'required',
        'user_id'    => 'required',
      ],
      [
        'password.required'        => 'La contraseña es obligatoria.',
        'user_id.required'    => 'El campo user_id es obligatorio.',
      ]
    );
    $data = (object)$validatedData;

    $user = User::find($data->user_id);

     if (is_null($user)) { // Valida la cuenta
      throw new CustomError(
        "La cuenta no existe.",
        404
      );
    }

    if (!Hash::check($data->password, $user->password)) { // Valida la contraseña
        throw new CustomError(
        "La constraseña no es correcta.",
        404
      );
    }


    return $user->name;
  }

  public function isDuplicatedUser($name, $email = null)
  {
    $access = User::where('name', $name)
      ->orWhere('email', $email)
      ->first();
    if (!is_null($access)) {
      throw new CustomError(
        "Ya existe una cuenta con este nombre o correo establecido.",
        404
      );
    }
  }

  public function logoutValidation($request)
  {
    LogoutService::logout($request);
  }

  public function changePasswordValidation($request)
  {
    $validatedData = $request->validate(
      [
        'id_user'         => 'required|integer',
        'current_password'  => 'required|string',
        'new_password'      => 'required|string',
        'confirm_password'  => 'required|string',
      ],
      [
        'id_user.required'        => 'El campo id_user es obligatorio.',
        'current_password.required' => 'El campo current_password es obligatorio.',
        'new_password.required'     => 'El campo new_password es obligatorio.',
        'confirm_password.required' => 'El campo confirm_password es obligatorio.',
      ]
    );
    $data = (object)$validatedData;

    $user = User::find($data->id_user);

    if (!Hash::check($data->current_password, $user->password)) { // Valida la contraseña
       throw new CustomError(
        "La constraseña actual no es correcta.",
        404
      );
    }

    updatePassword::update($data);
  }

  public function updateAccountValidation($request)
  {
    $validatedData = $request->validate(
      [
        'id_user'         => 'required|integer',
        'email'            => 'required|email',
        'name'          => 'required|string',
      ],
      [
        'id_user.required'        => 'El campo id_user es obligatorio.',
        'email.required'   => 'El campo email es obligatorio.',
        'email.email'   => 'El campo email debe ser un correo válido.',
        'name.required'   => 'El campo name es obligatorio.',
      ]
    );
    $data = (object)$validatedData;

    updateAccount::update($data);
  }
}
