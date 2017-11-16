<?php

require_once "../../app/kernel.php";
if (!Admin::isLogged()) {
    header("location: login.php");
    exit;
}

if (empty($_POST['email'])) {
    $msg = "Support email is empty!";

} else {
    $params = [
        ':email' => htmlspecialchars($_POST['email'])
    ];
    $sql = "UPDATE admins SET support_email = :email";
    $res = $global['pdo']->prepare($sql);
    if (!$res->execute($params)) {
        $msg = "Save error! Incorrect data!";
    }
    $msg = "Success!";
}

header('Location: ' . $global['website_root'] . 'admin/?msg='.$msg);