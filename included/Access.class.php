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
    public int $customerNum;

    public function __construct(array $accessData = [])
    {
        $this->email = filter_input(INPUT_POST,'email')??"";
        $this->password = filter_input(INPUT_POST,'password')??"";
        $this->verifyPassword = filter_input(INPUT_POST,"verifypassword")??"";
        $this->customerName = filter_input(INPUT_POST,'customer_name')??"";
        $this->customerSurname = filter_input(INPUT_POST,'customer_surname')??"";
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

    public function Register():bool{
        
        $queryAddress = 'INSERT INTO address (street,city,`number`,postal_code) VALUES (:street,:city,:num,:psc)';
        $stmtAddress = DB::getConnection()->prepare($queryAddress);
        $query = 'INSERT INTO customer (email,password) VALUES (:email,:password)';
        $stmt = DB::getConnection()->prepare($query);
        
        $stmtAddress->bindParam(':street',$this->customerStreet);
        $stmtAddress->bindParam(':city',$this->customerCity);
        $stmtAddress->bindParam(':num',$this->customerNum);
        $stmtAddress->bindParam(':psc',$this->customerPSC);
        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam('password',$this->password);
        if(!$stmt->execute()||!$stmtAddress->execute()){
            return false;
        }
        $this->customer_id = DB::getConnection()->lastInsertId();
        return true;
    }

    public static function readPost():Access{
        return new self ($_POST);
    }
} 