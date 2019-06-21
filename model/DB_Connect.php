<?php
/**
 * Created by PhpStorm.
 * User: MaxStgs
 * Date: 03.06.2018
 * Time: 19:08
 */

include "../config/db_config.php";

foreach($C as $name => $val) {
    define($name, $val);
}

    class DB_Connect
    {
        protected $db;

        protected function __construct($db = NULL)
        {
            if (is_object($db)) {
                $this->db = $db;
            } else {
                $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
                try {
                    $this->db = new PDO($dsn, DB_USER, DB_PASS);
                } catch (Exception $exception) {
                    die($exception->getMessage());
                }
            }
        }

    }

    /*
     *  $sql = "DELETE FROM events where event_id =:id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
     */
?>