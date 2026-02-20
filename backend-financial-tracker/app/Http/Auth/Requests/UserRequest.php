<?php

namespace App\Http\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'name'    => 'required|string|max:40',
      'password'     => 'required|string',
      // 'role_id' => 'required|integer',
      // 'nombre'    => 'required|string', //poner todo esto es su respectivo validation
      // 'primer_apellido'   => 'required|string',
      'email'            => 'required|email'
    ];
  }
  public function messages(): array
  {
    return [
      'name.required'   => 'El campo name es obligatorio.',
      'name.string'   => 'El campo name debe ser una cadena de texto.',
      'name.max'   => 'El campo name no debe exceder los 40 caracteres.',
      'password.required'    => 'El campo password es obligatorio.',
      'password.string'    => 'El campo password debe ser una cadena de texto.',
      // 'role_id.required'   => 'El campo role_id es obligatorio.',
      // 'nombre.required'   => 'El campo nombre es obligatorio.',            
      // 'primer_apellido.required'  => 'El campo primer_apellido es obligatorio.',            
      'email.required'   => 'El campo email es obligatorio.',
      // 'email.email'      => 'El correo no es valido.',            
    ];
  }

  protected function prepareForValidation(): void
  {
    $this->merge([
      'name' => $this->normalizeString($this->input('name')),
      'email' => $this->normalizeString($this->input('email')),
    ]);
  }

  private function normalizeString($value)
  {
    return is_string($value) ? strtolower($value) : $value;
  }
}
