<?php
session_start();

include_once "../sys/core/init.inc.php";

$Schedule = new Schedule();

$User = new Users();

if($User->disabledUser($_SESSION) == '1'){
    header("Location ../controller/disabled.php");
}

if(!isset($_SESSION['user'])){
    header("Location: ../controller/login.php");
    exit();
}

$Role = new Roles();

$Schedule = new Schedule();

$val_count = $Schedule->countSubmits();

$val_user_login_role = $Role->checkRole($_SESSION['user']);

if($val_user_login_role == 3){
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
        <script>
            window.onload = function () {

                function failSafe() {
                    if (localStorage.getItem("activetab") === null) {
                        document.getElementsByClassName("tab-content")[0].className = "tab-content active";
                        document.getElementsByClassName("tab")[0].className = "tab"
                    }
                }

                function setActive() {
                    document.getElementsByClassName("tab-content")[parseInt(localStorage.getItem("activetab"))].className = "tab-content active";
                    document.getElementsByClassName("tab")[parseInt(localStorage.getItem("activetab"))].className = "tab active"
                }

                function removeActive() {
                    document.getElementById("tab-1").className = "tab-content";
                    document.getElementById("tab-2").className = "tab-content";
                    document.getElementById("tab-3").className = "tab-content";
                    document.getElementById("tab-4").className = "tab-content";
                    document.getElementsByClassName("tab")[0].className = "tab";
                    document.getElementsByClassName("tab")[1].className = "tab";
                    document.getElementsByClassName("tab")[2].className = "tab";
                    document.getElementsByClassName("tab")[3].className = "tab";

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
		<div class = "header">
		</div>
		<div class="content">
			<div class="tabs-wrapper">
				<div class="tabs-titles-wrap">
                    <img class = "header_img" src="/body_shop/assets/css/img/Logo.png" />
                    <div class="tab">Преподаватели</div>
					<div class="tab">Ученики</div>
					<div class="tab">Курсы</div>
                    <?php if($val_user_login_role == '1') {
                    echo '<div class="tab">Отчёты об оплате</div>';
                    }
                    ?>
					<?php if($val_user_login_role == '1') {
                    echo ' <a style = "text-decoration: none" class = "tab" href = "../body_shop/controlpanel.php">Управление</a>';
                        echo ' <a style = "color: white; font-weight: bold;  margin-left: 10px;  margin-top: 10px; text-decoration: none; font-size: 20px; white-space: nowrap"> Заявок:  ', $val_count. '</a>';
                    }
                    ?>
                    <?php if($val_user_login_role == '2'){
                        echo '<a style = "text-decoration: none" class = "tab" href = "../body_shop/profile.php" >Профиль</a>';
                    }?>
                    <a style = "white-space: nowrap; color: white; margin-left: 330px; margin-top: 10px;  text-decoration: none; font-size: 20px" class = "exit" href = "../body_shop/logout.php" >Выйти из <?php echo $_SESSION['user'] ?></a>
				</div>




                <div class="tabs-content-wrap" id="tabs">
					<div class="tab-content" id="tab-1">
						<?php
							include "assets/common/teacher_tab.php";
						?>
					</div>
					<div class="tab-content" id="tab-2">
						<?php
							include "assets/common/student_tab.php";
						?>

					</div>
					<div class="tab-content" id="tab-3">
						<?php
							include "assets/common/course_tab.php";
                        ?>
					</div>
                    <div class="tab-content" id="tab-4">
                        <?php
                            if($val_user_login_role == '1') {
                                include "assets/common/check_tab.php";
                            }
                        ?>
                    </div>

				</div>

			</div>
		</div>
        <script src="assets/js/script.js"></script>
	</body>

</html>
