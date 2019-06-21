<?php
$Profile = new Profile();
$Roles = new Roles();
$val_user_login_role = $_SESSION['user'];
$val_user_role = $Roles->checkRole($val_user_login_role);

function loadProfileTabScript()
{
    echo ' <script>
    function showPassword(){
     const checker = document.getElementById("checker");   
     document.getElementById("change_password").type = checker.checked ? "text" : "password";
     document.getElementById("confirm_change_password").type = checker.checked ? "text" : "password";
     document.getElementById("confirm_changes").type = checker.checked ? "text" : "password";
     }
</script>';
};

if ($val_user_role == '3') {
    $val_user_name = $Profile->TeacherName($val_user_login_role);
    $val_student_nickname = $Profile->StudentNickname($_SESSION['user']);
    $val_user_role = 3;
    $val_count_of_courses = $Profile->countOfCoursesStudent($val_user_name);
    $val_count_of_checks = $Profile->countOfChecks($val_user_name);
}elseif($val_user_role == '2'){
    $val_user_name = $Profile->TeacherName($val_user_login_role);
    $val_count_of_courses = $Profile->countOfCoursesTeacher($val_user_name);
}else{
    $val_user_name = 'Admin';
}
    function loadProfileTabEditor($val_user_name, $val_user_role, $val_student_nickname, $val_count_of_courses, $val_count_of_checks, $Profile)
    {
        echo '<form method="post" name="form1" class="form-main">
    
	<div class="div-form-profile">
	    <label class = "label-profile" for="profile_name">Ваше имя: </label>
	    <input type="text" class = "label-profile" value="', $val_user_name. '" readonly >
        ';
        if ($val_user_role == '3'){
            echo '<label for="profile_login">Ваш никнейм: </label>
        <input type="text" class = "label-profile" value= "', $val_student_nickname. '" readonly >
        <label for="profile_login">Количество предстоящих курсов: </label>
        <input style="margin-top: 30px" type="text" class = "label-profile" value= "', $val_count_of_courses. '" readonly >
        <label style="margin-top: 30px" for="profile_login">Количество не оплаченых квитанций: </label>
        <input style="margin-top: 53px" type="text" class = "label-profile" value= "', $val_count_of_checks. '" readonly >';

        };
        if ($val_user_role == '2'){
            echo '
        <label for="profile_login">Количество предстоящих курсов: </label>
        <input style="margin-top: 30px" type="text" class = "label-profile" value= "', $val_count_of_courses. '" readonly >';

        };
         echo '<label style="margin-top: 30px" for="profile_login">Ваш логин: </label>
        <input style="margin-top: 30px" type="text" class = "label-profile" value="', $_SESSION["user"]. '" readonly >
        <label for="profile_login_change">Изменить логин: </label>
		<input class = "input-profile" type="text" name="profile_login_change" class="box"></><br>
        <label for="profile_password_change">Изменить пароль: </label>
        <input id="change_password" class = "input-profile" type="password" name="profile_password_change" class="box"><br>
        <label for= "team_first_player">Повторите пароль: </label>
        <input class = "input-profile" id="confirm_change_password" type="password" name="profile_password_change_confirm" class="box">
        <label for= "profile_password_confirm">Для примениния изменений введите пароль: </label>
        <input class = "input-profile" id="confirm_changes" style = "margin-top: 48px " type="password" name="profile_password_confirm" class="box" required><br>
        <input type="checkbox" id = "checker" onchange="showPassword()"> Показать пароль
		<input class = "input-profile" type="submit" name="change_User" value="Изменить" class="button box">
		
		 
				
	';



    if (isset($_POST['change_User'])) {
        $val_login = $_POST['profile_login_change'];
        if($val_login == ''){
            $val_login = $_SESSION['user'];
        }
        $val_password = $_POST['profile_password_confirm'];
        $val_new_password = $_POST['profile_password_change'];
        $val_new_password_confirm = $_POST['profile_password_change_confirm'];
        if(($val_new_password == '') AND ($val_new_password_confirm == '')){
            $val_new_password = $Profile->GetPass($_SESSION['user']);
            $val_new_password_confirm = $Profile->GetPass($_SESSION['user']);
        }
        if($val_password == $Profile->GetPass($_SESSION['user'])){
            if($val_new_password == $val_new_password_confirm){
                $Profile->changeAccount($val_new_password, $val_login, $val_user_name);
            }else{
                echo '<input class = "label-profile" style="color: #333333; margin-left: 200px" value="Пароли не совпадают" readonly/>';
            }

        }else{
            echo '<input class = "label-profile" style="color: #333333; margin-left: 150px" value = "Не правильный пароль от аккаунта" readonly/>';
        }
    }
    echo '</div>
	
    
</form>';
    };
    loadProfileTabScript();
    loadProfileTabEditor($val_user_name, $val_user_role, $val_student_nickname, $val_count_of_courses, $val_count_of_checks, $Profile);




