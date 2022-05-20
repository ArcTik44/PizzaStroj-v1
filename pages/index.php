<?php
require "../included/bootstrap.inc.php";
class HomePage extends BaseDBPage{
    public string $name;
    public string $email;
    public ?int $customer_id;

    public function __construct()
    {
        parent::__construct();
        $this->title = "Uživatelský profil";
        $this->name = $_SESSION['name']??"";
        $this->email = $_SESSION['email']??"";
        
    }

    protected function body(): string
    {
        if(!$_SESSION)
            {
                  header('location:login.php',false);
                  exit;
            }
        return $this->m->render('homepage',['customername'=>$_SESSION['name']]);
    }
}
(new HomePage())->render();