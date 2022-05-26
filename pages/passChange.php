<?php
require "../included/bootstrap.inc.php";

final class PasswordChange extends BaseDBPage{
    private Access $passwordChange;
    public function __construct()
    {
        parent::__construct();
        $this->title = "Password change";
    }
    public function body():string{
        $this->passwordChange = Access::readPost();
        if($_POST){
            $equals = $this->passwordChange->passwordChange();
            if($equals){
                return $this->m->render('success',['message'=>'Password change succeeded']);
            }
            else $this->m->render('success',['message'=>'Password change succeeded']);
        }
        return $this->m->render('passChange',['passwordData'=>$this->passwordChange]);
    }
}
(new PasswordChange())->render();