<?php
class Access{
    public ?int $customer_id;
    public string $email;
    public string $password;    
    public string $verifyPassword;
    public ?string $customerName;
    public string $customerSurname;
    
    public ?int $customerPSC;
    public ?string $customerStreet;
    public ?string $customerCity;
    public ?int $customerNum;

    public function __construct(array $accessData = [])
    {
        $this->customer_id = filter_input(INPUT_POST,'customer_id')??null;
        $this->email = filter_input(INPUT_POST,'email')??"";
        $this->password = filter_input(INPUT_POST,'password')??"";
        $this->verifyPassword = filter_input(INPUT_POST,"verifypassword")??"";
        $this->customerName = filter_input(INPUT_POST,'name')??"";
        $this->customerSurname = filter_input(INPUT_POST,'surname')??"";
        $this->customerStreet = filter_input(INPUT_POST,'street')??null;
        $this->customerCity = filter_input(INPUT_POST,'city')??null;
        $this->customerNum = filter_input(INPUT_POST,'number')??null;
        $this->customerPSC = filter_input(INPUT_POST,'postal_code')??null;
       
    }
    

    public function passwordChange():bool{
        $this->customer_id = filter_input(INPUT_GET,'customer_id',FILTER_VALIDATE_INT);
        $passHash = password_hash($this->password,PASSWORD_DEFAULT); 
        if(password_verify($this->verifyPassword,$passHash)){
        $query = "UPDATE customer SET password = :passHash WHERE customer_id = :customer_id";
        $stmtChange = DB::getConnection()->prepare($query);
        $stmtChange->bindParam(':passHash',$passHash);
        $stmtChange->bindParam(':customer_id', $this->customer_id);
        $stmtChange->execute();
        return true;
        }
        else return false;
        
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
    public function Update():bool{
        $query = "UPDATE customer SET `name`=:name, surname=:surname, email=:email WHERE customer_id =:customer_id";
        $queryAddress = "UPDATE address SET `number`=:number, street=:street, city=:city, postal_code=:postal_code WHERE customer_id=:customer_id";
        $stmt = DB::getConnection()->prepare($query);
        $stmtAddress = DB::getConnection()->prepare($queryAddress);
        $stmt->bindParam(':name',$this->customerName);
        $stmt->bindParam(':surname',$this->customerSurname);
        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam(':customer_id',$this->customer_id);
        $stmtAddress->bindParam('number',$this->customerNum);
        $stmtAddress->bindParam('street',$this->customerStreet);
        $stmtAddress->bindParam('city',$this->customerCity);
        $stmtAddress->bindParam('postal_code',$this->customerPSC);
        $stmtAddress->bindParam('customer_id',$this->customer_id);
        $stmtAddress->execute();
        return $stmt->execute();
    }

    public static function readPost():Access{
        return new self ($_POST);
    }
} 