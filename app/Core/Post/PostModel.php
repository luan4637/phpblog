<?php
namespace App\Core\Post;

use App\Core\Category\CategoryModel;
use App\Core\User\UserModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostModel extends Model
{
    use HasFactory, SoftDeletes;

    const ELASTIC_SEARCH_INDEX = 'postmodel';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    const DELETED_AT = 'deletedAt';

    protected $table = 'post';

    protected $fillable = [
        'title', 'slug', 'content', 'userId', 'published', 'position', 'picture'
    ];

    /**
     * @return array
     */
    protected function casts(): array
    {
        return [
            'published' => 'boolean',
        ];
    }

    public function categories()
    {
        return $this->belongsToMany(
            CategoryModel::class, 
            'post_category',
            'postId',
            'categoryId'
        );
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'userId');
    }

    /**
     * @return Attribute
     */
    // protected function slug(): Attribute
    // {
    //     return Attribute::make(
    //         set: function (string $value) {
    //             return str_replace(' ', '-', $this->title);
    //         },
    //     );
    // }

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
    public function getUserId(): int
    {
        return $this->userId;
    }

    /** 
     * @param void
     */
    public function setPicture(string $value)
    {
        $this->picture = $value;
    }

    /**
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * @return string
     */
    public function getSearchIndex(): string
    {
        return $this::ELASTIC_SEARCH_INDEX;
    }

    /**
     * @return int
     */
    public function getKey(): int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function toSearchArray(): array
    {
        return [
            'title' => $this->title,
            'content' => $this->content
        ];
    }
}