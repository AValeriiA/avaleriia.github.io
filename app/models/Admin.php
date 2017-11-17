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

        if ( $user && (hash("sha256",$pass) == $user['pass']) ) {
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

        $sql = "SELECT * FROM admins WHERE name = '".addslashes($name)."' LIMIT 1";

        $res = $global['pdo']->query($sql);

        $user = $res->fetch_assoc();
        return $user ? $user : false;
    }

    public static function setLastLogin($name) {
        global $global;

        $sql = "UPDATE admins SET last_login = now() WHERE name = '".addslashes($name)."'";

        return $global['pdo']->query($sql);
    }
}