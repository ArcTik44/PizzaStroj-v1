<?php
class Access{
    public string $email;
    public string $password;    
    public string $verifyPassword;
    public ?string $customerName;
    public string $customerSurname;
    
    public int $customerPSC;
    public string $customerStreet;
    public string $customerCity;
    public ?int $customerNum;

    public function __construct(array $accessData = [])
    {
        $this->email = filter_input(INPUT_POST,'email')??"";
        $this->password = filter_input(INPUT_POST,'password')??"";
        $this->verifyPassword = filter_input(INPUT_POST,"verifypassword")??"";
        $this->customerName = filter_input(INPUT_POST,'name')??"";
        $this->customerSurname = filter_input(INPUT_POST,'surname')??"";
        $this->customerStreet = filter_input(INPUT_POST,'street')??"";
        $this->customerCity = filter_input(INPUT_POST,'city')??"";
        $this->customerNum = filter_input(INPUT_POST,'num')??0;
        $this->customerPSC = filter_input(INPUT_POST,'postal_code')??0;
       
    }

    public function Authenticate():array{
        $query = "SELECT email,password,customer_id,name FROM customer WHERE email =:email";
        $stmt = DB::getConnection()->prepare($query);
        $stmt->bindParam(':email',$this->email);
        $stmt->execute();
        $dbData = $stmt->fetch(PDO::FETCH_ASSOC);
        $hash = $dbData['password']??"";
        if(password_verify($this->password,$hash)){
            return [$dbData['email'],$dbData['customer_id'],$dbData['name']];
        }
       
        return [];
    }
    public function ValidateRegister():bool{
        $isOk = true;
        if(!$this->email){
            $isOk = false;
        }
        if(!$this->password){
            $isOk = false;
        }
        if(!$this->verifyPassword){
            $isOk = false;
        }
        if(!$this->customerName){
            $isOk = false;
        }
        if(!$this->customerSurname){
            $isOk = false;
        }
        return $isOk;
    }

    public function Register():bool{
        $query = 'INSERT INTO customer (email,password,name,surname) VALUES (:email,:password,:name,:surname)';
        $stmt = DB::getConnection()->prepare($query);
        
        $stmt->bindParam(':name',$this->customerName);
        $stmt->bindParam(':surname',$this->customerSurname);
        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam('password',$this->password);
        

        if(!$stmt->execute()){
            return false;
        }
        $this->customer_id = DB::getConnection()->lastInsertId();
        return true;
    }

    public static function readPost():Access{
        return new self ($_POST);
    }
} 