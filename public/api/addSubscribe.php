<?php

require_once "../../app/kernel.php";

$object = new stdClass();

if (empty($_GET['e']) || empty($_GET['c']) || !(hash("sha256",$_GET['e']."X12_dtyR") == $_GET['c'])){
    $object->error = "Incorrect data";

} else {
    if (!filter_var($_GET['e'], FILTER_VALIDATE_EMAIL)) {
        $object->error = "Incorrect email format";

    } else {
        //activate subscribe
        $params = array(
            ':email' => $_GET['e'],
            ':code' => $_GET['c']
        );
        $sql = "UPDATE subscribes SET active = 1 WHERE email = '".$_GET['e']."' AND code = '".$_GET['c']."'";

        $object->success = $global['pdo']->query($sql);
    }
}

header("location: ../?msg=" . ($object->success ? "Thank you! We will be in touch." : "Error"));