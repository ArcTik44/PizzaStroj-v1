<?php
require "../included/bootstrap.inc.php";
final class OrderDetail extends BaseDBPage{
    public int $order_id;
    public int $customer_id;
    public function __construct()
    {
        parent::__construct();
        $this->title="Detail of Order";
        $this->order_id = filter_input(INPUT_GET,'order_id');
        $this->customer_id = $_SESSION['customer_id']??0;
    }
    public function body():string{
        $query = "SELECT pizza.name AS PizzaName, beverage.name AS BeverageName,`order`.info,`order`.state,`order`.order_time,`order`.delivery_time,`order`.price
        FROM ((pizza
        INNER JOIN `order` ON `order`.pizza_id = pizza.pizza_id)
        INNER JOIN beverage ON `order`.beverage_id = beverage.beverage_id)
        WHERE `order`.order_id = :order_id";
        $queryAddress = "SELECT address.number, address.city, address.street, address.postal_code
        FROM address
        WHERE customer_id = :customer_id";
        $stmtAddress = DB::getConnection()->prepare($queryAddress);
        $stmtAddress->bindParam(':customer_id',$this->customer_id);
        $stmtAddress->execute();
        $stmt = DB::getConnection()->prepare($query);
        $stmt->bindParam(':order_id',$this->order_id);
        $stmt->execute();
        return $this->m->render('orderdetail',['orderDetail'=>$stmt,'customer_id'=>$_SESSION['customer_id'],'address'=>$stmtAddress]);
    }
}
(new OrderDetail())->render();