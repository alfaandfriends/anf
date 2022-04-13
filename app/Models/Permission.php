<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    public function role_has_permissions()
    {
        return $this->hasMany(RoleHasPermissions::class);
    }
}
