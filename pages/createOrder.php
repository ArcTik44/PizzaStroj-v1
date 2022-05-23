<?php
require "../included/bootstrap.inc.php";
class CreateOrder extends BaseDBPage{
    public function body():string{
        return $this->m->render('createOrder');
    }
}