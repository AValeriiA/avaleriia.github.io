<?php
define(__DIR__, dirname(__FILE__));

//classes load
require_once __DIR__."/models/Admin.php";

//load env
$env_arr = file_get_contents(__DIR__ . "/../.env");
$env_arr = preg_replace("/\s+/", " ", $env_arr);
$env_arr = explode(" ", $env_arr);
foreach ($env_arr as $opt) {
    $tmp_arr = explode("=", $opt);
    $envs[$tmp_arr[0]] = $tmp_arr[1];
}

//start mysql pdo
$mysqlHost = $envs['MYSQL_HOST'];
$mysqlDatabase = $envs['MYSQL_DATABASE'];
$mysqlUser = $envs['MYSQL_USER'];
$mysqlPass = $envs['MYSQL_PASS'];

global $global;

$global['pdo'] = new PDO("mysql:host=".$mysqlHost."; port=3306; dbname=".$mysqlDatabase.";", $mysqlUser,$mysqlPass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));


$sql = "SELECT * FROM admins LIMIT 1";
$res = $global['pdo']->prepare($sql);
$res->execute();
$admin = $res->fetch(PDO::FETCH_ASSOC);

$global['website_root'] = $envs["WEBSITE_ROOT_PATH"];
$global['support_email'] = $admin['support_email'];
$global['smtp_mailer'] = $envs["SMTP_MAILER"];
$global['smtp_host'] = $envs["SMTP_HOST"];
$global['smtp_user'] = $envs["SMTP_USER"];
$global['smtp_pass'] = $envs["SMTP_PASS"];
$global['smtp_port'] = $envs["SMTP_PORT"];

// server should keep session data for AT LEAST 1 month
ini_set('session.gc_maxlifetime', 2592000);
// each client should remember their session id for EXACTLY 1 month
session_set_cookie_params(2592000);

session_start();



function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}