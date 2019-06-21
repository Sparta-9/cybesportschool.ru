<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: ../controller/login.php");
    exit();
}
include_once "../sys/core/init.inc.php";

$Role = new Roles();

$val_user_login_role = $_SESSION['user'];

$val_user_login_role = $Role->checkRole($val_user_login_role);

if($val_user_login_role == 3 or $val_user_login_role == 2){
    header("Location: profile.php");
    exit();
}

?>




<html>

<head>
    <meta charset="utf-8">
    <title>CybesportSchool Database</title>
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <script src="assets/js/script.js"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/jquery.inputmask.bundle.js"></script>


</head>
<script>

</script>
<body>
<div class="content">
    <div class="tabs-wrapper">
        <div class="tabs-titles-wrap">
            <img class = "header_img" src="/body_shop/assets/css/img/Logo.png" />
            <?php
                if($val_user_login_role == 1){
            echo '<div class="tab active">Аккаунты</div>';
            }?>

            <div class="tab">Команды</div>
            <div class="tab">Рассписание</div>
            <a style = "color: white; margin-left: 1000px; margin-top: 10px;  text-decoration: none; font-size: 20px" class = "exit" href = "../body_shop/index.php" > <-Назад</a>
        </div>
        <div class="tabs-content-wrap">
            <div class="tab-content active">
                <?php if($val_user_login_role == 1) {
                    include "assets/control/user_tab.php";
                }?>
            </div>
            <div class="tab-content">
                <?php
                include "assets/control/team_tab.php";
                ?>
            </div>
            <div class="tab-content">
                <?php
                include "assets/control/schedule_tab.php";
                ?>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/script.js"></script>
</body>

</html>
