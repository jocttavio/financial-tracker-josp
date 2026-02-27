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
            'category_id' => 'required|exists:categories,id',
            'product_service_id' => 'required|exists:products_services,id',
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
            'category_id.required' => 'El campo categoría es obligatorio.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'product_service_id.required' => 'El campo producto/servicio es obligatorio.',
            'product_service_id.exists' => 'El producto/servicio seleccionado no existe.',
            'description.string' => 'El campo descripción debe ser una cadena de texto.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'description' => $this->normalizeString($this->input('description')),
        ]);
    }

      private function normalizeString($value)
    {
        return is_string($value) ? strtolower($value) : $value;
    }

}