<?php
session_start();

include_once "../sys/core/init.inc.php";

$User = new Users();

if($User->disabledUser($_SESSION['user']) == '1'){
    echo "
<script>
function redir()
{

window.location.assign('disabled.php');
}
redir();
</script>
";
}


if (!isset($_SESSION['user'])) {
    header("Location: ../controller/login.php");
    exit();
}


$Role = new Roles();


$val_user_login_role = $_SESSION['user'];

$val_user_login_role = $Role->checkRole($val_user_login_role);


?>


<html>

<head>
    <meta charset="utf-8">
    <title>CybesportSchool Database</title>
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <script src="assets/js/script.js"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/jquery.inputmask.bundle.js"></script>
    <script>
        window.onload = function () {
            var user_login = <?php echo $val_user_login_role; ?>;
            if(user_login == 2) {
                function failSafe() {
                    if (localStorage.getItem("activetab") === null || localStorage.getItem("activetab") == 3) {
                        document.getElementsByClassName("tab-content")[0].className = "tab-content active";
                        document.getElementsByClassName("tab")[0].className = "tab active"
                    }
                }
            }

            if(user_login == 3) {
                function failSafe() {
                    if (localStorage.getItem("activetab") === null) {
                        document.getElementsByClassName("tab-content")[0].className = "tab-content active";
                        document.getElementsByClassName("tab")[0].className = "tab active"
                    }
                }
            }

            function setActive() {
                document.getElementsByClassName("tab-content")[parseInt(localStorage.getItem("activetab"))].className = "tab-content active";
                document.getElementsByClassName("tab")[parseInt(localStorage.getItem("activetab"))].className = "tab active"
            }

            function removeActive() {

                if (user_login == "3") {
                    document.getElementById("tab-1").className = "tab-content";
                    document.getElementById("tab-2").className = "tab-content";
                    document.getElementById("tab-3").className = "tab-content";
                    document.getElementById("tab-4").className = "tab-content";
                    document.getElementById("tab-5").className = "tab-content";
                    document.getElementsByClassName("tab")[0].className = "tab";
                    document.getElementsByClassName("tab")[1].className = "tab";
                    document.getElementsByClassName("tab")[2].className = "tab";
                    document.getElementsByClassName("tab")[3].className = "tab";
                    document.getElementsByClassName("tab")[4].className = "tab";
                }
                if (user_login == "2"){
                    document.getElementById("tab-1").className = "tab-content";
                    document.getElementById("tab-2").className = "tab-content";
                    document.getElementById("tab-3").className = "tab-content";
                    document.getElementById("tab-5").className = "tab-content";
                    document.getElementsByClassName("tab")[0].className = "tab";
                    document.getElementsByClassName("tab")[1].className = "tab";
                    document.getElementsByClassName("tab")[2].className = "tab";
                    document.getElementsByClassName("tab")[3].className = "tab";
                }



            }

            removeActive();
            failSafe();
            setActive();
        }
    </script>


</head>
<script>

</script>
<body>
<div class="header">
</div>
<div class="content">
    <div class="tabs-wrapper">
        <div class="tabs-titles-wrap">
            <img class="header_img" src="/body_shop/assets/css/img/Logo.png"/>
            <div class="tab">Профиль</div>
            <div class="tab">Команда</div>
            <div class="tab">Курсы</div>
            <?php
            if ($val_user_login_role == '3') {
                echo '<div class="tab" > Квитанции</div >';
            }else{
                echo '<div style="width: 1px" class="tab" > </div >';
            }
            ?>
            <div class ="tab">Рассписание</div>
            <?php
            if ($val_user_login_role == '2'){
                echo '<a style = "white-space: nowrap; color: white; margin-left: 700px; margin-top: 10px;  text-decoration: none; font-size: 20px" class = "exit" href = "../body_shop/index.php" > <-Назад</a>';
            }
            if ($val_user_login_role == '3'){
            echo '<a style=" white-space: nowrap; color: white; margin-left: 500px; margin-top: 10px;  text-decoration: none; font-size: 20px"
               class="exit" href="../body_shop/logout.php">Выйти из ', $_SESSION["user"] .'</a>
        ';
        }
?>
        </div>
        <div class="tabs-content-wrap" id="tabs">
            <div class="tab-content" id="tab-1">
                <?php
                include "assets/profile/profile_tab.php";
                ?>
            </div>
            <div class="tab-content" id="tab-2">
                <?php
                include "assets/profile/profile_team_tab.php";
                ?>

            </div>
            <div class="tab-content" id="tab-3">
                <?php
                include "assets/profile/profile_course_tab.php";
                ?>
            </div>
            <div class="tab-content" id="tab-4">
                <?php
                    include "assets/profile/profile_check_tab.php";
                ?>
            </div>
            <div class="tab-content" id="tab-5">
                <?php
                include "assets/profile/profile_schedule_tab.php";
                ?>
            </div>

        </div>

    </div>
</div>
<script src="assets/js/script.js"></script>
</body>

</html>
