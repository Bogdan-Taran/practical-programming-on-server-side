<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class UsersRoles extends Model
{
    protected $table = 'users_roles';
    protected $primaryKey = 'user_role_id';
    public $timestamps = false;
}