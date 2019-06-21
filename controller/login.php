<?php
session_start();

if(isset($_SESSION['user'])){
    header("Location: ../body_shop/index.php");
    exit();
}

include "../view/login.php";

