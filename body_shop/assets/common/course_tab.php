<?php
$course = new Course();
$Roles = new Roles();
$Check = new Check();

function loadCourseScript()
{
    echo '<script>
$(document).ready(function(){
    
    $("#add_cost_of_course_id").inputmask({mask: "9{1,5}.9{2}", showMaskOnHover: false
        });
        
    $("#add_name_of_course_id").inputmask({mask: "Aa{1,10} a{0,10} a{0,10}", showMaskOnHover: false
        });
    $("#course_duration_id").inputmask({mask: "9{1,2}", showMaskOnHover: false
        });
    
    $("table tr").click(function(){
        const course_id_stroke = $(this).find("td").eq(0).html();
        const name_stroke = $(this).find("td").eq(1).html();
        const type_stroke = $(this).find("td").eq(2).html();
        const cost_stroke = $(this).find("td").eq(3).html();
        const teacher_name_stroke = $(this).find("td").eq(4).html();
        const duration_stroke = $(this).find("td").eq(5).html();

        $("input[name=add_course_id]").val(course_id_stroke);

        $("input[name=add_name_of_course]").val(name_stroke);

        $("#type_of_course_id")[0].value = type_stroke;
        
        $("input[name=add_cost_of_course]").val(cost_stroke);
        
        $("input[name=course_duration]").val(duration_stroke);

        $("#teacher_name")[0].value = teacher_name_stroke;
        
        $("#selected_course_id")[0].value = name_stroke;
        
        $("#change_course_id").prop("disabled" , false); 
        $("#del_course_id").prop("disabled" , false); 

    });
});
    </script>';
}

;

echo "<table>";
echo "<tr><th style='visibility: hidden'>ID</th><th>Название курса</th><th>Тип</th><th>Цена Р.</th><th>Ф.И.О. Преподавателя</th><th>Длительность Ч.</th></tr>";

function loadCourseEditor($course, $Roles, $Check)
{
    if ($Roles->checkRole($_SESSION['user']) == 1) {

        echo ' <form method="post" name="form1" class="form-main">
	<div class="div-form-main">
		<input style="visibility: hidden; height: 1px" type="text" name="add_course_id" class="box"><br>
		<label for="add_name_of_course">Название курса</label>
		<input type="text" id = "add_name_of_course_id" name="add_name_of_course" class="box" required><br>
		<label for="type_of_course">Тип</label>
		<select class = "box" for = "type_of_course" name = "type_of_course" id = "type_of_course_id">
		        <option></option>
		        <option>Персональный</option>
		        <option>Командный</option>
        </select>
		<label for="add_cost_of_course">Цена курса</label>
		<input type="text" id = "add_cost_of_course_id" name="add_cost_of_course" class="box" required><br>
		<label for="course_duration">Длительность</label>
		<input type="text" id = "course_duration_id" name="course_duration" class="box" required><br>';
        $course->selectedTeacherId();
        echo '<input type="submit" name="add_course" value="Добавить" class="button box">
		<input type="submit" id = "change_course_id" name="change_course" value="Изменить" class="button box" disabled>
		<input type="submit" id = "del_course_id" name="del_course" value="Удалить" class="button box" formnovalidate disabled>
		<input type="submit" name="search_course" value="Поиск" class="button box" formnovalidate>
		

        </div>
</form>';
    }
        if($Roles->checkRole($_SESSION['user']) == 3){
            echo ' <form method="post" name="form1" class="form-main">
	<div class="div-form-main">', $Check->selectedIdCourse(); '
    <input type="submit" name="add_course" value="Записаться" class="button box">
        </div>
</form>
	';
        }
}
if(isset($_POST['search_course'])) {
    $val_Name_of_course = $_POST['add_name_of_course'];
    $val_type_of_course = $_POST['type_of_course'];
    $val_Cost_of_course = $_POST['add_cost_of_course'];
    $val_Cost_of_course = round($val_Cost_of_course, 2);
    $val_Teacher_ID = $_POST['teacher_name'];
    $val_duration = $_POST['course_duration'];
    $course->searchCourse($val_Name_of_course, $val_type_of_course, $val_Cost_of_course, $val_Teacher_ID, $val_duration);
    loadCourseScript();
    loadCourseEditor($course, $Roles, $Check);
    return;
}

$course->showAllCourse();

if (isset($_POST['add_course'])) {
    $val_Name_of_course = $_POST['add_name_of_course'];
    $val_type_of_course = $_POST['type_of_course'];
    $val_Cost_of_course = $_POST['add_cost_of_course'];
    $val_Cost_of_course = round($val_Cost_of_course, 2);
    $val_Teacher_ID = $_POST['teacher_name'];
    $val_duration = $_POST['course_duration'];
    $course->addCourse($val_Name_of_course, $val_type_of_course, $val_Cost_of_course, $val_Teacher_ID, $val_duration);
}

if (isset($_POST['change_course'])) {
    $val_Course_ID = $_POST['add_course_id'];
    $val_Name_of_course = $_POST['add_name_of_course'];
    $val_type_of_course = $_POST['type_of_course'];
    $val_Cost_of_course = $_POST['add_cost_of_course'];
    $val_Cost_of_course = round($val_Cost_of_course, 2);
    $val_Teacher_ID = $_POST['teacher_name'];
    $val_duration = $_POST['course_duration'];
    $course->changeCourse($val_Course_ID, $val_Name_of_course, $val_type_of_course, $val_Cost_of_course, $val_Teacher_ID, $val_duration);
}

if (isset($_POST['del_course'])) {
    $val_Course_ID = $_POST['add_course_id'];
    $course->delCourse($val_Course_ID);
}

loadCourseEditor($course, $Roles, $Check);
loadCourseScript();


?>
