<?php

require_once "../../app/kernel.php";
if (!Admin::isLogged()) {
    header("location: login.php");
    exit;
}

if (empty($_POST['cit'])) {
    $msg = "Citations are empty!";

} else {
    foreach($_POST['cit'] as $id => $citate) {
        $sql = "UPDATE citations SET text = '".($citate['text'])."', who = '".($citate['who'])."' WHERE id = ".(int)$id;
        if (!$global['pdo']->query($sql)) {
            $msg = "Save error! Incorrect data!";
            break;
        } else {
            $msg = "Success!";
        }
    }
}

header('Location: ' . $global['website_root'] . 'admin/?msg='.$msg);