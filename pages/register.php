<?php
final class RegisterForm extends BaseDBPage{
    private Access $registerData;

    public function __construct()
    {
        parent::__construct();
        $this->title = "Registrace";
    }
    protected function body():string{
        $this->loginData = Access::readPost();
        return $this->m->render('registerForm',['registerData'=>$this->loginData]);
    }

}
(new RegisterForm())->render();