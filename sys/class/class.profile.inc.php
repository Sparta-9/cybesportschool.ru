<?php
if (!isset($_SESSION['user'])) {
    header("Location: ../controller/login.php");
    exit();
}

class Profile extends DB_Connect
{
    public function __construct($dbo = NULL)
    {
        parent::__construct($dbo);
    }

    public function StudentNickname($val_user_login)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        foreach ($dbo->query("SELECT user_name FROM users WHERE user_login = '$val_user_login'") as $row) {
            $val_student_name = $row['user_name'];
        }
        foreach ($dbo->query("SELECT Nickname FROM Student WHERE Name = '$val_student_name'") as $row) {
            return $row['Nickname'];
        }

    }


    public function TeacherName($val_user_login)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        foreach ($dbo->query("SELECT user_name FROM users WHERE user_login = '$val_user_login'") as $row) {
            return $row['user_name'];
        }

    }

    public function GetPass($val_login){
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        foreach ($dbo->query("SELECT user_password FROM users WHERE user_login = '$val_login' limit 1") as $row) {
            return $row['user_password'];
        }
    }

    public function changeAccount($val_password, $val_login, $val_user_name){
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
        try{
            $dbo->exec("UPDATE users SET user_login  = '".$val_login."', user_password = '".$val_password."' WHERE user_name = '$val_user_name';");
        } catch (PDOException $e){
            echo 'Error : '.$e->getMessage();
            exit();
        }

        echo '<!DOCTYPE html>
<script>
function redir()
{
    alert("После смены логина/пароля вам нужно авторизоваться заного, после нажатия кнопки ОК вас вёрнёт на страницу авторзации!");
    window.location.assign(\'logout.php\');
}
</script>
<body onload=\'redir();\'></body>';
    }

    public function countOfCoursesStudent($val_name){
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        $val_count = 0;
        foreach ($dbo->query("SELECT * FROM schedule WHERE schedule_student_name = '$val_name' AND schedule_passed = 2") as $row) {
            $val_count = $val_count +1;
        }
        return $val_count;
    }

    public function countOfCoursesTeacher($val_name){
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        $val_count = 0;
        foreach ($dbo->query("SELECT * FROM schedule WHERE schedule_teacher_name = '$val_name' AND schedule_passed = 2") as $row) {
            $val_count = $val_count +1;
        }
        return $val_count;
    }

    public function countOfChecks($val_name){
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        $val_count = 0;
        foreach ($dbo->query("SELECT * FROM checks WHERE Student_ID = '$val_name' AND Passed = 0") as $row) {
            $val_count = $val_count +1;
        }
        return $val_count;
    }


    public function showTeams($val_user_name)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        foreach ($dbo->query("SELECT * FROM teams WHERE first_player = '$val_user_name' OR second_player = '$val_user_name' OR  third_player = '$val_user_name' OR fourth_player = '$val_user_name' OR fifth_player = '$val_user_name' OR  team_teacher = '$val_user_name'") as $row) {
            echo "<tr class='selected select_name'>";
            echo "<td style='visibility: hidden' >" . $row['team_id'] . "</td>";
            echo "<td>" . $row['team_spec'] . "</td>";
            echo "<td>" . $row['team_name'] . "</td>";
            echo "<td>" . $row['team_teacher'] . "</td>";
            echo "<td>" . $row['first_player'] . "</td>";
            echo "<td>" . $row['second_player'] . "</td>";
            echo "<td>" . $row['third_player'] . "</td>";
            echo "<td>" . $row['fourth_player'] . "</td>";
            echo "<td>" . $row['fifth_player'] . "</td>";
            echo "<td>" . $row['team_win'] . "</td>";
            echo "<td>" . $row['team_lose'] . "</td>";
            echo "<td>" . $row['winrate'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}