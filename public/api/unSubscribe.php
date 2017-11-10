<?php

require_once "../../app/kernel.php";

header('Location: ' . $global['website_root']);

$object = new stdClass();

if (empty($_GET['e']) || empty($_GET['c'])){
    $object->error = "Incorrect data";

} else {
    if (!filter_var($_GET['e'], FILTER_VALIDATE_EMAIL)) {
        $object->error = "Incorrect email format";

    } else {
        $params = [
            ':email' => $_GET['e'],
            ':code' => $_GET['c']
        ];
        $sql = "UPDATE subscribes SET active = 0 WHERE email = :email AND code = :code";

        $res = $global['pdo']->prepare($sql);
        $object->success = $res->execute($params);
    }
}
echo json_encode($object);