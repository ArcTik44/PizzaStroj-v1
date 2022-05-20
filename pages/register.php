<?php
require "../included/bootstrap.inc.php";
final class RegisterForm extends BaseDBPage{
    private Access $registerData;

    public function __construct()
    {
        parent::__construct();
        $this->title = "Registrace";
    }
    protected function body():string{
        $this->registerData = Access::readPost();
        $getInfo = $this->registerData->Register();
        if($getInfo){

        }
        return $this->m->render('registerForm',['registerData'=>$this->registerData]);
    }

}
(new RegisterForm())->render();