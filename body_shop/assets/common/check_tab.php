<?php
$check = new Check();
function loadCheckScript()
{

    echo '<script>

function dateValidation(){
     const d1 = new Date(document.getElementById("add_date_of_start_id").value.replace(/-/g, ","));
     const d2 = new Date(document.getElementById("add_date_of_end_id").value.replace(/-/g, ","));
     if(d1>d2){
         document.getElementById("add_date_of_end_id").setCustomValidity("Время начала не может быть позже чем время конца.");
     }else{
         document.getElementById("add_date_of_end_id").setCustomValidity("");
     }

     

     };
    
$(document).ready(function(){
        
    $("#add_date_of_start_id").inputmask("datetime",{
     mask: "y-2-1 h:s", 
     placeholder: "yyyy-mm-dd hh:mm", 
     leapday: "-02-29", 
     separator: "-", 
     alias: "dd-mm-yyyy",
     clearMaskOnLostFocus: true,
     showMaskOnHover: false
});
    
    $("#add_date_of_end_id").inputmask("datetime",{
     mask: "y-2-1 h:s", 
     placeholder: "yyyy-mm-dd hh:mm",
     separator: "-", 
     alias: "dd-mm-yyyy",
     showMaskOnHover: false,
     clearMaskOnLostFocus: true
});
    $("#add_date_of_check_id").inputmask("date",{
     mask: "y-2-1", 
     placeholder: "yyyy-mm-dd",
     leapday: "-02-29", 
     separator: "-", 
     alias: "dd-mm-yyyy",
     showMaskOnHover: false,
     clearMaskOnLostFocus: true
});   
    
    $("table tr").click(function(){
        
        const check_id_stroke = $(this).find("td").eq(0).html();
        const student_id_stroke = $(this).find("td").eq(1).html();
        const course_number_stroke = $(this).find("td").eq(2).html();
        const date_of_start_stroke = $(this).find("td").eq(3).html();
        const date_of_end_stroke = $(this).find("td").eq(4).html();
        const date_of_check_stroke = $(this).find("td").eq(5).html();
        const passed_stroke = $(this).find("td").eq(7).html();
               

        $("input[name=add_check_id]").val(check_id_stroke);

        $("#selected_student_id")[0].value = student_id_stroke;

        $("#selected_course_id")[0].value = course_number_stroke;
        
        $("#passed_check_id")[0].value = passed_stroke;

        $("input[name=add_date_of_start]").val(date_of_start_stroke);

        $("input[name=add_date_of_end]").val(date_of_end_stroke);

        $("input[name=add_date_of_check]").val(date_of_check_stroke);
        
        $("#passed_check_id_id").prop("disabled" , false); 
        $("#del_check_id").prop("disabled" , false); 
    });
    
});
    </script>';
}

echo "<table>";
echo "<tr><th>Номер</th><th>Ф.И.О. Студента</th><th>Название курса</th><th>Дата начала</th><th>Дата конца</th><th>Дата квитанции</th><th>Цена</th><th>Оплачено</th></tr>";

function loadCheckEditor($check)
{
    if ($_SESSION['user'] == 'admin') {
        echo '<form method="post" name="form1" class="form-main">
	<div class="div-form-main">
		<input style="visibility: hidden; height: 1px" pattern="[0-9]{1,3}" type="text" name="add_check_id" class="box"><br>';
        $check->selectedIdStudent();
        $check->selectedIdCourse();
        echo '<label for="date_of_start">Время начала курса</label>
		<input type ="text" id="add_date_of_start_id" name="add_date_of_start" pattern="[^a-zA-Z]{16}" class="box" onchange="dateValidation()" required><br>
		<label for="add_date_of_end">Время конца курса</label>
		<input type="text" name="add_date_of_end" id="add_date_of_end_id" pattern="[^a-zA-Z]{16}" onchange="dateValidation()" class="box" required><br>
		<label for="add_date_of_check">Дата чека</label>
		<input type="text" name="add_date_of_check" id = "add_date_of_check_id" class="box" pattern="[^a-zA-Z]{10}" value= "', date('Y-m-d') . '" required><br>
        <label for="passed_check">Квитанция</label>
		<select type="" name="passed_check" id="passed_check_id" class="box">
		<option></option>
		<option>Да</option>
		<option>Нет</option>
		</select>
		<input type="submit" id = "passed_check_id_id" name="passed_check" value="Оплачено" class="button box" disabled>
		<input type="submit" id = "del_check_id" name="del_check" value="Удалить" class="button box" formnovalidate disabled>
		<input type="submit" name="search_check" value="Поиск" class="button box" formnovalidate>
		

	</div>
</form>';
    };
}

if (isset($_POST['search_check'])) {
    $val_check_id = $_POST['add_check_id'];
    $val_student_id = $_POST['selected_student_id'];
    $val_course_number = $_POST['selected_course_id'];
    if ($_POST['add_date_of_start'] == 'дд.мм.гггг') {
        $val_date_of_start = '';
    } else {
        $val_date_of_start = $_POST['add_date_of_start'];
    }
    if ($_POST['add_date_of_end'] == 'дд.мм.гггг') {
        $val_date_of_end = '';
    } else {
        $val_date_of_end = $_POST['add_date_of_end'];
    }
    if ($_POST['add_date_of_check'] == 'дд.мм.гггг') {
        $val_date_of_check = '';
    } else {
        $val_date_of_check = $_POST['add_date_of_check'];
    }
    if ($_POST['passed_check'] == 'Да'){
        $val_passed = 1;
    }else {
        $val_passed = 0;
    }
    $check->searchCheck($val_check_id, $val_student_id, $val_course_number, $val_date_of_start, $val_date_of_end, $val_date_of_check, $val_passed);
    loadCheckEditor($check);
    loadCheckScript();
    return;
}

$check->showAllChecks();


if (isset($_POST['add_check'])) {
    $val_check_id = $_POST['add_check_id'];
    $val_student_id = $_POST['selected_student_id'];
    $val_course_number = $_POST['selected_course_id'];

    $val_date_of_start = $_POST['add_date_of_start'];
    $val_date_of_end = $_POST['add_date_of_end'];
    $val_date_of_check = $_POST['add_date_of_check'];
    if ($_POST['passed_check'] == 'Да'){
        $val_passed = 1;
    }else {
        $val_passed = 0;
    }
    $check->addCheck($val_check_id, $val_student_id, $val_course_number, $val_date_of_start, $val_date_of_end, $val_date_of_check, $val_passed);
}

if (isset($_POST['passed_check'])) {
    $val_check_id = $_POST['add_check_id'];
    $check->passedCheck($val_check_id);
}

if (isset($_POST['del_check'])) {
    $val_check_id = $_POST['add_check_id'];
    $check->delCheck($val_check_id);
}
loadCheckEditor($check);
loadCheckScript();


