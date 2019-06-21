<?php

$Course = new Course();
$Check = new Check();
$Profile = new Profile();
$Roles = new Roles();

$val_user_role = $Roles->checkRole($_SESSION['user']);

$val_user_name = $Profile->TeacherName($_SESSION['user']);



function loadCourseProfileScript()
{
    echo '<script>
$(document).ready(function(){
    $("table tr").click(function(){
        
        const name_stroke = $(this).find("td").eq(1).html();
                   
        $("#selected_course_id")[0].value = name_stroke;

    });
});
    </script>';
}

;

if($val_user_role == '2'){
    echo '____________________________________';
}

echo "<table>";
echo "<tr><th style='visibility: hidden'>ID</th><th>Название курса</th><th>Цена Р.</th><th>Ф.И.О. Преподавателя</th><th>Длительность Ч.</th></tr>";



function loadCourseProfileEditor($Check, $val_user_role)
{
    if($val_user_role == '3') {
        echo ' <form method="post" name="form1" class="form-main">
               <div class="div-form-main">';
        $Check->selectedPersonalIdCourse();
        echo '
                <br><br><input type="submit" name="submit_course" value="Записаться" class="button box">
               </div>
            </form>
	';
    }else{
    }
}

if (isset($_POST['submit_course'])) {
    $val_course = $_POST['selected_course_id'];
    $Course->newSubmit($val_course, $val_user_name);
}

$Course->showStudentCourse();

loadCourseProfileEditor($Check, $val_user_role);
loadCourseProfileScript();
