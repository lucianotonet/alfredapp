<?php
$canI = new CanI\CanI(Confide::user());
if (Auth::check()) {
    if (Confide::user()->isAdmin()) {
        $canI->allow('manage', 'Organization', function($org) {
            return $this->getUser()->isMemberOf($org);
        });
        $canI->allow('invite', 'User');
        $canI->allow('manage', 'User', function($user) {
            return $this->getUser()->organization_id === $user->organization_id;
        });
        $canI->allow('manage', 'Tarefas', function($todo) {
            $userIds = $this->getUser()->organization->users()->lists('id');
            return in_array($todo->user_id, $userIds);
        });
    } else {
        $canI->allow('manage', 'User', function($user) {
            return $this->getUser()->id === $user->id;
        });
        $canI->allow('manage', 'Tarefas', function($todo) {
            return $this->getUser()->id === $todo->user_id;
        });
    }
}
App::instance('canI', $canI);