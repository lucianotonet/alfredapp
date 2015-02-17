<?php 
use Zizaco\Confide\ConfideUser; 
use Zizaco\Confide\ConfideUserInterface; 

class User extends Eloquent implements ConfideUserInterface { 
	use ConfideUser; 


	protected $fillable = array(
	                       'username',
	                       'password',
	                       'email',
	                       'confirmation_code',
	                       'remember_token',
	                       'confirmed',	                       
	                    );

	public function tarefas(){
		return $this->hasMany('tarefas', 'cliente_id');
	}

	public function reports(){
		return $this->hasMany('Report', 'user_id');
	}

	public function settings()
	{
		return $this->hasMany('Setting');
	}
}