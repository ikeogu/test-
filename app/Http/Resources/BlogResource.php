<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => strval($this->id),
            'type'=> 'blog_post',
             'attributes' => [
                'title' => $this->title,
                'body' => $this->body,
                'author'=> $this->author
             ],
             'relationships' => [
                'category' => [
                    'id' => strval($this->category->id),
                     'titile' => $this->category->title
                ]
             ]
        ];
    }
}