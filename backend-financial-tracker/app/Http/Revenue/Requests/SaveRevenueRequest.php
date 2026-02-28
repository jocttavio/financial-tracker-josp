<?php

namespace App\Http\Revenue\Requests;


use Illuminate\Foundation\Http\FormRequest;

class SaveRevenueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'id_account' => 'required',
            'id_category' => 'required',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'El campo monto es obligatorio.',
            'amount.numeric' => 'El campo monto debe ser un número.',
            'date.required' => 'El campo fecha es obligatorio.',
            'date.date' => 'El campo fecha debe ser una fecha válida.',
            'id_account.required' => 'El campo cuenta es obligatorio.',
            'id_category.required' => 'El campo categoría es obligatorio.',
            'description.string' => 'El campo descripción debe ser una cadena de texto.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'description' => $this->normalizeString($this->input('description')),
            'account_id' => $this->input('id_account'),
            'category_id' => $this->input('id_category'),
        ]);
    }

      private function normalizeString($value)
    {
        return is_string($value) ? strtolower($value) : $value;
    }

}