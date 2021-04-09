<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    protected $fillable = [
        'id', 'name', 'username', 'email', 'suspended', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('notSystemGenerated', function (Builder $builder) {
            $builder->where('id', '<>', 'system');
        });
    }

    public $incrementing = false;

    public function findForPassport($identifier) {

        $user = $this->where(function ($query) use ($identifier) {
                    $query->orWhere('email', $identifier)
                        ->orWhere('username', $identifier);
                    })
                    ->first();

        if ($user) {
            if ($user->suspended) {
                abort(412, 'precondition_failed_suspended');
            } else {
                return $user;
            }
        }

        // return $user;
    }

    public function components()
    {
        return $this->belongsToMany('App\Component', 'user_components');
    }
}
