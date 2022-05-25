<?php
require "../included/bootstrap.inc.php";
final class UserDetails extends BaseDBPage{

    const STATE_FORM_REQUESTED = 1;
    const STATE_FORM_SENT = 2;
    const STATE_PROCESSED = 3;

    const RESULT_SUCCESS = 1;
    const RESULT_FAIL = 2;

    private Access $updateData; 
    public ?int $customer_id;
    private int $result = 0;
    private int $state;
    public function setUp():void
    {
        $this->state = $this->getState();
        parent::setUp();
        $this->customer_id = filter_input(INPUT_GET,'customer_id');
        if($this->state===self::STATE_PROCESSED){
            if($this->result===self::RESULT_SUCCESS){
                $this->title = "Account details updated";
            }
            elseif($this->result===self::RESULT_FAIL){
                $this->title = "Update failed";
            }
        }
        elseif($this->state===self::STATE_FORM_SENT){
            $this->updateData = Access::readPost();
            if($this->updateData->Update()){
                $this->redirect(self::RESULT_SUCCESS);
            }
            else $this->redirect(self::RESULT_FAIL);
        }
        else{
            $this->state = self::STATE_FORM_REQUESTED;
            $this->title = "Account details update";
        }
    }

    private function getState() : int {
        $result = filter_input(INPUT_GET, 'result', FILTER_VALIDATE_INT);

        if ($result === self::RESULT_SUCCESS) {
            $this->result = self::RESULT_SUCCESS;
            return self::STATE_PROCESSED;
        } elseif ($result === self::RESULT_FAIL) {
            $this->result = self::RESULT_FAIL;
            return self::STATE_PROCESSED;
        }

        $action = filter_input(INPUT_POST, 'action');
        if ($action === 'update') {
            return self::STATE_FORM_SENT;
        }

        return self::STATE_FORM_REQUESTED;
    }

    public function body():string{
        $query = "SELECT customer.customer_id ,customer.name, customer.surname, customer.email, address.street, address.city, 
        address.number, address.postal_code FROM customer INNER JOIN address ON customer.customer_id = address.customer_id
        WHERE customer.customer_id =:customer_id";
        $stmt = DB::getConnection()->prepare($query);
        $stmt->bindParam(':customer_id',$this->customer_id);
        $stmt->execute();
        

        if($this->state = self::STATE_FORM_REQUESTED){
            return $this->m->render('userDetails',['details'=>$stmt]);
        }
        elseif($this->state = self::STATE_PROCESSED){
            if($this->state = self::RESULT_SUCCESS){
                return $this->m->render('success',['message'=>'Change of account details succeeded.']);
            }
            elseif($this->state = self::RESULT_FAIL){
                return $this->m->render('fail',['message'=>'Change of account details failed.','customer_id'=>$this->customer_id]);
            }
        }
    }

    private function redirect(int $result):void{
        $location = strtok($_SERVER['REQUEST_URI'],'?');
        header("location:{$location}?result={$result}");
        exit;
    }
}
(new UserDetails())->render();