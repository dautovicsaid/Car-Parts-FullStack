<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable=['name'];

    const SUPER_ADMIN_ID=1;
    const ADMIN_ID=2;
    const USER_ID=3;

    public function users(){
        return $this->hasMany(User::class);
    }

}
