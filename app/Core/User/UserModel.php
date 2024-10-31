<?php
  
namespace App\Core\User;

use App\Core\Post\PostModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
  
class UserModel extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'users';
  
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
    ];
  
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
  
    /**
     * @return array
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(PostModel::class, 'userId');
    }

    /** 
     * @param string $value
     */
    public function setPassword(string $value)
    {
        $this->password = $value;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
