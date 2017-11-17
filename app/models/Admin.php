<?php

class Admin
{
    private $id;
    private $name;
    private $pass;
    private $created;
    private $last_login;

    public static function isLogged() {
        return !empty($_SESSION["user"]);
    }

    public static function login($name, $pass) {
        $user = Admin::find($name);

        if ($user && password_verify($pass, $user['pass'])) {
            $_SESSION["user"] = $user;
            Admin::setLastLogin($name);
            $success = 1;
        } else {
            unset($_SESSION["user"]);
            $success = 0;
        }
        return $success;
    }

    public static function find($name) {
        global $global;

        $params = array(':name' => $name);
        $sql = "SELECT * FROM admins WHERE name = :name LIMIT 1";

        $res = $global['pdo']->prepare($sql);
        $res->execute($params);

        $user = $res->fetch(PDO::FETCH_ASSOC);
        return $user ? $user : false;
    }

    public static function setLastLogin($name) {
        global $global;

        $params = array(':name' => $name);
        $sql = "UPDATE admins SET last_login = now() WHERE name = :name";

        $res = $global['pdo']->prepare($sql);
        return $res->execute($params);
    }
}