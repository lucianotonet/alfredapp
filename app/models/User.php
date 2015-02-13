<?php 
use Zizaco\Confide\ConfideUser; 
use Zizaco\Confide\ConfideUserInterface; 
 
class User extends Eloquent implements ConfideUserInterface { 
    use ConfideUser; 

    public function tarefas(){
      return $this->hasMany('tarefas', 'cliente_id');
    }

    public function reports(){
      return $this->hasMany('Report', 'user_id');
    }
}