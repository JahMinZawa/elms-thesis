<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleSection extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function section(){
        return $this->belongsTo(Section::class);
    }

    public function module(){
        return $this->belongsTo(module::class);
    }
}
