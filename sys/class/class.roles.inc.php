<?php
if (!isset($_SESSION['user'])) {
    header("Location: ../controller/login.php");
    exit();
}
?>
<?php
include_once '../sys/config/db-cred.inc.php';
include_once "../sys/core/init.inc.php";

class Roles extends DB_Connect
{

    public function __construct($dbo = NULL)
    {
        parent::__construct($dbo);
    }

    public function checkRole($val_user_login_role)
    {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $dbo = new PDO ($dsn, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'utf8'"));
        foreach ($dbo->query("SELECT user_role FROM users WHERE user_login = '$val_user_login_role'") as $row) {
            return $row['user_role'];
        }
    }
}