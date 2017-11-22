<?php

require_once "../../app/kernel.php";
if (!Admin::isLogged()) {
    header("location: login.php");
    exit;
}

if (empty($_POST['mode']) || empty($_POST['email']) || empty($_POST['pass'])) {
    $msg = "Fields are empty!";

} else {
    if ($_POST['mode'] == "support") {
        $sql = "UPDATE admins SET support_email = '".htmlspecialchars(addslashes($_POST['email']))."', support_pass = '".htmlspecialchars(addslashes($_POST['pass']))."'";
    } else {
        $sql = "UPDATE admins SET send_email = '".htmlspecialchars(addslashes($_POST['email']))."', send_pass = '".htmlspecialchars(addslashes($_POST['pass']))."'";
    }

    if (!$global['pdo']->query($sql)) {
        $msg = "Save error! Incorrect data!";
    } else {
        $msg = "Success!";
    }
}

header('Location: ' . $global['website_root'] . 'admin/?msg='.$msg);