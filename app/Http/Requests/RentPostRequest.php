<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class RentPostRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'number' => 'numeric',
            'start_date' => 'required|date',
            'end_date' => 'date|nullable',
            'used_days' => 'numeric|nullable',
            'price' => 'numeric|nullable',
            'payment_1' => 'numeric|nullable',
            'payment_2' => 'numeric|nullable',
        ];
    }
}
