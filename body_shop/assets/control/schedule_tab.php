<?php
$Schedule = new Schedule();
function loadScheduleScript()
{

    echo '<script>

function dateValidation(){
     const d1 = new Date(document.getElementById("add_date_of_start_id").value.replace(/-/g, ","));
     if(d1>d2){
         document.getElementById("add_date_of_end_id").setCustomValidity("Время начала не может быть позже чем время конца.");
     }else{
         document.getElementById("add_date_of_end_id").setCustomValidity("");
     }

     

     };

    
$(document).ready(function(){
        
    
    $("#add_date_of_start_schedule_id").inputmask("datetime",{
     mask: "y-2-1 h:s", 
     placeholder: "yyyy-mm-dd hh:mm", 
     leapday: "-02-29", 
     separator: "-", 
     alias: "dd-mm-yyyy",
     clearMaskOnLostFocus: true,
     showMaskOnHover: false
});
      
    
    $("table tr").click(function(){
        

        
        const schedule_id_stroke = $(this).find("td").eq(0).html();
        const schedule_course_stroke = $(this).find("td").eq(2).html();
        const schedule_student_stroke = $(this).find("td").eq(4).html();
        const schedule_date_of_start_stroke = $(this).find("td").eq(5).html();
        const schedule_passed = $(this).find("td").eq(7).html();
              

        $("input[name=add_schedule_id]").val(schedule_id_stroke);

        $("#selected_schedule_course_id")[0].value = schedule_course_stroke;

        $("#selected_schedule_student_id")[0].value = schedule_student_stroke;
        
        $("input[name=add_date_of_start_schedule]").val(schedule_date_of_start_stroke);
        
        $("#passed_schedule_id")[0].value = schedule_passed;

        $("#change_schedule_id").prop("disabled" , false);
        $("#change_schedule_id").prop("disabled" , false); 
    });
    
});
    </script>';
}

echo "<table>";
echo "<tr><th style='visibility: hidden'>id</th><th>Тип</th><th>Название курса</th><th>Ф.И.О Преподавателя</th><th>Ф.И.О Студента</th><th>Дата начала</th><th>Дата конца</th><th>Состояние</th></tr>";

function loadScheduleEditor($Schedule)
{
        echo '<form method="post" name="form1" class="form-main">
	<div class="div-form-main">
		<input type="text" name="add_schedule_id" class="box" style = "visibility: hidden; height: 1px">';
        $Schedule->selectedIdCourseSchedule();
        $Schedule->selectedIdStudentSchedule();
        echo '<label for="date_of_start_schedule">Время начала курса</label>
		<input type ="text" id="add_date_of_start_schedule_id" name = "add_date_of_start_schedule" class="box" required><br>
        <label for="passed_check">Состояние</label>
		<select name="passed_schedule" id="passed_schedule_id" class="box" required>
		<option></option>
		<option>Отменен</option>
		<option>Не пройден</option>
		<option>Пройден</option>
		<option>На оплате</option>
		</select>
		<input type="submit" name="add_schedule" value="Добавить" class="button box">
		<input type="submit" id = "change_schedule_id" name="change_schedule" value="Изменить" class="button box" disabled>
		<input type="submit" id = "del_schedule_id" name="del_schedule" value="Удалить" class="button box" disabled formnovalidate>
		<input type="submit" name="search_schedule" value="Поиск" class="button box" formnovalidate>
		

	</div>
</form>';
}

/*if (isset($_POST['search_schedule'])) {
    $val_schedule_id = $_POST['add_schedule_id'];
    $val_schedule_course = $_POST['selected_schedule_course_id'];
    $val_schedule_student = $_POST['selected_schedule_student_id'];
    $val_schedule_date_of_start = $_POST['add_date_of_start_schedule_id'];
    $val_schedule_passed = $_POST['passed_schedule_id'];
    $Schedule->searchSchedule($val_schedule_id, $val_schedule_course, $val_schedule_student, $val_schedule_date_of_start, $val_schedule_passed);
    loadScheduleEditor($Schedule);
    loadScheduleScript();
    return;
}*/

$Schedule->showAllSchedule();

if (isset($_POST['add_schedule'])) {
    $val_schedule_course = $_POST['selected_schedule_course_id'];
    $val_schedule_student = $_POST['selected_schedule_student_id'];
    $val_schedule_date_of_start = $_POST['add_date_of_start_schedule'];
    $val_schedule_passed = $_POST['passed_schedule'];

    if ($val_schedule_passed == 'Ожидание')
    {
        $val_schedule_passed = 0;
    }
    elseif ($val_schedule_passed == 'Отменен')
    {
        $val_schedule_passed = 1;
    }
    elseif ($val_schedule_passed == 'Не пройден')
    {
        $val_schedule_passed = 2;
    }
    elseif ($val_schedule_passed == 'Пройден')
    {
        $val_schedule_passed = 3;
    }
    elseif ($val_schedule_passed == 'На оплате')
    {
        $val_schedule_passed = 4;
    }
    if($Schedule->CheckDate($val_schedule_course, $val_schedule_date_of_start) == 1){
        $Schedule->addSchedule($val_schedule_course, $val_schedule_student, $val_schedule_date_of_start, $val_schedule_passed);
    }else{
        echo '<script> alert("Выбранное время занято либо не входит в график работы школы"); </script>';
    }

}

if (isset($_POST['change_schedule'])) {
    $val_schedule_id = $_POST['add_schedule_id'];
    $val_schedule_course = $_POST['selected_schedule_course_id'];
    $val_schedule_student = $_POST['selected_schedule_student_id'];
    $val_schedule_date_of_start = $_POST['add_date_of_start_schedule'];
    $val_schedule_passed = $_POST['passed_schedule'];

    if ($val_schedule_passed == 'Ожидание')
    {
        $val_schedule_passed = 0;
    }
    elseif ($val_schedule_passed == 'Отменен')
    {
        $val_schedule_passed = 1;
    }
    elseif ($val_schedule_passed == 'Не пройден')
    {
        $val_schedule_passed = 2;
    }
    elseif ($val_schedule_passed == 'Пройден')
    {
        $val_schedule_passed = 3;
    }
    elseif ($val_schedule_passed == 'На оплате')
    {
        $val_schedule_passed = 4;
    }
    if(($Schedule->CheckDateChange($val_schedule_course, $val_schedule_date_of_start, $val_schedule_id)) == 1){
        $Schedule->changeSchedule($val_schedule_id, $val_schedule_course, $val_schedule_student, $val_schedule_date_of_start, $val_schedule_passed);
    }else{
       echo '<script> alert("Выбранное время занято либо не входит в график работы школы"); </script>';
    }

}


if (isset($_POST['del_schedule'])) {
    $val_schedule_course = $_POST['selected_schedule_course_id'];
    $val_schedule_date_of_start = $_POST['add_date_of_start_schedule'];
    $Schedule->CheckDate($val_schedule_course, $val_schedule_date_of_start);
}


loadScheduleEditor($Schedule);
loadScheduleScript();


