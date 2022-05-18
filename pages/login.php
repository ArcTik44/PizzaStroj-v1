<?php
require "../included/bootstrap.inc.php";
final class LoginForm extends BaseDBPage{
    private Access $loginData;

    public function __construct()
    {
        parent::__construct();
        $this->title = "Přihlášení";
    }
    protected function body():string{
        $this->loginData = Access::readPost();
        return $this->m->render('loginForm');
    }

}
(new LoginForm())->render();