<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }

    public function users(){
        return $this->belongsToMany(User::class, 'module_users');
    }

    public function sections(){
        return $this->belongsToMany(Section::class, 'module_sections');
    }
}
