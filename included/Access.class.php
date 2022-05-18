<?php
class Access{
    public int $user_id;
    public string $email;
    public string $password;
    public string $admin;
    public string $cook;
    public string $verifyPassword;

    public function __construct(array $accessData = [])
    {
        $this->email = filter_input(INPUT_POST,'email')??"";
        $this->password = filter_input(INPUT_POST,'password')??"";
    }

    public function Authenticate():array{
        $query = "SELECT email, `password`,is_admin,is_cook,`user_id` FROM user WHERE email =:email";
        $stmt = DB::getConnection()->prepare($query);
        $stmt->bindParam(':email',$this->email);
        $dbData = $stmt->fetch(PDO::FETCH_ASSOC);
        if(password_verify($this->password,$dbData['password'])){
            return [$dbData['email'],$dbData['is_admin'],$dbData['is_cook'],$dbData['user_id']];
        }
        return [];
    }

    public function Register():bool{
        $query = 'INSERT INTO user (email,password) VALUES (:email,:password)';
        $stmt = DB::getConnection()->prepare($query);

        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam('password',$this->password);
        if(!$stmt->execute()){
            return false;
        }
        $this->user_id = DB::getConnection()->lastInsertId();
        return true;
    }

    public static function readPost():Access{
        return new self ($_POST);
    }
} 