<?php

require_once "../../app/kernel.php";
if (!Admin::isLogged()) {
    header("location: login.php");
    exit;
}

if (empty($_POST['video_link'])) {
    $msg = "Fields are empty!";

} else {
    $_POST['video_link'] = str_replace('watch?v=', 'embed/', $_POST['video_link']);
    $sql = "UPDATE admins SET video_link = '".$_POST['video_link']."'";

    if (!$global['pdo']->query($sql)) {
        $msg = "Save error! Incorrect data!";
    } else {
        $msg = "Success!";
    }
}

header('Location: ' . $global['website_root'] . 'admin/?msg='.$msg);