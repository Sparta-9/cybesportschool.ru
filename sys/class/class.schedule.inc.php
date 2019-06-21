<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../controller/login.php");
    exit();
}

class Schedule extends DB_Connect
{

    public function __construct($dbo = NULL)
    {
        parent::__construct($dbo);
    }

    public function showAllSchedule()
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        foreach ($dbo->query('SELECT * FROM schedule order by -schedule_passed DESC') as $row) {
            echo "<tr class='selected select_name'>";
            echo "<td style='visibility: hidden'>" . $row['schedule_id'] . "</td>";
            echo "<td>" . $row['schedule_type'] . "</td>";
            echo "<td>" . $row['schedule_course_name'] . "</td>";
            echo "<td >" . $row['schedule_teacher_name'] . "</td>";
            echo "<td>" . $row['schedule_student_name'] . "</td>";
            if ($row['schedule_date_of_start'] == '0000-00-00 00:00:00' AND $row['schedule_date_of_end'] == '0000-00-00 00:00:00') {
                echo "<td>Не определена</td>";
                echo "<td>Не определена</td>";
            } else {
                echo "<td>" . $row['schedule_date_of_start'] . "</td>";
                echo "<td>" . $row['schedule_date_of_end'] . "</td>";
            }
            if ($row['schedule_passed'] == '0') {
                echo "<td>Ожидание</td>";
            } elseif ($row['schedule_passed'] == '1') {
                echo "<td>Отменен</td>";
            } elseif ($row['schedule_passed'] == '2') {
                echo "<td>Не пройден</td>";
            } elseif ($row['schedule_passed'] == '3') {
                echo "<td>Пройден</td>";
            } elseif ($row['schedule_passed'] == '4') {
                echo "<td>На оплате</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    public function showTeacherSchedule($val_name)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));

        foreach ($dbo->query("SELECT * FROM schedule WHERE schedule_teacher_name = '$val_name' AND schedule_passed = '2';") as $row) {
            echo "<tr class='selected select_name'>";
            echo "<td style='display: none'>" . $row['schedule_id'] . "</td>";
            echo "<td>" . $row['schedule_type'] . "</td>";
            echo "<td>" . $row['schedule_course_name'] . "</td>";
            echo "<td>" . $row['schedule_student_name'] . "</td>";
            echo "<td>" . $row['schedule_date_of_start'] . "</td>";
            echo "<td>" . $row['schedule_date_of_end'] . "</td>";
            if ($row['schedule_passed'] == '0') {
                echo "<td>Ожидание</td>";
            } elseif ($row['schedule_passed'] == '1') {
                echo "<td>Отменен</td>";
            } elseif ($row['schedule_passed'] == '2') {
                echo "<td>Не пройден</td>";
            } elseif ($row['schedule_passed'] == '3') {
                echo "<td>Пройден</td>";
            } elseif ($row['schedule_passed'] == '4') {
                echo "<td>На оплате</td>";
            }
            echo "</tr>";
        }
        foreach ($dbo->query("SELECT * FROM schedule WHERE schedule_teacher_name = '$val_name' AND schedule_passed = '3';") as $row) {
            echo "<tr class='selected select_name'>";
            echo "<td>" . $row['schedule_type'] . "</td>";
            echo "<td>" . $row['schedule_course_name'] . "</td>";
            echo "<td>" . $row['schedule_student_name'] . "</td>";
            echo "<td>" . $row['schedule_date_of_start'] . "</td>";
            echo "<td>" . $row['schedule_date_of_end'] . "</td>";
            if ($row['schedule_passed'] == '0') {
                echo "<td>Ожидание</td>";
            } elseif ($row['schedule_passed'] == '1') {
                echo "<td>Отменен</td>";
            } elseif ($row['schedule_passed'] == '2') {
                echo "<td>Не пройден</td>";
            } elseif ($row['schedule_passed'] == '3') {
                echo "<td>Пройден</td>";
            } elseif ($row['schedule_passed'] == '4') {
                echo "<td>На оплате</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    public function changeSchedule($val_schedule_id, $val_schedule_course, $val_schedule_student, $val_schedule_date_of_start, $val_schedule_passed)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        foreach ($dbo->query("SELECT Type FROM courses WHERE Name_of_course = '$val_schedule_course'") as $row) {
            $val_type = $row['Type'];
        }
        foreach ($dbo->query("SELECT Teacher_ID FROM courses WHERE Name_of_course = '$val_schedule_course'") as $row) {
            $val_teacher_name = $row['Teacher_ID'];
        }
        foreach ($dbo->query("SELECT Duration FROM courses WHERE Name_of_course = '$val_schedule_course'") as $row) {
            $val_duration = $row['Duration'];
        }
        foreach ($dbo->query("SELECT Cost_of_Course FROM courses WHERE Name_of_course = '$val_schedule_course'") as $row) {
            $val_price = $row['Cost_of_Course'];
        }
        foreach ($dbo->query("SELECT Passed FROM checks WHERE Check_ID = '$val_schedule_id'") as $row) {
            $val_passed = $row['Passed'];
        }
        $val_date_formated = new DateTime($val_schedule_date_of_start);
        $val_date_formated = $val_date_formated->format('Y-m-d H:i');
        $val_duration = '+' . $val_duration . 'hours';
        $val_schedule_date_of_end = date('Y-m-d H:i', strtotime($val_duration, strtotime($val_date_formated)));
        try {
            if($val_passed == 0 or $val_passed == 3) {
                $dbo->exec("UPDATE checks SET Student_id = '" . $val_schedule_student . "', Course_id = '" . $val_schedule_course . "', Date_of_start = '" . $val_schedule_date_of_start . "', Date_of_end = '" . $val_schedule_date_of_end . "', Date_of_check = '" . date('Y-m-d') . "', Price = '" . $val_price . "', Passed = 0 WHERE Check_ID = " . $val_schedule_id . ";");
            }else{
                $dbo->exec("UPDATE checks SET Student_id = '" . $val_schedule_student . "', Course_id = '" . $val_schedule_course . "', Date_of_start = '" . $val_schedule_date_of_start . "', Date_of_end = '" . $val_schedule_date_of_end . "', Date_of_check = '" . date('Y-m-d') . "', Price = '" . $val_price . "' WHERE Check_ID = " . $val_schedule_id . ";");
            }
            $dbo->exec("UPDATE schedule SET schedule_type = '" . $val_type . "', schedule_course_name = '" . $val_schedule_course . "', schedule_teacher_name = '" . $val_teacher_name . "', schedule_student_name = '" . $val_schedule_student . "', schedule_date_of_start = '" . $val_schedule_date_of_start . "', schedule_date_of_end = '" . $val_schedule_date_of_end . "', schedule_passed = '" . $val_schedule_passed . "' WHERE schedule_id = " . $val_schedule_id . ";");
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
            exit();
        }
        echo "
<!DOCTYPE html>
<script>
function redir()
{

window.location.assign('controlpanel.php');
}
</script>
<body onload='redir();'></body>";
    }

    public function showStudentSchedule($val_name)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));

