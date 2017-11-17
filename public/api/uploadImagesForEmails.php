<?php

require_once "../../app/kernel.php";
if (!Admin::isLogged()) {
    header("location: login.php");
    exit;
}

header('Location: ' . $global['website_root'] . 'admin');

$object = new stdClass();

if (empty($_FILES['img'])){
    $object->error = "Images are empty or type is incorrect!";

} else {
    chdir('../assets/images/forEmail/');

    $file_arr = reArrayFiles($_FILES['img']);
    foreach($file_arr as $val) {
        //add new files to DB
        $sql = "INSERT INTO images (filename, thumbnail, size) VALUES ('".$val['name']."', 2, ".$val['size'].")";
        $res = $global['pdo']->query($sql);

        //save new files
        move_uploaded_file($val['tmp_name'],$val['name']);
    }
    $object->success = 1;
}
echo json_encode($object);