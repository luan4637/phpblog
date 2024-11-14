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
            'slug' => 'string|max:255',
            'content' => 'nullable|string',
            'published' => 'boolean',
            'position' => 'string|max:16',
            'picture' => 'nullable|image'
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'published' => $this->toBoolean($this->published),
            'position' => $this->position === null ? '' : $this->position
        ]);

        $this->mergeIfMissing([
            'slug' => str_replace(' ', '-', $this->string('title'))
        ]);
    }

    /**
     * @param $booleable
     * @return boolean
     */
    private function toBoolean($booleable)
    {
        return filter_var($booleable, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->integer('id');
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        $categories = $this->input('categories');
        $categories = json_decode($categories, true);

        if (!$categories) {
            return [];
        }

        return array_column($categories, 'id');
    }
}
