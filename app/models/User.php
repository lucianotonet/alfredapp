<?php 
use Zizaco\Confide\ConfideUser; 
use Zizaco\Confide\ConfideUserInterface; 

class User extends Eloquent implements ConfideUserInterface { 
	use ConfideUser; 


	protected $fillable = array(
							'organization_id',
	                       	'username',
	                       	'password',
	                       	'email',
	                       	'confirmation_code',
	                       	'remember_token',
	                       	'confirmed',	                       
	                    );


	public function tarefas(){
		return $this->hasMany('tarefas', 'owner_id');
	}

	public function reports(){
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
}