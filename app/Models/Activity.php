<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function lecture(){
        return $this->belongsTo(Lecture::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function attempts() {
        return $this->belongsToMany(ActivityUser::class, 'activity_users')->withPivot(['file', 'score' , 'attempts']);
    }

    public function count_attempts($user_id){

        return ActivityUser::where('activity_id', $this->id)
            ->where('user_id', $user_id)
            ->count();
    }

    public function score($user_id){
        return ActivityUser::where('activity_id', $this->id)
            ->where('user_id', $user_id)
            ->latest('created_at')
            ->value('score');
    }
    public function maxScore($user_id){
        return ActivityUser::where('activity_id', $this->id)
            ->where('user_id', $user_id)
            ->latest('created_at')
            ->value('maxScore');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'activity_users');
    }

}
