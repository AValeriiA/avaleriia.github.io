<?php
header('Content-Type: application/json');

require_once "../../app/kernel.php";

$object = new stdClass();

if (empty($_POST['user']) || empty($_POST['pass'])){
    $object->error = "Name and Password can not be blank";

} else {
    $object->success = Admin::login($_POST['user'], $_POST['pass']);
    if (!$object->success) {
        $object->error = "Name or Password are incorrect!";
    }
}
echo json_encode($object);