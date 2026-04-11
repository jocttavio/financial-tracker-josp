<?php

namespace App\Http\Expense\Requests;


use Illuminate\Foundation\Http\FormRequest;

class SaveExpenseRequest extends FormRequest
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
            'id_product_service' => 'required',
            'id_category' => 'required',
            'description' => 'nullable|string',
            'payment_method' => 'required|string',

        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'El campo monto es obligatorio.',
            'amount.numeric' => 'El campo monto debe ser un número.',
            'date.required' => 'El campo fecha es obligatorio.',
            'date.date' => 'El campo fecha debe ser una fecha válida.',
            'id_product_service.required' => 'El campo servicio es obligatorio.',
            'id_category.required' => 'El campo categoría es obligatorio.',
            'description.string' => 'El campo descripción debe ser una cadena de texto.',
            'payment_method.required' => 'El campo método de pago es obligatorio.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'description' => $this->normalizeString($this->input('description')),
            'product_service_id' => $this->input('id_product_service'),
            'category_id' => $this->input('id_category'),
            'payment_method' => $this->input('payment_method'),
        ]);
    }

      private function normalizeString($value)
    {
        return is_string($value) ? strtolower($value) : $value;
    }

}