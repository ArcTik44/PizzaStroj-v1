<?php
class Order{
    
    public string $orderInfo;
    
    
    public function __construct(array $orderData = [])
    {
        
    }
    public function CreateOrder():array{

        return [];
    }
    public static function readPost():Order{
        return new self ($_POST);
    }
}