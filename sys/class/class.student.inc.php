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

	class Student extends DB_Connect {



		public function __construct($dbo = NULL) {
			parent::__construct($dbo);
		}


        function translitStudent($s) {
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

        function generatorStudent() {
            $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";

            $password = null;

            $max=8;

            while($max--) {
                $password .= $chars[rand(0, 61)];

            }
            return($password);
        }

		public function showAllStudent(){
			$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
			$dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
			foreach($dbo->query('SELECT * FROM student') as $row) {
				echo "<tr class='selected select_name'>";
				echo "<td style='visibility: hidden'>".$row['Student_ID']."</td>";
				echo "<td>".$row['Name']."</td>";
                echo "<td>".$row['Nickname']."</td>";
				echo "<td>".$row['Address']."</td>";
				echo "<td>".$row['Phone_Number']."</td>";
                echo "<td>".$row['Email']."</td>";
				echo "</tr>";
			}
			echo "</table>";
		}
		
		public function addStudent($val_name, $val_nickname, $val_address, $val_phone, $val_email, $val_login, $val_password){
			$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
			$dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
			try {
				$stmt = $dbo->prepare("INSERT INTO student (Name, Nickname, Address, Phone_Number, Email) VALUES (?,?,?,?,?)");
				$stmt -> execute(array($val_name, $val_nickname, $val_address, $val_phone, $val_email));
                $asap = $dbo->prepare("INSERT INTO users (user_role, user_name, user_login, user_password, user_email, user_disabled) VALUES (?,?,?,?,?,?)");
                $asap->execute(array(3, $val_name, $val_login, $val_password, $val_email, 0));
			} catch(PDOException $e){
				echo 'Error : '.$e->getMessage();
				exit();	
			}
			echo'<!DOCTYPE html>
<script>
function redir()
{
    alert("Логин пользователя:', $val_login. ' Пароль пользователя:', $val_password. ' Дайте пользователю сфотографировать экран или сообщите ему его по телефону ");
window.location.assign(\'index.php\');
}
</script>
<body onload=\'redir();\'></body>';
		}

        public function changeStudent($val_student_id, $val_name, $val_nickname, $val_address, $val_phone, $val_email){
            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
            $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
            try{
                $dbo->exec("UPDATE student SET Name = '".$val_name."', Nickname = '".$val_nickname."', Address = '".$val_address."', Phone_Number = '".$val_phone."', Email = '".$val_email."' WHERE Student_ID = ".$val_student_id.";");
            } catch (PDOException $e){
                echo 'Error : '.$e->getMessage();
                exit();
            }
            echo'<!DOCTYPE html>
<script>
function redir()
{
window.location.assign(\'index.php\');
}
</script>
<body onload=\'redir();\'></body>';
        }
		
		public function delStudent($val_student_id){
			$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
			$dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
			try{
			    $dbo->exec('DELETE FROM student WHERE Student_ID='. $val_student_id);
			} catch(PDOException $e){
				echo 'Error : '.$e->getMessage();
				exit(); 
			}
			echo'<!DOCTYPE html>
<script>
function redir()
{
window.location.assign(\'index.php\');
}
</script>
<body onload=\'redir();\'></body>';
		}

        public function searchStudent($val_name, $val_nickname, $val_address, $val_phone, $val_email){
            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
            $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
            foreach($dbo->query("SELECT * FROM student WHERE Name LIKE '%".$val_name."%' AND Nickname LIKE '%".$val_nickname."%' AND Address LIKE '%".$val_address."%' AND Phone_Number LIKE '%".$val_phone."%' AND Email LIKE '%".$val_email."%';") as $row) {
                echo "<tr class='selected select_name'>";
                echo "<td style='visibility: hidden'>".$row['Student_ID']."</td>";
                echo "<td>".$row['Name']."</td>";
                echo "<td>".$row['Nickname']."</td>";
                echo "<td>".$row['Address']."</td>";
                echo "<td>".$row['Phone_Number']."</td>";
                echo "<td>".$row['Email']."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
		
	}

?>