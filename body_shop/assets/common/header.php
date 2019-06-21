<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: ../controller/login.php");
    exit();
}
?>
<div class="header">
	<img class = "header_img" src="/body_shop/assets/css/img/Logo.png" />
	<a style = "text-decoration: none; font-size: 30px" class = "exit" href = "../body_shop/logout.php" >Выйти из <?php echo $_SESSION['user'] ?></a>
</div>