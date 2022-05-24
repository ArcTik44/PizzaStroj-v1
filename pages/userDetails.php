<?php
require "../included/bootstrap.inc.php";
final class UserDetails extends BaseDBPage{
    private Access $updateData; 
    public ?int $customer_id;
    public function __construct()
    {
        parent::__construct();
        $this->customer_id = filter_input(INPUT_GET,'customer_id');
        $this->title = "Change user details";
    }

    public function body():string{

        $query = "SELECT customer.customer_id ,customer.name, customer.surname, customer.email, address.street, address.city, 
        address.number, address.postal_code FROM customer INNER JOIN address ON customer.customer_id = address.customer_id
        WHERE customer.customer_id =:customer_id";
        $stmt = DB::getConnection()->prepare($query);
        $stmt->bindParam(':customer_id',$this->customer_id);
        $stmt->execute();

        $this->updateData = Access::readPost();
        $getInfo = $this->updateData->Update();
        if($getInfo){
            return $this->m->render('success',['message'=>'Change of account details succeeded.']);
        }
        else return $this->m->render('fail',['message'=>'Change of account details failed.','customer_id'=>$this->customer_id]);

        return $this->m->render('userDetails',['details'=>$stmt]);
    }
}
(new UserDetails())->render();