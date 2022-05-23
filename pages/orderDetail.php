<?php
require "../included/bootstrap.inc.php";
final class OrderDetail extends BaseDBPage{
    public int $order_id;

    public function body():string{
        return $this->m->render('orderdetail');
    }
}
(new OrderDetail())->render();