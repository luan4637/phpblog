<?php
namespace App\Core\Category;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $table = 'Category';

    protected $fillable = [
        'name', 'slug', 'description', 'image', 'showInNav'
    ];
}