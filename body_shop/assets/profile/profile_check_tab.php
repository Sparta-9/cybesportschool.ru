<?php
$Check = new Check();
$Profile = new Profile();
$Role = new Roles();



if ($Role->checkRole($_SESSION['user']) == '3') {

    $Check->showPersonalChecks($Profile->TeacherName($_SESSION['user']));

};