<?php

namespace App\Http\Requests;

use App\Rules\CodiceFiscale;
use App\Rules\PhoneNumber;
use App\Rules\Size;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RosterPostRequest extends FormRequest
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
            'type' => 'required',
            'date' => 'required|date',
            'diving_id' => 'required|exists:divings,id',
            'price' => 'numeric|nullable',
            'cost' => 'numeric|nullable',
            'gratuities' => 'numeric|nullable',
        ];
    }
}
