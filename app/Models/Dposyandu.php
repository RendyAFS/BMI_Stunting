<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dposyandu extends Model
{
    use HasFactory;
    public function danaks()
    {
        return $this->hasMany(Danak::class);
    }
    public function dantrians()
    {
        return $this->hasMany(Dantrian::class);
    }

    public function dbulans()
    {
        return $this->hasMany(Dbulan::class);
    }

}
