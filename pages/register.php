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
        if($this->registerData->password==$this->registerData->verifyPassword)
        {
            $isOk = $this->registerData->ValidateRegister();
            if($isOk){
            $this->registerData->password = password_hash($this->registerData->password,PASSWORD_DEFAULT);
            $getInfo = $this->registerData->Register();
            if($getInfo){
            header('location:login.php',false);
            exit;
            }
            }

        }
        
        return $this->m->render('registerForm',['registerData'=>$this->registerData]);
    }

}
(new RegisterForm())->render();