        foreach ($dbo->query("SELECT * FROM schedule WHERE schedule_student_name = '$val_name' AND schedule_passed = 2;") as $row) {
            echo "<tr class='selected select_name'>";
            echo "<td>" . $row['schedule_type'] . "</td>";
            echo "<td>" . $row['schedule_course_name'] . "</td>";
            echo "<td>" . $row['schedule_teacher_name'] . "</td>";
            echo "<td>" . $row['schedule_date_of_start'] . "</td>";
            echo "<td>" . $row['schedule_date_of_end'] . "</td>";
            if ($row['schedule_passed'] == '0') {
                echo "<td>Ожидание</td>";
            } elseif ($row['schedule_passed'] == '1') {
                echo "<td>Отменен</td>";
            } elseif ($row['schedule_passed'] == '2') {
                echo "<td>Не пройден</td>";
            } elseif ($row['schedule_passed'] == '3') {
                echo "<td>Пройден</td>";
            }
            echo "</tr>";
        }
        foreach ($dbo->query("SELECT * FROM schedule WHERE schedule_student_name = '$val_name' AND schedule_passed = 3;") as $row) {
            echo "<tr class='selected select_name'>";
            echo "<td>" . $row['schedule_type'] . "</td>";
            echo "<td>" . $row['schedule_course_name'] . "</td>";
            echo "<td>" . $row['schedule_teacher_name'] . "</td>";
            echo "<td>" . $row['schedule_date_of_start'] . "</td>";
            echo "<td>" . $row['schedule_date_of_end'] . "</td>";
            if ($row['schedule_passed'] == '0') {
                echo "<td>Ожидание</td>";
            } elseif ($row['schedule_passed'] == '1') {
                echo "<td>Отменен</td>";
            } elseif ($row['schedule_passed'] == '2') {
                echo "<td>Не пройден</td>";
            } elseif ($row['schedule_passed'] == '3') {
                echo "<td>Пройден</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    public function addSchedule($val_schedule_course, $val_schedule_student, $val_schedule_date_of_start, $val_schedule_passed)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        try {
            foreach ($dbo->query("SELECT Type FROM courses WHERE Name_of_course = '$val_schedule_course'") as $row) {
                $val_type = $row['Type'];
            }
            foreach ($dbo->query("SELECT Teacher_ID FROM courses WHERE Name_of_course = '$val_schedule_course'") as $row) {
                $val_teacher_name = $row['Teacher_ID'];
            }
            foreach ($dbo->query("SELECT Duration FROM courses WHERE Name_of_course = '$val_schedule_course'") as $row) {
                $val_duration = $row['Duration'];
            }
            foreach ($dbo->query("SELECT Cost_of_Course FROM courses WHERE Name_of_course = '$val_schedule_course'") as $row) {
                $val_price = $row['Cost_of_Course'];
            }
            $val_date_formated = new DateTime($val_schedule_date_of_start);
            $val_date_formated = $val_date_formated->format('Y-m-d H:i');
            $val_duration = '+' . $val_duration . 'hours';
            $val_schedule_date_of_end = date('Y-m-d H:i', strtotime($val_duration, strtotime($val_date_formated)));
            $stmt = $dbo->prepare("INSERT INTO checks (Student_ID, Course_ID, Date_of_start, Date_of_end, Date_of_check, Price, Passed) VALUES (?,?,?,?,?,?,?)");
            $stmt->execute(array($val_schedule_student, $val_schedule_course, $val_schedule_date_of_start, $val_schedule_date_of_end, date('Y-m-d'), $val_price, 0));
            $stmt = $dbo->prepare("INSERT INTO schedule (schedule_type, schedule_course_name, schedule_teacher_name, schedule_student_name, schedule_date_of_start, schedule_date_of_end, schedule_passed) VALUES (?,?,?,?,?,?,?)");
            $stmt->execute(array($val_type, $val_schedule_course, $val_teacher_name, $val_schedule_student, $val_schedule_date_of_start, $val_schedule_date_of_end, $val_schedule_passed));
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
            exit();
        }
        echo '<!DOCTYPE html>
<script>
function redir()
{
window.location.assign(\'controlpanel.php\');
}
</script>
<body onload=\'redir();\'></body>';
    }


    public function passedCheck($val_check_id, $val_passed)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        try {
            $dbo->exec("UPDATE checks SET Passed = '" . $val_passed . "' WHERE Check_ID = " . $val_check_id . ";");

        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
            exit();
        }
        echo '<!DOCTYPE html>
                <script>
                function redir()
                {
                window.location.assign(\'index.php\');
                }
                </script>
                <body onload=\'redir();\'></body>';
    }

    public function selectedIdStudentSchedule()
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        echo "<label for='selected_student_id'>Ф.И.О. Студента</label>";
        echo "<select id = 'selected_schedule_student_id' name='selected_schedule_student_id' class='box' required>";
        echo "<option></option>";
        foreach ($dbo->query('SELECT Name FROM student') as $row) {
            echo "<option>" . $row['Name'] . "</option>";
        }
        echo "</select>";
    }

