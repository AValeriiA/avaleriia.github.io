<?php

require_once "../../app/kernel.php";
if (!Admin::isLogged()) {
    header("location: login.php");
    exit;
}

header('Location: ' . $global['website_root'] . 'admin');

$object = new stdClass();

if (empty($_FILES['img']) || empty($_POST['type']) || !in_array($_POST['type'], ['screenshots/', 'thumbnails/'])){
    $object->error = "Images are empty or type is incorrect!";

} else {
    //remove old data in DB
    $sql = "DELETE FROM images WHERE thumbnail = " . ($_POST['type'] == 'screenshots/' ? "0" : "1");
    $res = $global['pdo']->prepare($sql);
    $res->execute();

    //remove old files
    $old_files = scandir('../assets/images/'.$_POST['type']);
    chdir('../assets/images/'.$_POST['type']);
    foreach ($old_files as $old_file) {
        if (!is_dir($old_file)) {
            unlink($old_file);
        }
    }

    $file_arr = reArrayFiles($_FILES['img']);
    foreach($file_arr as $val) {
        //add new files to DB
        $params = [
            ':filename' => $val['name'],
            ':size' => $val['size']
        ];
        $sql = "INSERT INTO images (filename, thumbnail, size) VALUES (:filename, ".($_POST['type'] == 'screenshots/' ? "0" : "1").", :size)";
        $res = $global['pdo']->prepare($sql);
        $res->execute($params);

        //save new files
        move_uploaded_file($val['tmp_name'],$val['name']);
    }
    $object->success = 1;
}
echo json_encode($object);