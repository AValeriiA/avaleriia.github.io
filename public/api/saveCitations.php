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
        $params = array(
            ':id' => $id,
            ':text' => $citate['text'],
            ':who' => $citate['who']
        );
        $sql = "UPDATE citations SET text = :text, who = :who WHERE id = :id";
        $res = $global['pdo']->prepare($sql);
        if (!$res->execute($params)) {
            $msg = "Save error! Incorrect data!";
        }
    }
    $msg = "Success!";
}

header('Location: ' . $global['website_root'] . 'admin/?msg='.$msg);