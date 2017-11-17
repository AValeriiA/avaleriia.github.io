<?php
require_once "../../vendor/autoload.php";
require_once "../../app/models/Mailer.php";

require_once "../../app/kernel.php";

$object = new stdClass();

if (empty($_GET['e']) || empty($_GET['c']) || !password_verify($_GET['e']."X12_dtyR", $_GET['c'])){
    $object->error = "Incorrect data";

} else {
    if (!filter_var($_GET['e'], FILTER_VALIDATE_EMAIL)) {
        $object->error = "Incorrect email format";

    } else {
        //activate subscribe
        $params = [
            ':email' => $_GET['e'],
            ':code' => $_GET['c']
        ];
        $sql = "UPDATE subscribes SET active = 1 WHERE email = :email AND code = :code";

        $res = $global['pdo']->prepare($sql);
        $object->success = $res->execute($params);
    }
}

header("location: ../?msg=" . ($object->success ? "Subscribed" : "Error"));