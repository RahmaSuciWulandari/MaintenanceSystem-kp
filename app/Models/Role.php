<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
    ];

    /**
     * Get the users for the role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if role has specific permission level
     */
    public function hasPermission($permission)
    {
        $permissions = [
            'admin' => ['create', 'read', 'update', 'delete', 'manage_users', 'view_all_reports'],
            'manager_it' => ['create', 'read', 'update', 'delete', 'view_all_reports'],
            'pic_unit' => ['create', 'read', 'update', 'view_unit_reports'],
            'pelaksana' => ['read', 'update_status', 'view_assigned_tasks'],
        ];

        return in_array($permission, $permissions[$this->name] ?? []);
    }

    /**
     * Check if this is admin role
     */
    public function isAdmin()
    {
        return $this->name === 'admin';
    }

    /**
     * Check if this is manager role
     */
    public function isManager()
    {
        return $this->name === 'manager_it';
    }

    /**
     * Check if this is PIC role
     */
    public function isPIC()
    {
        return $this->name === 'pic_unit';
    }

    /**
     * Check if this is pelaksana role
     */
    public function isPelaksana()
    {
        return $this->name === 'pelaksana';
    }
}