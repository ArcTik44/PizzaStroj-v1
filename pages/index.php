<?php
session_start();
if(session_unset()){
    header('location:login.php',false);
}