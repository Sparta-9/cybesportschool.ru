<?php


session_start();

if(!isset($_SESSION['user'])){
    header("Location: controller/login.php");
}

include "../view/workspace.php";

?>