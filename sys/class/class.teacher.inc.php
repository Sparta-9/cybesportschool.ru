<?php
if (!isset($_SESSION['user'])) {
    header("Location: ../controller/login.php");
    exit();
}

class Teacher extends DB_Connect
{

    function translit($s) {
        $s = (string) $s; 
        $s = strip_tags($s); 
        $s = str_replace(array("\n", "\r"), " ", $s); 
        $s = preg_replace("/\s+/", ' ', $s); 
        $s = trim($s); 
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); 
        $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
        $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); 
        $s = str_replace(" ", "", $s); 
        return $s;
    }

    function generator() {
        $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";

        $password = null;

        $max=8;

        while($max--) {
            $password .= $chars[rand(0, 61)];

        }
        return($password);
    }

    public function __construct($dbo = NULL)
    {

        parent::__construct($dbo);

    }

    public function showAllTeacher()
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        foreach ($dbo->query('SELECT * FROM teacher') as $row) {
            echo "<tr class='selected select_name'>";
            echo "<td style='visibility: hidden'>" . $row['Full_Name'] . "</td>";
            echo "<td>" . $row['Teacher_ID'] . "</td>";
            echo "<td>" . $row['Spec'] . "</td>";
            echo "<td>" . $row['Address'] . "</td>";
            echo "<td>" . $row['Phone_Number'] . "</td>";
            echo "<td>" . $row['Teacher_Email'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    public function addTeacher($teacher_name, $teacher_spec, $address_teacher, $phone_teacher, $val_login, $val_password, $val_email)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        try {
            $stmt = $dbo->prepare("INSERT INTO teacher (teacher_ID, Spec, Address, Phone_Number, Teacher_Email) VALUES (?,?,?,?,?)");
            $stmt->execute(array($teacher_name, $teacher_spec, $address_teacher, $phone_teacher, $val_email));
            $asap = $dbo->prepare("INSERT INTO users (user_role, user_name, user_login, user_password, user_email, user_disabled) VALUES (?,?,?,?,?,?)");
            $asap->execute(array( 2, $teacher_name, $val_login, $val_password, $val_email, 0));

        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
            exit();
        }
        echo  '
<!DOCTYPE html>
<script>
function redir()
{
alert("Логин пользователя:', $val_login. ' Пароль пользователя:', $val_password. ' Дайте пользователю сфотографировать экран или сообщите ему его по телефону ");
window.location.assign("index.php");
}
</script>
<body onload="redir();"></body>';
    }

    public function delTeacher($teacher_id)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        try {
            $dbo->exec('DELETE FROM teacher WHERE Full_Name=' . $teacher_id);
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
            exit();
        }
        echo  "
<!DOCTYPE html>
<script>
function redir()
{
window.location.assign('index.php');
}
</script>
<body onload='redir();'></body>";
    }

    public function changeTeacher($val_id, $val_name, $val_spec, $val_address, $val_phone, $val_email)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        try {
            $dbo->exec("UPDATE teacher SET Teacher_ID = '" . $val_name . "', Spec = '" . $val_spec . "', Address = '" . $val_address . "', Phone_Number = '" . $val_phone . "', Teacher_Email = '" . $val_email . "' WHERE Full_Name = " . $val_id . ";");
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
            exit();
        }
        echo "
<!DOCTYPE html>
<script>
function redir()
{
window.location.assign('index.php');
}
</script>
<body onload='redir();'></body>";

    }


    public function searchTeacher($val_id, $val_name, $val_spec, $val_address, $val_phone, $val_email)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        foreach ($dbo->query("SELECT * FROM teacher WHERE Full_Name LIKE '%" . $val_id . "' AND Teacher_Email LIKE '%" . $val_email . "%' AND Teacher_ID LIKE '%" . $val_name . "%' AND Spec LIKE '%" . $val_spec . "%' AND Address LIKE '%" . $val_address . "%' AND Phone_Number LIKE '%" . $val_phone . "%';") as $row) {
            echo "<tr class='selected select_name'>";
            echo "<td style='visibility: hidden'>" . $row['Full_Name'] . "</td>";
            echo "<td>" . $row['Teacher_ID'] . "</td>";
            echo "<td>" . $row['Spec'] . "</td>";
            echo "<td>" . $row['Address'] . "</td>";
            echo "<td>" . $row['Phone_Number'] . "</td>";
            echo "<td>" . $row['Teacher_Email'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

}

?>