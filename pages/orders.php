<?php
require "../included/bootstrap.inc.php";
final class OrderList extends BaseDBPage{
    public int $customer_id;
    public function setUp():void
    {
        parent::setUp();
        $this->title = "Seznam objednávek";
        $this->customer_id = filter_input(INPUT_GET,'customer_id');
    }

    public function body():string{

        $query = "SELECT customer.email, `order`.order_time, `order`.order_id, `order`.`state`, `order`.price 
        FROM customer INNER JOIN `order` 
        ON customer.order_id = `order`.order_id 
        WHERE customer.customer_id = :customer_id";
        $stmt = DB::getConnection()->prepare($query);
        $stmt->bindParam(':customer_id',$this->customer_id);
        $stmt->execute();
        return $this->m->render('orderlist',['orders'=>$stmt]);
    }
}
(new OrderList())->render();