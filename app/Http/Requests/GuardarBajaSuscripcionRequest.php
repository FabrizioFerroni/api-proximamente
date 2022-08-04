<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarBajaSuscripcionRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "nombre" => "min:5",
            "subscripcion_id" => "integer",
            "email" => "email",
            "fecha_baja" => "date",
            "eliminado" => "integer",
        ];
    }
}
