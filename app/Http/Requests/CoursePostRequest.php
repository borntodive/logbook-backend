<?php

namespace App\Http\Requests;

use App\Rules\CodiceFiscale;
use App\Rules\PhoneNumber;
use App\Rules\Size;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CoursePostRequest extends FormRequest
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
            'certification_id' => 'required|exists:certifications,id',
            'number' => 'numeric',
            'start_date' => 'required|date',
            'end_date' => 'date|nullable',
            'users.*.name' => 'required|exists:users,id',
            'users.*.price' => 'numeric|nullable',
            'users.*.in_charge' => 'required|boolean',
            'users.*.teaching' => 'required|boolean',
        ];
    }
}
