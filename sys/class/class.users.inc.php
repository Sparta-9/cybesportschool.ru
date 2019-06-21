<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: ../controller/login.php");
    exit();
}
?>
<?php
include_once '../sys/config/db-cred.inc.php';
include_once "../sys/core/init.inc.php";

class Users extends DB_Connect{

    public function __construct($dbo = NULL) {
        parent::__construct($dbo);
    }

    function generatorPass() {
        $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";

        $password = null;

        $max=8;

        while($max--) {
            $password .= $chars[rand(0, 61)];

        }
        return($password);
    }

    public function showAllUsers(){
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
        foreach($dbo->query('SELECT * FROM users') as $row) {
            echo "<tr class='selected select_name'>";
            echo "<td style='visibility: hidden' >".$row['user_id']."</td>";
            if($row['user_role'] == '1'){
                echo "<td>Администратор</td>";
            }
            if($row['user_role'] == '2'){
                echo "<td>Преподаватель</td>";
            }
            if($row['user_role'] == '3'){
                echo "<td>Студент</td>";
            }
            echo "<td>".$row['user_name']."</td>";
            echo "<td>".$row['user_login']."</td>";
            echo "<td>".$row['user_email']."</td>";
            echo "<td>".$row['user_disabled']. "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    public function searchUsers($val_user_role, $val_user_name, $val_user_login, $val_user_password, $val_user_email){
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
        foreach($dbo->query("SELECT * FROM users WHERE  user_role LIKE '%".$val_user_role."%' AND user_name LIKE '%".$val_user_name."%' AND user_login LIKE '%".$val_user_login."%' AND user_password LIKE '%".$val_user_password."%' AND user_email LIKE '%".$val_user_email."%';") as $row) {
            echo "<tr class='selected select_name'>";
            echo "<td style='visibility: hidden'>".$row['user_id']."</td>";
            if($row['user_role'] == '1'){
                echo "<td>Администратор</td>";
            }
            if($row['user_role'] == '2'){
                echo "<td>Преподаватель</td>";
            }
            if($row['user_role'] == '3'){
                echo "<td>Студент</td>";
            }
            echo "<td>".$row['user_name']."</td>";
            echo "<td>".$row['user_login']."</td>";
            echo "<td>".$row['user_password']."</td>";
            echo "<td>".$row['user_email']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    public function disableUser($val_user_id){
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
        try{
            foreach($dbo->query('SELECT user_disabled FROM users WHERE user_id = '.$val_user_id) as $row) {
                $val_disabled = $row['user_disabled'];
            }
            if ($val_disabled == 1){
                $val_disabled = 0;
            }else{
                $val_disabled = 1;
            }
            $dbo->exec("UPDATE users SET user_disabled = '".$val_disabled."' WHERE user_id = ".$val_user_id.";");
        } catch (PDOException $e){
            echo 'Error : '.$e->getMessage();
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

    public function resetUser($val_user_id){
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
        $val_password = $this->generatorPass();
        foreach($dbo->query('SELECT user_name FROM users WHERE user_id = '.$val_user_id) as $row) {
            $val_name = $row['user_name'];
        }
        try{

            $dbo->exec("UPDATE users SET user_password = '".$val_password."' WHERE user_id = ".$val_user_id.";");
        } catch (PDOException $e){
            echo 'Error : '.$e->getMessage();
            exit();
        }
        echo "
<!DOCTYPE html>
<script>
function redir()
{
alert('Новый пароль пользователя:", $val_name. ".   Теперь: ", $val_password. ".   Дайте пользователю сфотографировать экран или сообщите ему лично');
window.location.assign('controlpanel.php');
}
</script>
<body onload='redir();'></body>";
    }

    public function disabledUser($user_login){
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
        $val_count = 0;
        foreach($dbo->query("SELECT * FROM users WHERE user_disabled = '1' AND user_login = '$user_login' ;") as $row) {
            $val_count = $val_count + 1;
        }
        return $val_count;
    }

}
