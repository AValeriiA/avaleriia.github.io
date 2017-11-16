<?php

//classes load
require_once __DIR__."/models/Admin.php";

//load env
$env_arr = file_get_contents(__DIR__ . "/../.env");
$env_arr = preg_replace("/\s+/", " ", $env_arr);
$env_arr = explode(" ", $env_arr);
foreach ($env_arr as $opt) {
    putenv($opt);
}

//start mysql pdo
$mysqlHost = getenv('MYSQL_HOST');
$mysqlDatabase = getenv('MYSQL_DATABASE');
$mysqlUser = getenv('MYSQL_USER');
$mysqlPass = getenv('MYSQL_PASS');

global $global;

$global['pdo'] = new PDO("mysql:host=".$mysqlHost."; port=3306; dbname=".$mysqlDatabase.";", $mysqlUser,$mysqlPass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);


$sql = "SELECT * FROM admins LIMIT 1";
$res = $global['pdo']->prepare($sql);
$res->execute();
$admin = $res->fetch(PDO::FETCH_ASSOC);

$global['website_root'] = getenv("WEBSITE_ROOT_PATH");
$global['support_email'] = $admin['support_email'];
$global['smtp_mailer'] = getenv("SMTP_MAILER");

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