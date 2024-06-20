<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostDeleteRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer',
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
