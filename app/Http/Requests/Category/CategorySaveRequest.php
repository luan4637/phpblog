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
            'slug' => 'string|max:255',
            'description' => 'nullable|string',
            'showInNav' => 'boolean'
        ];
    }

    /**
     * @return void
     */
    public function prepareForValidation()
    {
        $this->mergeIfMissing([
            'slug' => str_replace(' ', '-', $this->string('name'))
        ]);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->integer('id');
    }
}
