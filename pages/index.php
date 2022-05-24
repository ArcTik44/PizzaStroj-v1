<?php
require "../included/bootstrap.inc.php";
final class HomePage extends BaseDBPage{
    public string $name;
    public string $email;
    public int $customer_id;

    public function __construct()
    {
        parent::__construct();
        $this->title = $_SESSION['email']??"";
        $this->name = $_SESSION['name']??"";
        $this->email = $_SESSION['email']??"";
        $this->customer_id = $_SESSION['customer_id']??0;  
    }

    protected function body(): string
    {
        $addressVerified = false;
        if(!$_SESSION)
            {
                  header('location:login.php',false);
                  exit;
            }
        
        return $this->m->render('homepage',['customername'=>$this->name,'customerId'=>$this->customer_id,'addressVerified'=>$addressVerified]);
    }
}
(new HomePage())->render();