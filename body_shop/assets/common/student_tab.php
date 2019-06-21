<?php

$Students = new Student();
function loadStudentScript()
{
    echo '<script>
    $(document).ready(function () {
        
        $("#student_phone_id").inputmask({mask : "+7(999) 999-99-99", showMaskOnHover: false
        });
        
        $("#student_email_id").inputmask({mask: "*{1,16}@*{1,6}[.*{1,3}]", showMaskOnHover: false
        });
            
        $("#Student_address_id").inputmask({mask: "Aa{0,10} 9{1,3}", showMaskOnHover: false
        });
        
        $("#Student_name_id").inputmask({mask: "Aa{1,10} Aa{1,10} Aa{1,10}", showMaskOnHover: false
        });
        $("table tr").click(function () {
            
            const id_stroke = $(this).find("td").eq(0).html();
            const name_stroke = $(this).find("td").eq(1).html();
            const nickname_stroke = $(this).find("td").eq(2).html();
            const address_stroke = $(this).find("td").eq(3).html();
            const phone_stroke = $(this).find("td").eq(4).html();
            const email_stroke = $(this).find("td").eq(5).html();
            
            $("input[name=Student_id").val(id_stroke);

            $("input[name=Student_name").val(name_stroke);
            
            $("input[name=Student_nickname").val(nickname_stroke);

            $("input[name=Student_address]").val(address_stroke);

            $("input[name=Student_phone]").val(phone_stroke);
            
            $("input[name=Student_email]").val(email_stroke);
            
            $("#change_Student_id").prop("disabled" , false); 
            $("#del_Student_id").prop("disabled" , false); 
           
        });
    });
    </script>';
}



echo "<table>";
echo "<tr><th style='visibility: hidden'>ID</th></th><th>Ф.И.О</th><th>Ник</th><th>Адрес</th><th>Телефон</th><th>Э-майл</th></tr>";

function loadStudentEditor()
{
    if ($_SESSION['user'] == 'admin') {
        echo '<form method="post" name="form1" class="form-main">
	<div class="div-form-main">
	    <input style="visibility: hidden; height: 1px;" type="text" name="Student_id" class="box"><br>
		<label for="Student_name">Имя</label>
		<input type="text" pattern="^[А-Яа-яЁё\s]+$" id = "Student_name_id" name="Student_name" class="box" required><br>
		<label for="Student_nickname">Ник</label>
		<input type="text" name="Student_nickname" class="box" required><br>
		<label for="Student_address">Адрес</label>
		<input type="text" id = "Student_address_id" name="Student_address" class="box" required><br>
		<label for="Student_phone">Телефон</label>
		<input type="text" name="Student_phone" id = "student_phone_id" pattern="[^_]{17}" class="box" required><br>
		<label for="Student_email">Э-майл</label>
		<input type="text" name="Student_email" id = "student_email_id" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" class="box" required><br>
		<input type="submit" name="add_Student" value="Добавить" class="button box">
		<input type="submit" id = "change_Student_id" name="change_Student" value="Изменить" class="button box" disabled>
		<input type="submit" id = "del_Student_id" name="del_Student" value="Удалить" class="button box" formnovalidate disabled>
		<input type="submit" name="search_Student" value="Поиск" class="button box" formnovalidate>
	</div>
</form>';
    }
}

if (isset($_POST['search_Student'])) {
    $val_name = $_POST['Student_name'];
    $val_nickname = $_POST['Student_nickname'];
    $val_address = $_POST['Student_address'];
    $val_phone = $_POST['Student_phone'];
    $val_email = $_POST['Student_email'];
    $Students->searchStudent($val_name, $val_nickname, $val_address, $val_phone, $val_email);
    loadScript();
    loadEditor();
    return;
}
$Students->showAllStudent();

if (isset($_POST['add_Student'])) {
    $val_name = $_POST['Student_name'];
    $val_nickname = $_POST['Student_nickname'];
    $val_address = $_POST['Student_address'];
    $val_phone = $_POST['Student_phone'];
    $val_email = $_POST['Student_email'];
    $val_login = $Students->translitStudent($val_name);
    $val_password = $Students->generatorStudent();
    $Students->addStudent($val_name, $val_nickname, $val_address, $val_phone, $val_email, $val_login, $val_password);
}

if (isset($_POST['change_Student'])) {
    $val_student_id = $_POST['Student_id'];
    $val_name = $_POST['Student_name'];
    $val_nickname = $_POST['Student_nickname'];
    $val_address = $_POST['Student_address'];
    $val_phone = $_POST['Student_phone'];
    $val_email = $_POST['Student_email'];
    $Students->changeStudent($val_student_id, $val_name, $val_nickname, $val_address, $val_phone, $val_email);
}

if (isset($_POST['del_Student'])) {
    $val_student_id = $_POST['Student_id'];
    $Students->delStudent($val_student_id);
}

loadStudentEditor();
loadStudentScript();


