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
        $updateQuery = "SELECT `name`,surname,email, customer_id FROM customer WHERE customer_id = :customer_id";
        $queryAddress = "SELECT address.number, address.street, address.city, address.postal_code FROM address WHERE customer_id =:customer_id";
        
        $stmt = DB::getConnection()->prepare($updateQuery);
        $stmtAddress = DB::getConnection()->prepare($queryAddress);

        $stmt->bindParam(':customer_id',$this->customer_id);
        $stmtAddress->bindParam(':customer_id',$this->customer_id);
        $stmtAddress->execute();
        $stmt->execute();

        $addressVerified = false;

        if($stmt->rowCount()!=0){
            $addressVerified = true;
        }
        else $addressVerified = false;
        if(!$_SESSION)
            {
                  header('location:login.php',false);
                  exit;
            }
        
        return $this->m->render('homepage',['data'=>$stmt,'addressVerified'=>$addressVerified]);
    }
}
(new HomePage())->render();