<?php
require "../included/bootstrap.inc.php";
use PHPUnit\Framework\TestCase;

class example extends TestCase{
    
    public function testStrings(){
        $str1 = "string";
        $str2 = "string";

        $this->assertSame($str1,$str2);
    }

    public function auth_test(){
        $acc = Access::class;
        
    }
}