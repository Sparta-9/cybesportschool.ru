<?php

include "DB_Connect.php";

class User extends DB_Connect{

    public function __construct($db = NULL)
    {
        parent::__construct($db);
    }

    public function Get($login, $pass){
        $sql = "select * from users where user_login =:login and user_password =:pass limit 1;";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":login", $login, PDO::PARAM_STR);
        $stmt->bindParam(":pass", $pass, PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $stmt->closeCursor();

        return $count;
    }
}