    public function selectedIdCourseSchedule()
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        echo "<label for='selected_course_id'>Название курса</label>";
        echo "<select id = 'selected_schedule_course_id' name='selected_schedule_course_id' class='box' required>";
        echo "<option></option>";
        foreach ($dbo->query('SELECT Name_of_course FROM courses') as $row) {
            echo "<option>" . $row['Name_of_course'] . "</option>";
        }
        echo "</select>";
    }

    public function delSchedule($val_schedule_id)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        try {
            $dbo->exec('DELETE FROM schedule WHERE schedule_id =' . $val_schedule_id);
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
            exit();
        }
        echo '<!DOCTYPE html>
<script>
function redir()
{
window.location.assign(\'controlpanel.php\');
}
</script>
<body onload=\'redir();\'></body>';
    }

    public function searchCheck($val_check_id, $val_student_id, $val_course_number, $val_date_of_start, $val_date_of_end, $val_date_of_check, $val_passed)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        foreach ($dbo->query("SELECT * FROM checks WHERE Check_ID LIKE '%" . $val_check_id . "' AND Student_id LIKE '%" . $val_student_id . "%' AND Course_id LIKE '%" . $val_course_number . "%' AND Date_of_start LIKE '%" . $val_date_of_start . "%' AND Date_of_end LIKE '%" . $val_date_of_end . "%' AND Date_of_check LIKE '%" . $val_date_of_check . "%' AND Passed = '%" . $val_passed . "%';") as $row) {
            echo "<tr class='selected select_name'>";
            echo "<td>" . $row['Check_ID'] . "</td>";
            echo "<td>" . $row['Student_id'] . "</td>";
            echo "<td>" . $row['Course_id'] . "</td>";
            echo "<td >" . $row['Date_of_start'] . "</td>";
            echo "<td width='100'>" . $row['Date_of_end'] . "</td>";
            echo "<td width='100'>" . $row['Date_of_check'] . "</td>";
            echo "<td width='100'>" . $row['Price'] . ".</td>";
            if ($row['Passed'] == '0') {
                echo "<td>Нет</td>";
            }
            if ($row['Passed'] == '1') {
                echo "<td>Да</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

    }

    public function CheckDate($val_schedule_course, $val_schedule_date_of_start)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        foreach ($dbo->query("SELECT Teacher_ID FROM courses WHERE Name_of_course = '$val_schedule_course'") as $row) {
            $val_teacher_name = $row['Teacher_ID'];
        }
        foreach ($dbo->query("SELECT Duration FROM courses WHERE Name_of_course = '$val_schedule_course'") as $row) {
            $val_duration = $row['Duration'];
        }

        $val_date_formated = new DateTime($val_schedule_date_of_start);
        $val_date_formated_days = $val_date_formated->format('Y-m-d');
        $val_date_formated_hours = $val_date_formated->format('H:i');
        $val_date_formated = $val_date_formated->format('Y-m-d H:i');
        $val_duration = '+' . $val_duration . 'hours';
        $val_schedule_date_of_end = date('Y-m-d H:i', strtotime($val_duration, strtotime($val_date_formated)));
        $val_date_of_end_check = date('Y-m-d', strtotime($val_schedule_date_of_end));
        $val_schedule_date_of_end_hours = date('H:i', strtotime($val_duration, strtotime($val_date_formated_hours)));
        $val_check_up = date('22:00');
        $val_check_down = date('08:00');
        $val_busy = 0;
        foreach ($dbo->query("SELECT * FROM schedule WHERE schedule_date_of_start >= '$val_schedule_date_of_start' AND schedule_date_of_end <=  '$val_schedule_date_of_end' AND schedule_teacher_name = '$val_teacher_name' AND schedule_passed != 1") as $row) {
            $val_busy = $val_busy + 1;
        }
        if (($val_schedule_date_of_end_hours > $val_check_up) OR ($val_date_formated_hours < $val_check_down) OR ($val_date_of_end_check > $val_date_formated_days) OR $val_busy != 0) {
            $val_return = 0;
        } else {
            $val_return = 1;
        }

        return $val_return;
    }

    public function CheckDateChange($val_schedule_course, $val_schedule_date_of_start, $val_schedule_id)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        foreach ($dbo->query("SELECT Teacher_ID FROM courses WHERE Name_of_course = '$val_schedule_course'") as $row) {
            $val_teacher_name = $row['Teacher_ID'];
        }
        foreach ($dbo->query("SELECT Duration FROM courses WHERE Name_of_course = '$val_schedule_course'") as $row) {
            $val_duration = $row['Duration'];
        }
        $val_date_formated = new DateTime($val_schedule_date_of_start);
        $val_date_formated_days = $val_date_formated->format('Y-m-d');
        $val_date_formated_hours = $val_date_formated->format('H:i');
        $val_date_formated = $val_date_formated->format('Y-m-d H:i');
        $val_duration = '+' . $val_duration . 'hours';
        $val_schedule_date_of_end = date('Y-m-d H:i', strtotime($val_duration, strtotime($val_date_formated)));
        $val_date_of_end_check = date('Y-m-d', strtotime($val_schedule_date_of_end));
        $val_schedule_date_of_end_hours = date('H:i', strtotime($val_duration, strtotime($val_date_formated_hours)));
        $val_check_up = date('22:00');
        $val_check_down = date('08:00');
        $val_busy = 0;
        foreach ($dbo->query("SELECT * FROM schedule WHERE schedule_date_of_start >= '$val_schedule_date_of_start' AND schedule_date_of_end <=  '$val_schedule_date_of_end' AND schedule_teacher_name = '$val_teacher_name' AND schedule_passed != 1") as $row) {
            $val_busy = $val_busy + 1;
        }
        foreach ($dbo->query("SELECT schedule_date_of_start, schedule_course_name  FROM schedule WHERE schedule_id = '$val_schedule_id'") as $row) {
            $val_change_date_of_start = $row['schedule_date_of_start'];
            $val_change_course_name = $row['schedule_course_name'];
        }
        $val_change_course_name = strcmp($val_change_course_name, $val_schedule_course);
        $val_change_date_of_start = New DateTime($val_change_date_of_start);
        $val_change_date_of_start = $val_change_date_of_start->format('Y-m-d H:i');
        if ($val_change_date_of_start != $val_schedule_date_of_start){
            $val_bool = 1;
        }else{
            $val_bool = 0;
        }
        if (($val_bool == 1) OR ($val_change_course_name != 0)) {
            if (($val_schedule_date_of_end_hours > $val_check_up) OR ($val_date_formated_hours < $val_check_down) OR ($val_date_of_end_check > $val_date_formated_days) OR $val_busy > 0) {
                $val_return = 0;
            } else {
                $val_return = 1;
            }
        }else{
            $val_return = 1;
        }
        return $val_return;
    }

    public function countSubmits(){
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        $val_count = 0;
        foreach ($dbo->query("SELECT * FROM schedule WHERE schedule_passed = 0") as $row) {
            $val_count = $val_count +1;
        }
        return $val_count;
    }

}

