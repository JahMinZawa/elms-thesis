<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'name',
    ];
    public function users(){
        return $this->hasMany(User::class);
    }

    public function modules(){
        return $this->belongsToMany(Module::class, 'module_sections');
    }

    public function lectures(){
        return $this->belongsToMany(Lecture::class, 'lecture_sections');
    }


}
