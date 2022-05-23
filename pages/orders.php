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

        $query = "";
        $stmt = DB::getConnection()->prepare($query);

        return $this->m->render('orderlist',[]);
    }
}
