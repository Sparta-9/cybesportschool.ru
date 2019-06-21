<?php

session_start();

if(!isset($_SESSION['user'])){
    header("Location: controller/login.php");
    exit();

} else {
    header("Location: body_shop/index.php");
    exit();
}