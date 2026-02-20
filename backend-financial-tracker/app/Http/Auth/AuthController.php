<?php

namespace App\Http\Auth;

use App\Exceptions\CustomError;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Cookie; // not needed when using Laravel cookie() helper
use App\Http\Auth\AuthValidations;
use App\Http\Auth\Requests\LoginRequest;
use App\Http\Auth\Requests\UserRequest;
use App\Http\Auth\UseCases\Access;
use App\Http\Auth\useCases\firstAuth;
use App\Http\Auth\useCases\LoginService;
use App\Http\Auth\UseCases\Token;
use App\Models\Auth\User;
use Illuminate\Auth\Events\Login as LoginEvent;
// esta capa se encarga de inicializar valores si es necesario y
// responder al cliente con un determinado mensaje

class AuthController extends Controller
{

  protected $authValidation;

  public function __construct(AuthValidations $authValidation)
  {
    $this->authValidation = $authValidation;
  }

  public function signIn(LoginRequest $request)
  {
    $data = (object) $request->validated();

   $user = $this->authValidation->signIn($data);
    
    $token = Token::create($user);

    // Decide secure / sameSite based on environment so browsers accept the cookie.
    // Modern browsers require SameSite=None to be paired with Secure=true (HTTPS).
    $isProduction = config('app.env') === 'production' || env('APP_ENV') === 'production';

    // Use Laravel cookie helper which handles cookie creation consistently.
    // minutes param expects integer number of minutes.
    $sameSite = $isProduction ? 'None' : 'Lax';
    $secure = $isProduction; // only secure in production (HTTPS)

    $cookie = cookie(
      'token',
      $token,
      480,
      '/',
      null,
      $secure,
      true,
      false,
      $sameSite
    );

    event(new LoginEvent('user logged in', $user, false));

    return response()
      ->json(["msg" => "Bienvenido", "data" => $user, "token" => $token, "status" => true])
      ->withCookie($cookie);
  }

  public function createUser(UserRequest $request)
  {
    $data = (object) $request->validated();

    $this->authValidation->isDuplicatedUser($data->name, $data->email);

    Access::create($data);

    return response()
      ->json(["msg" => "El acceso ha sido creado", "status" => true]);
  }

  //TODO: This functionality is not working, it needs to be fixed, the problem is that the token is not being sent in the request, so the validation is not working, we need to send the token in the request and then validate it, also we need to validate the password, if the password is correct then we can refresh the token, if not then we need to return an error message
  public function refreshTokenController(Request $request)
  {
    $account = $this->authValidation->refreshTokenValidation($request);

    return response()
      ->json(["msg" => "Autenticación correcta", "data" => $account, "status" => true]);
  }

  public function logoutController(Request $request)
  {
    $this->authValidation->logoutValidation($request);

    return response()
      ->json(["msg" => "Su sesión ha sido cerrada",  "status" => true])
      ->cookie(cookie()->forget('token'));
  }

  public function changePasswordController(Request $request)
  {
    $this->authValidation->changePasswordValidation($request);

    return response()
      ->json(["msg" => "La contraseña se ha actualizado", "status" => true]);
  }

  public function updateAccountController(Request $request)
  {
    $this->authValidation->updateAccountValidation($request);

    return response()
      ->json(["msg" => "Su información se ha actualizado", "status" => true]);
  }
}
