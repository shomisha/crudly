<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    public function rules()
    {
        $titleUniqueRule = Rule::unique('posts', 'title');
        $post = $this->route('post');
        if ($post) {
            $titleUniqueRule->ignore($post->id);
        }

        return ['title' => [$titleUniqueRule, 'required', 'string', 'max:255'], 'body' => ['required', 'string', 'max:65535'], 'published_at' => ['required', 'date_format:Y-m-d H:i:s']];
    }
}