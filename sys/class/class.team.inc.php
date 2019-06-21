<?php
if(!isset($_SESSION['user'])){
    header("Location: ../controller/login.php");
    exit();
}
?>
<?php
include_once '../sys/config/db-cred.inc.php';
include_once "../sys/core/init.inc.php";

class Team extends DB_Connect {

    public function __construct($dbo = NULL) {
        parent::__construct($dbo);
    }

    public function showAllTeams(){
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
        foreach($dbo->query('SELECT * FROM teams') as $row) {
            echo "<tr class='selected select_name'>";
            echo "<td style='visibility: hidden'>".$row['team_id']."</td>";
            echo "<td>".$row['team_spec']."</td>";
            echo "<td>".$row['team_name']."</td>";
            echo "<td>".$row['team_teacher']."</td>";
            echo "<td>".$row['first_player']."</td>";
            echo "<td>".$row['second_player']."</td>";
            echo "<td>".$row['third_player']."</td>";
            echo "<td>".$row['fourth_player']."</td>";
            echo "<td>".$row['fifth_player']."</td>";
            echo "<td>".$row['team_win']."</td>";
            echo "<td>".$row['team_lose']."</td>";
            echo "<td>".$row['winrate']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    }


    public function addTeam($val_team_name,$val_teacher_name, $val_first_player, $val_second_player, $val_third_player, $val_fourth_player, $val_fifth_player, $val_win, $val_lose, $val_winrate){
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
        try {
            foreach($dbo->query("SELECT Spec FROM teacher WHERE Teacher_ID = '$val_teacher_name'") as $row) {
                $val_team_spec =  $row['Spec'];
            }
            $stmt = $dbo->prepare("INSERT INTO teams (team_spec, team_name, team_teacher, first_player, second_player, third_player, fourth_player, fifth_player, team_win, team_lose, winrate) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            $stmt -> execute(array($val_team_spec, $val_team_name,$val_teacher_name, $val_first_player, $val_second_player, $val_third_player, $val_fourth_player, $val_fifth_player, $val_win, $val_lose, $val_winrate));
        } catch(PDOException $e){
            echo 'Error : '.$e->getMessage();
            exit();
        }
        echo"
<!DOCTYPE html>
<script>
function redir()
{
window.location.assign('controlpanel.php');
}
</script>
<body onload='redir();'></body>";
    }

    public function delTeam($val_team_id){
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
        try{
            $dbo->exec('DELETE FROM teams WHERE team_id = '. $val_team_id);
        } catch(PDOException $e){
            echo 'Error : '.$e->getMessage();
            exit();
        }
        echo"
<!DOCTYPE html>
<script>
function redir()
{
window.location.assign('controlpanel.php');
}
</script>
<body onload='redir();'></body>";
    }

    public function changeTeam($val_team_id, $val_team_name,$val_teacher_name, $val_first_player, $val_second_player, $val_third_player, $val_fourth_player, $val_fifth_player, $val_win, $val_lose, $val_winrate){
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
        try{
            foreach($dbo->query("SELECT Spec FROM teacher WHERE Teacher_ID = '$val_teacher_name'") as $row) {
                $val_team_spec =  $row['Spec'];
            }
            $dbo->exec("UPDATE teams SET team_spec = '".$val_team_spec."', team_name = '".$val_team_name."', team_teacher = '".$val_teacher_name."', first_player = '".$val_first_player."', second_player = '".$val_second_player."', third_player = '".$val_third_player."', fourth_player = '".$val_fourth_player."', fifth_player = '".$val_fifth_player."', team_win = '".$val_win."', team_lose = '".$val_lose."', winrate = '".$val_winrate."' WHERE team_id = ".$val_team_id.";");
        } catch (PDOException $e){
            echo 'Error : '.$e->getMessage();
            exit();
        }
        echo"
<!DOCTYPE html>
<script>
function redir()
{
window.location.assign('controlpanel.php');
}
</script>
<body onload='redir();'></body>";
    }

    public function selectedTeacherTeamID(){
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
        echo "<label for='teacher_name'>Ф.И.О. Куратора</label>";
        echo "<select id = 'teacher_name' name='teacher_name' class='box' required>";
        echo"<option></option>";
        foreach($dbo->query('SELECT teacher_ID FROM teacher') as $row) {
            echo "<option>".$row['teacher_ID']."</option>";
        }
        echo "</select>";
    }

    public function selectedStudentNickname(){
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
        echo"<option></option>";
        foreach($dbo->query('SELECT Nickname FROM student') as $row) {
            echo "<option>".$row['Nickname']."</option>";
        }
        echo "</select>";
    }

    public function searchTeam($val_team_name,$val_teacher_name, $val_first_player, $val_second_player, $val_third_player, $val_fourth_player, $val_fifth_player, $val_win, $val_lose){
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
        foreach($dbo->query("SELECT * FROM teams WHERE team_name LIKE '%".$val_team_name."%' AND team_teacher LIKE '%".$val_teacher_name."%' AND first_player LIKE '%".$val_first_player."%' AND second_player LIKE '%".$val_second_player."%' AND third_player LIKE '%".$val_third_player."%' AND fourth_player LIKE '%".$val_fourth_player."%' AND fifth_player LIKE '%".$val_fifth_player."%' AND team_win LIKE '%".$val_win."%' AND team_lose LIKE '%".$val_lose."%';") as $row) {
            echo "<tr class='selected select_name'>";
            echo "<td style='visibility: hidden' >".$row['team_id']."</td>";
            echo "<td>".$row['team_spec']."</td>";
            echo "<td>".$row['team_name']."</td>";
            echo "<td>".$row['team_teacher']."</td>";
            echo "<td>".$row['first_player']."</td>";
            echo "<td>".$row['second_player']."</td>";
            echo "<td>".$row['third_player']."</td>";
            echo "<td>".$row['fourth_player']."</td>";
            echo "<td>".$row['fifth_player']."</td>";
            echo "<td>".$row['team_win']."</td>";
            echo "<td>".$row['team_lose']."</td>";
            echo "<td>".$row['winrate']."</td>";
            echo "</tr>";
        }
        echo "</table>";


    }
}

?>