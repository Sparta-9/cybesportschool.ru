<?php
$Schedule = new Schedule();
$Roles = new Roles();
$Profile = New Profile();

$val_name = $Profile->TeacherName($_SESSION['user']);

if($Roles->checkRole($_SESSION['user']) == 3) {

    echo "<table>";
    echo "<tr><th>Тип</th><th>Название курса</th><th>Ф.И.О. Преподователя</th><th>Дата начала</th> <th>Дата конца</th><th>Состояние</th></tr>";
    echo "_______________________________________________";
    $Schedule->showStudentSchedule($val_name);
}elseif ($Roles->checkRole($_SESSION['user']) == 2){
    echo "_______________________________________________";
    echo "<table>";
    echo "<tr><th>Тип</th><th>Название курса</th><th>Ф.И.О. Студента</th><th>Дата начала</th> <th>Дата конца</th><th>Состояние</th></tr>";
    $Schedule->showTeacherSchedule($val_name);
}


