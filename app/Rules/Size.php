<?php

namespace App\Rules;

use App\Models\Size as ModelsSize;
use Illuminate\Contracts\Validation\InvokableRule;

class Size implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (!is_numeric($value) && !ModelsSize::where('name',$value)->first()){
           $fail('invalid size');
        }
    }
}
