<?php
namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Request;

class User extends Model implements IdentityInterface
{
    use HasFactory;

    public const ROLE_SUPERVISOR = 1;
    public const ROLE_RESEARCHER = 2;
    public const ROLE_ADMIN = 3;

    public $timestamps = false;
    protected $fillable = [
        'firstname',
        'lastname',
        'patronymic',
        'login',
        'password_hash',
        'role_id',
        'academic_degree_id'
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->password_hash = md5($user->password_hash);
        });
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'user_role_id');
    }

    public function findIdentity(int $id)
    {
        return self::where('user_id', $id)->first();
    }

    public function getId(): int
    {
        return $this->user_id;
    }

    public function attemptIdentity(array $credentials)
    {
        return self::where(['login' => $credentials['login'],
            'password_hash' => md5($credentials['password'])])->first();

    }

}
