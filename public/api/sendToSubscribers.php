<?php

require_once "../../app/kernel.php";
if (!Admin::isLogged()) {
    header("location: login.php");
    exit;
}

header('Location: ' . $global['website_root'] . 'admin');

$object = new stdClass();

if (empty($_POST['email']) || empty($_POST['mode'])){
    $object->error = "Email or mode is empty!";

} else {
    if ($_POST['mode'] == "new") {
        $sql = "INSERT INTO emails (body) VALUES ('".addslashes($_POST['email'])."')";
        $res = $global['pdo']->query($sql);

        //update subscribe status for new email
        $sql = "UPDATE subscribes SET notice_delivered = NULL";
        $res = $global['pdo']->query($sql);
    } else {
        $sql = "UPDATE emails SET body = '".addslashes($_POST['email'])."' WHERE is_greeting = 1";
        $res = $global['pdo']->query($sql);
    }

    $object->success = 1;
}
echo json_encode($object);