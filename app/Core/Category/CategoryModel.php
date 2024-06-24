<?php
namespace App\Core\Category;

use App\Core\Post\PostModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryModel extends Model
{
    use HasFactory, SoftDeletes;

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    const DELETED_AT = 'deletedAt';

    protected $table = 'category';

    protected $fillable = [
        'name', 'slug', 'description', 'image', 'showInNav'
    ];

    public function posts()
    {
        return $this->belongsToMany(
            PostModel::class, 
            'post_category',
            'categoryId',
            'postId'
        );
    }

    /** 
     * @param string $value
     */
    public function setName(string $value)
    {
        $this->name = $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /** 
     * @param string $value
     */
    public function setSlug(string $value)
    {
        $this->slug = $value;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

}