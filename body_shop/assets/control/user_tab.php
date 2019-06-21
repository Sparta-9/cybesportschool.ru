<?php

$Roles = new Roles();
$val_role = $Roles->checkRole($_SESSION['user']);

$Users = new Users();

function loadUsersScript()
{
    echo '<script>
    $(document).ready(function(){
        $("table tr").click(function(){

            var user_id_stroke = $(this).find("td").eq(0).html();
            var user_role_stroke = $(this).find("td").eq(1).html();
            var user_name_stroke = $(this).find("td").eq(2).html();
            var user_login_stroke = $(this).find("td").eq(3).html();
            var user_email_stroke = $(this).find("td").eq(4).html();
    
            $("input[name=user_id").val(user_id_stroke);
    
            $("input[name=user_name]").val(user_name_stroke);
    
            $("input[name=user_login]").val(user_login_stroke);
        
            $("input[name=user_email]").val(user_email_stroke);
    
            $("#user_role")[0].value = user_role_stroke;
            
            if(user_role_stroke != "Администратор"){
                $("#disable_user_id").prop("disabled" , false);
                $("#reset_user_id").prop("disabled" , false); 
            }else{
                $("#disable_user_id").prop("disabled" , true);
                $("#reset_user_id").prop("disabled" , true);
            }

    });
});

    </script>';
};

echo "<table>";
echo "<tr><th style='visibility: hidden'>ID</th><th>Роль</th><th>Ф.И.О</th><th>Логин</th><th>Э-мэйл</th><th>Отключён</th></tr>";

function loadUsersEditor()
{
        echo '<form method="post" name="form1" class="form-main">
	<div class="div-form-main">
		<input style="visibility: hidden; height: 1px" type="text" name="user_id" class="box" required>
		<label for="user_role">Роль</label>
		<select id="user_role" type="text" name="user_role" class="box" required>
		    <option></option>
		    <option>Администратор</option>
		    <option>Преподаватель</option>
		    <option>Студент</option>
		</select>
		<label for="user_name">Ф.И.О</label>
		<input type="text" name="user_name" class="box" required><br>
		<label for="user_login">Логин</label>
		<input type="text" name="user_login" class="box" required><br>
		<label for="user_email">Э-майл</label>
		<input type="text" name="user_email" class="box" required><br>
		<input type="submit" id = "disable_user_id" name="disable_user" value="Отключють/Включить" class="button box" disabled formnovalidate>
		<input type="submit" id = "reset_user_id" name="reset_user" value="Сбросить" class="button box" disabled>
		<input type="submit" name="search_User" value="Поиск" class="button box" formnovalidate>
	</div>
</form>';
};

$Users->showAllUsers();

if (isset($_POST['disable_user'])) {
    $val_user_id = $_POST['user_id'];
    $Users->disableUser($val_user_id);
    return;
}

if (isset($_POST['reset_user'])) {
    $val_user_id = $_POST['user_id'];
    $Users->resetUser($val_user_id);
}

loadUsersScript();
loadUsersEditor();



