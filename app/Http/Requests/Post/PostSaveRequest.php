<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostSaveRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'content' => 'string',
            'published' => 'boolean',
            'position' => 'string|max:16',
            'picture' => 'string|max:255'
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->integer('id');
    }
}
