<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarRequest extends FormRequest
{
    public function rules()
    {
        $manufacturerIdExistsRule = Rule::exists('manufacturers', 'id');

        return ['model' => ['required', 'string', 'max:255'], 'manufacturer_id' => [$manufacturerIdExistsRule, 'required', 'integer'], 'production_year' => ['nullable', 'integer'], 'first_registration_date' => ['nullable', 'date'], 'horse_power' => ['nullable', 'integer']];
    }
}