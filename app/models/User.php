<?php

use Illuminate\Support\Facades\Hash;
use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;

class User extends Eloquent implements ConfideUserInterface
{
    use ConfideUser;

    protected $fillable = [
        'organization_id',
        'username',
        'password',
        'email',
        'confirmation_code',
        'remember_token',
        'confirmed',
    ];

    public function tarefas()
    {
        return $this->hasMany('tarefas', 'owner_id');
    }

    public function reports()
    {
        return $this->hasMany('Report', 'user_id');
    }

    public function settings()
    {
        return $this->hasMany('Setting');
    }

    // public static function boot()
    //    {
    //        parent::boot();
    //        static::saving(function($model) {
    //            if ($model->isDirty('password')) {
    //                $model->password = Hash::make($model->password);
    //            }
    //        });
    //    }

    public function organization()
    {
        return $this->belongsTo('Organization');
    }

    public function organizations()
    {
        return $this->belongsToMany('Organization')->withTimestamps();
    }

    public function isMemberOf($org)
    {
        return $this->organizations->contains($org->id);
    }

    public function isAdmin()
    {
        return $this->admin;
    }

    public function delete()
    {
        // $user->organizations()->detach();
        parent::delete();
    }

    public function __toString()
    {
        return $this->username;
    }

    public function save(array $options = [])
    {
        if (array_key_exists('password_confirmation', $this->attributes)) {
            unset($this->attributes['password_confirmation']);
        }

        if (property_exists($this, 'password_confirmation')) {
            unset($this->password_confirmation);
        }

        if (array_key_exists('password', $this->attributes)) {
            $info = password_get_info($this->attributes['password']);

            if ($this->attributes['password'] !== null && $this->attributes['password'] !== '' && $info['algo'] === 0) {
                $this->attributes['password'] = Hash::make($this->attributes['password']);
            }
        }

        return parent::save($options);
    }
}
