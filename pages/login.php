<?php
require "../included/bootstrap.inc.php";
final class LoginForm extends BaseDBPage{
    private Access $LoginData;

    public function __construct()
    {
        parent::__construct();
        $this->title = "Přihlášení";
    }
    protected function body():string{
        $this->LoginData = Access::readPost();
        $getInfo = $this->LoginData->Authenticate();
        if($getInfo){
            $_SESSION['email'] = $getInfo[0];
            $_SESSION['customer_id'] = $getInfo[1];
            $_SESSION['name'] = $getInfo[2];
            header('location:index.php',false);
            exit;
        }
        
        return $this->m->render('loginForm',['LoginData'=>$this->LoginData]);
    }

}
(new LoginForm())->render();
?>