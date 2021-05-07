<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request)
    {
        return ['id' => $this->id, 'title' => $this->title, 'body' => $this->body, 'published_at' => $this->published_at, 'updated_at' => $this->updated_at, 'created_at' => $this->created_at];
    }
}