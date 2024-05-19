<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'coins',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function section(){
        return $this->belongsTo(Section::class);
    }

    public function attempts() {
        return $this->belongsToMany(ActivityUser::class, 'activity_users', 'activity_id', 'user_id')
            ->withTimestamps()
            ->withPivot(['attempts','score', 'file']);
    }

    public function modules(){
        return $this->belongsToMany(Module::class, 'module_users');
    }

    public function lectures(){
        return $this->belongsToMany(Lecture::class, 'lecture_users');
    }
    public function activities(){
        return $this->belongsToMany(Activity::class, 'activity_users')->withPivot(['coins_awarded' , 'file']);
    }

    public function locked() {
        return $this->belongsToMany(Lecture::class, 'lecture_users');
    }


    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(['admin', 'instructor']);
    }


}
