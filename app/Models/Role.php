<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    public function user_has_role()
    {
        return $this->hasMany(UserHasRoles::class, 'role_id');
    }
}
