<?php
namespace App\Core\Post;

use App\Core\Category\CategoryModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostModel extends Model
{
    use SoftDeletes;

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    const DELETED_AT = 'deletedAt';

    protected $table = 'post';

    protected $fillable = [
        'title', 'slug', 'content', 'userId', 'published', 'position', 'picture'
    ];

    public function categories()
    {
        return $this->belongsToMany(
            CategoryModel::class, 
            'post_category',
            'postId',
            'categoryId'
        );
    }

    /** 
     * @param string $value
     */
    public function setTitle(string $value)
    {
        $this->title = $value;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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

    /** 
     * @param int $value
     */
    public function setUserId(int $value)
    {
        $this->userId = $value;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /** 
     * @param string $value
     */
    public function setPicture(string $value)
    {
        $this->picture = $value;
    }

    /**
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }
}