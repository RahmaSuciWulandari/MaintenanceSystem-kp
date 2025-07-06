<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Role;


class User extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = [
        'email',
        'password',
        'permissions',
        'activated',
        'created_by',
        'activated_at',
        'last_login',
        'persist_code',
        'reset_password_code',
        'first_name',
        'last_name',
        'work_email',
        'country',
        'gravatar',
        'jobtitle',
        'manager_id',
        'employee_num',
        'username',
        'notes',
        'company_id',
        'remember_token',
        'ldap_import',
        'location_id',
        'avatar',
    ];

    protected $dates = [
        'deleted_at',
        'activated_at',
        'last_login',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}