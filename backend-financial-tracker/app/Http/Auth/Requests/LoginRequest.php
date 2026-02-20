<?php

namespace App\Http\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
    ];
  }
  public function messages(): array
  {
    return [
      'name.required'   => 'El campo name es obligatorio.',
      'name.string'   => 'El campo name debe ser una cadena de texto.',
      'password.required'    => 'El campo password es obligatorio.',
      'password.string'    => 'El campo password debe ser una cadena de texto.',    
    ];
  }

  protected function prepareForValidation(): void
  {
    $this->merge([
      'name' => $this->normalizeString($this->input('name')),
    ]);
  }

  private function normalizeString($value)
  {
    return is_string($value) ? strtolower($value) : $value;
  }
}
