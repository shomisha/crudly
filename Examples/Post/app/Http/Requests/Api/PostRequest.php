<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function rules()
    {
        return ['title' => ['required', 'string', 'max:255'], 'body' => ['required', 'string', 'max:65535'], 'published_at' => ['required', 'date_format:Y-m-d H:i:s']];
    }
}