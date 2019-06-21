<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../controller/login.php");
    exit();
}

class Check extends DB_Connect
{

    public function __construct($dbo = NULL)
    {
        parent::__construct($dbo);
    }

    public function showAllChecks()
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        foreach ($dbo->query('SELECT * FROM checks WHERE Passed != 3') as $row) {
            echo "<tr class='selected select_name'>";
            echo "<td>" . $row['Check_ID'] . "</td>";
            echo "<td>" . $row['Student_id'] . "</td>";
            echo "<td>" . $row['Course_id'] . "</td>";
            echo "<td >" . $row['Date_of_start'] . "</td>";
            echo "<td>" . $row['Date_of_end'] . "</td>";
            echo "<td>" . $row['Date_of_check'] . "</td>";
            echo "<td>" . $row['Price'] . "</td>";
            if($row['Passed'] == '0'){
                echo "<td>Нет</td>";
            }
            if($row['Passed'] == '1'){
                echo "<td>Да</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    public function showPersonalChecks($user_name)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));

        echo "<table>";
        echo "<tr><th>Название курса</th><th>Дата начала</th><th>Дата конца</th><th>Дата чека</th><th>Цена Р.</th><th>Оплачена</th></tr>";
        foreach ($dbo->query("SELECT * FROM checks WHERE Student_ID = '$user_name' AND Passed != 3") as $row) {
            echo "<tr class='selected select_name'>";
            echo "<td>" . $row['Course_id'] . "</td>";
            echo "<td >" . $row['Date_of_start'] . "</td>";
            echo "<td>" . $row['Date_of_end'] . "</td>";
            echo "<td>" . $row['Date_of_check'] . "</td>";
            echo "<td>" . $row['Price'] . "</td>";
            if($row['Passed'] == '0'){
                echo "<td>Нет</td>";
            }
            if($row['Passed'] == '1'){
                echo "<td>Да</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }

    public function addCheck($val_check_id, $val_student_id, $val_course_number, $val_date_of_start, $val_date_of_end, $val_date_of_check, $val_passed)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        try {
            foreach ($dbo->query("SELECT Cost_of_course FROM courses WHERE Name_of_course = '$val_course_number'") as $row) {
                $val_price = $row['Cost_of_course'];
            }
            $stmt = $dbo->prepare("INSERT INTO checks (Check_ID, Student_ID, Course_ID, Date_of_start, Date_of_end, Date_of_check, Price, Passed) VALUES (?,?,?,?,?,?,?,?)");
            $stmt->execute(array($val_check_id, $val_student_id, $val_course_number, $val_date_of_start, $val_date_of_end, $val_date_of_check, $val_price, $val_passed));
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

    public function passedCheck($val_check_id)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        try {
            foreach ($dbo->query("SELECT Passed FROM checks WHERE  Check_ID = " .$val_check_id) as $row) {
                $val_passed = $row['Passed'];
            }
            foreach ($dbo->query("SELECT schedule_passed FROM schedule WHERE  schedule_id = " .$val_check_id) as $row) {
                $val_passed_schedule = $row['schedule_passed'];
            }
            if ($val_passed == 1){
                $val_passed = 0;
            }else{
                $val_passed = 1;
            }
            $dbo->exec("UPDATE checks SET Passed = '" . $val_passed . "' WHERE Check_ID = " . $val_check_id . ";");
            if($val_passed_schedule == '4') {
                $dbo->exec("UPDATE schedule SET schedule_passed = 2 WHERE schedule_id = " . $val_check_id . ";");
            }
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

    public function selectedIdStudent()
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        echo "<label for='selected_student_id'>Ф.И.О. Студента</label>";
        echo "<select id = 'selected_student_id' name='selected_student_id' class='box' required>";
        echo "<option></option>";
        foreach ($dbo->query('SELECT Name FROM student') as $row) {
            echo "<option>" . $row['Name'] . "</option>";
        }
        echo "</select>";
    }

    public function selectedIdCourse()
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        echo "<label for='selected_course_id'>Название курса</label>";
        echo "<select id = 'selected_course_id' name='selected_course_id' class='box' required>";
        echo "<option></option>";
        foreach ($dbo->query('SELECT Name_of_course FROM courses') as $row) {
            echo "<option>" . $row['Name_of_course'] . "</option>";
        }
        echo "</select>";
    }

    public function selectedPersonalIdCourse()
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        echo "<label for='selected_course_id'>Название курса</label>";
        echo "<select id = 'selected_course_id' name='selected_course_id' class='box' required>";
        echo "<option></option>";
        foreach ($dbo->query('SELECT Name_of_course FROM courses WHERE Type = "Персональный"') as $row) {
            echo "<option>" . $row['Name_of_course'] . "</option>";
        }
        echo "</select>";
    }

    public function delCheck($val_check_id)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        try {
            $dbo->exec('DELETE FROM checks WHERE Check_ID=' . $val_check_id);
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
            if($row['Passed'] == '0'){
                echo "<td>Нет</td>";
            }
            if($row['Passed'] == '1'){
                echo "<td>Да</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

    }

}

