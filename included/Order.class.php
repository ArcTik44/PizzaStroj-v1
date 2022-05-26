<?php
class Order{
    public ?int $order_id;
    public int $pizza_id;
    public int $beverage_id;
    public string $order_date;
    public string $delivery_date;
    public string $info;
    public float $price;



    public function __construct(array $orderData = [])
    {
        $this->order_id = filter_var($orderData['order_id'],FILTER_VALIDATE_INT);
        $this->info = filter_input(INPUT_POST,'info')??"";
        $this->pizza_id = filter_input(INPUT_POST,'pizza_id');
        $this->beverage_id = filter_input(INPUT_POST,'beverage_id');
        $this->order_date = date('Y-m-d');
    }
    private function getBeveragePrice(int $beverage_id):float{
        $query = "SELECT price FROM beverage WHERE beverage_id = :beverage_id";
        $stmt = DB::getConnection()->prepare($query);
        $stmt->bindParam('beverage_id',$this->beverage_id);
        $stmt->execute();
        $beveragePrice = $stmt->fetch(PDO::FETCH_ASSOC);
        return $beveragePrice;
    }
    public function getPizzaPrice(int $pizza_id):float{
        $query = "SELECT price FROM pizza WHERE pizza_id = :pizza_id";
        $stmt = DB::getConnection()->prepare($query);
        $stmt->bindParam('pizza_id',$this->pizza_id);
        $stmt->execute();
        $pizzaPrice = $stmt->fetch(PDO::FETCH_ASSOC);
        return $pizzaPrice;
    }
    public function CreateOrder():bool{
        $this->price = $this->getPizzaPrice($this->pizza_id) + $this->getBeveragePrice($this->beverage_id);
        $query = "INSERT INTO `order` (pizza_id,beverage_id,address_id,info,order_time,delivery_time,price,`state`)
        VALUES (:pizza_id,:beverage_id,:address_id,:info,:order_time,:delivery_time,:price,:`state`)";
        $stmt = DB::getConnection()->prepare($query);

        if(!$stmt->execute()){
            return false;
        }
        $this->order_id = DB::getConnection()->lastInsertId();
        return true;
    }
    public static function readPost():Order{
        return new self ($_POST);
    }
}