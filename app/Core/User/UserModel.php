<?php
  
namespace App\Core\User;

use App\Core\Post\PostModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'roles',
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
     * @return Attribute
     */
    protected function roles(): Attribute
    {
        return Attribute::make(
            set: function(array $values) {
                return json_encode($values);
            },
            get: function (string $value) {
                if (!$value) {
                    return [];
                }

                if ($arr = json_decode($value, true)) {
                    return $arr;
                }

                return [];
            }
        );
    }
  
    /**
     * @return array
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed'
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

    /**
     * @param array $values
     */
    public function setRoles(array $values)
    {
        $this->roles = $values;
    }

    /**
     * @return string
     */
    public function getRoles(): array
    {
        return $this->roles;
    }
}
