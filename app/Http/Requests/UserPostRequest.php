<?php

namespace App\Http\Requests;

use App\Rules\CodiceFiscale;
use App\Rules\PhoneNumber;
use App\Rules\Size;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserPostRequest extends FormRequest
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
            'firstname' => 'required',
            'lastname' => 'required',
            'birthdate' => 'required|date',
             'cf' => ['required', new CodiceFiscale],
            'gender' => ['required',Rule::in(['male', 'female']),],
             'height' => 'required|numeric',
             'weight' => 'required|numeric',
             'phone' => ['required', new PhoneNumber],
             'equipments.*.equipment' => 'required|exists:equipment,name',
             'equipments.*.size' => ['required', new Size],

        ];
    }
}
