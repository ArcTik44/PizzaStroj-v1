<?php
require "../included/bootstrap.inc.php";
final class CreateOrder extends BaseDBPage{
    public function __construct()
    {
        parent::__construct();
        $this->title = "Create new order";
    }
    public function body():string{
        return $this->m->render('createOrder');
    }
}
(new CreateOrder())->render();