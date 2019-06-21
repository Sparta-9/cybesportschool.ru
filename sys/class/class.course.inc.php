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
	
	class Course extends DB_Connect{
		
		public function __construct($dbo = NULL) {
			parent::__construct($dbo);
		}
		
		public function showAllCourse(){
			$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
			$dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
			foreach($dbo->query('SELECT * FROM courses' ) as $row) {
				echo "<tr class='selected select_name'>";
				echo "<td style='visibility: hidden'>".$row['Course_ID']."</td>";
				echo "<td>".$row['Name_of_course']."</td>";
                echo "<td>".$row['Type']."</td>";
				echo "<td>".$row['Cost_of_course']."</td>";
				echo "<td>".$row['Teacher_ID']."</td>";
				echo "<td>".$row['Duration']."</td>";
				echo "</tr>";
			}
			
			echo "</table>";
		}

        public function showStudentCourse(){
            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
            $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
            foreach($dbo->query('SELECT * FROM courses WHERE Type = "Персональный"' ) as $row) {
                echo "<tr class='selected select_name'>";
                echo "<td style='visibility: hidden'>".$row['Course_ID']."</td>";
                echo "<td>".$row['Name_of_course']."</td>";
                echo "<td>".$row['Cost_of_course']."</td>";
                echo "<td>".$row['Teacher_ID']."</td>";
                echo "<td>".$row['Duration']."</td>";
                echo "</tr>";
            }

            echo "</table>";
        }

		public function selectedTeacherID(){
			$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
			$dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
			echo "<label for='teacher_name'>Ф.И.О. Преподавателя</label>";
			echo "<select id = 'teacher_name' name='teacher_name' class='box' required>
                      <option></option>";

			foreach($dbo->query('SELECT teacher_ID FROM teacher') as $row) {
				echo "<option>".$row['teacher_ID']."</option>";
			}
			echo "</select>";
		}
		
		public function addCourse($val_Name_of_course, $val_type_of_course, $val_Cost_of_course, $val_Teacher_ID, $val_duration){
			$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
			$dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
			try {
				$stmt = $dbo->prepare("INSERT INTO courses (Name_of_course, Type, Cost_of_course, Teacher_ID, Duration) VALUES (?,?,?,?,?)");
				$stmt -> execute(array($val_Name_of_course, $val_type_of_course, $val_Cost_of_course,$val_Teacher_ID, $val_duration));
			}
			catch(PDOException $e){
				echo 'Error : '.$e->getMessage();
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

		public function changeCourse($val_Course_ID, $val_Name_of_course, $val_type_of_course, $val_Cost_of_course, $val_Teacher_ID, $val_duration){
			$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
			$dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
			try{
			    $dbo->exec("UPDATE courses SET Name_of_course = '".$val_Name_of_course."', Type = '".$val_type_of_course."', Cost_of_course = '".$val_Cost_of_course."', Teacher_ID = '".$val_Teacher_ID."', Duration = '".$val_duration."' WHERE Course_ID = ".$val_Course_ID.";");
                $dbo->exec("UPDATE checks SET Price = '$val_Cost_of_course' WHERE Course_ID = '$val_Name_of_course';");
			} catch (PDOException $e){
				echo 'Error : '.$e->getMessage();
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
		
		
		
		public function delCourse($val_Course_ID){
			$dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
			$dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
			try{
			    $dbo->exec('DELETE FROM courses WHERE Course_ID='. $val_Course_ID);
			} catch(PDOException $e){
				echo 'Error : '.$e->getMessage();
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

        public function searchCourse($val_Name_of_course, $val_type_of_course, $val_Cost_of_course, $val_Teacher_ID, $val_duration){
            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
            $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES  'utf8'"));
            foreach($dbo->query("SELECT * FROM courses WHERE Name_of_course LIKE '%".$val_Name_of_course."%' AND Cost_of_course LIKE '%".$val_Cost_of_course."%' AND Teacher_ID LIKE '%".$val_Teacher_ID."%' AND Duration LIKE '%".$val_duration."%' AND Type LIKE '%".$val_type_of_course."%';") as $row) {
                echo "<tr class='selected select_name'>";
                echo "<td style='visibility: hidden'>".$row['Course_ID']."</td>";
                echo "<td>".$row['Name_of_course']."</td>";
                echo "<td>".$row['Type']."</td>";
                echo "<td>".$row['Cost_of_course']." р.</td>";
                echo "<td>".$row['Teacher_ID']."</td>";
                echo "<td>".$row['Duration']."</td>";
                echo "</tr>";
            }

            echo "</table>";
        }

        public function newSubmit($val_schedule_course, $val_schedule_student)
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
                foreach ($dbo->query("SELECT Cost_of_Course FROM courses WHERE Name_of_course = '$val_schedule_course'") as $row) {
                    $val_check_price = $row['Cost_of_Course'];
                }
                $stmt = $dbo->prepare("INSERT INTO checks (Student_id, Course_id, Date_of_start, Date_of_end, Date_of_check, Price, Passed) VALUES (?,?,?,?,?,?,?)");
                $stmt->execute(array($val_schedule_student, $val_schedule_course, '0000-00-00 00:00', '0000-00-00 00:00', date('Y-m-d'), $val_check_price, 3));
                $stmt = $dbo->prepare("INSERT INTO schedule (schedule_type, schedule_course_name, schedule_teacher_name, schedule_student_name, schedule_date_of_start, schedule_date_of_end, schedule_passed) VALUES (?,?,?,?,?,?,?)");
                $stmt->execute(array($val_type, $val_schedule_course, $val_teacher_name, $val_schedule_student, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0));
            } catch (PDOException $e) {
                echo 'Error : ' . $e->getMessage();
                exit();
            }
            echo '<!DOCTYPE html>
<script>
function redir()
{
    alert("Спасибо что записались на курс ', $val_schedule_course. '! Наш оператор свяжется с вами для уточнения времени занятия а так же, для уточнения оплаты")
window.location.assign(\'index.php\');
}
</script>
<body onload=\'redir();\'></body>';
        }
	}
