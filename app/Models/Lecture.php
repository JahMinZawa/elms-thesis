<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function activities(){
        return $this->hasMany(Activity::class);
    }

    public function users(){
        return $this->belongsToMany(User::class, 'lecture_users');
    }

    public function sections(){
        return $this->belongsToMany(Section::class, 'lecture_sections');
    }

}
