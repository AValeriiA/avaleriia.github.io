<?php

require_once "../../app/kernel.php";
if (!Admin::isLogged()) {
    header("location: login.php");
    exit;
}

if (empty($_POST['email'])) {
    $msg = "Support email is empty!";

} else {
    $sql = "UPDATE admins SET support_email = '".htmlspecialchars(addslashes($_POST['email']))."'";
    if (!$global['pdo']->prepare($sql)) {
        $msg = "Save error! Incorrect data!";
    } else {
        $msg = "Success!";
    }
}

header('Location: ' . $global['website_root'] . 'admin/?msg='.$msg);