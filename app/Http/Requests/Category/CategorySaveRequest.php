<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategorySaveRequest extends FormRequest
{
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'description' => 'string',
            'showInNav' => 'boolean'
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
