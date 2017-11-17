<?php

require_once "../../app/kernel.php";

header('Location: ' . $global['website_root'] . '?msg=Unsubscribed');

$object = new stdClass();

if (empty($_GET['e']) || empty($_GET['c'])){
    $object->error = "Incorrect data";

} else {
    if (!filter_var($_GET['e'], FILTER_VALIDATE_EMAIL)) {
        $object->error = "Incorrect email format";

    } else {
        $sql = "UPDATE subscribes SET active = 0 WHERE email = '".$_GET['e']."' AND code = '".addslashes($_GET['c'])."'";
        $object->success = $global['pdo']->query($sql);
    }
}
echo json_encode($object);