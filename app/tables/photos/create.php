<?php

use App\modules\Photo;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

$_SESSION['post'] = $_POST;
$error = [];
if ($_FILES['photo']['name'] == '') {
    $error['photo'] = 'Фото не загружено';
} elseif (
    $_FILES['photo']['type'] != 'image/png' && $_FILES['photo']['type']
    != 'image/jpeg' && $_FILES['photo']['type'] != 'image/jpg'
) {
    $error['photo'] = 'Неверный формат изображения';
}
if ($_POST['category'] == '') {
    $error['category'] = 'Не выбрана категория';
}
if ($error == []) {
    $date = date('Y-m-d');
    $name = $date . '_' . $_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], "C:/OSPanel/domains/premium-beauty/assets/images/photos/" . $name);
    Photo::create($_POST['category'], $name);
    header('Location: /views/admin/photos/photos.view.php');
} else {
    $_SESSION['error'] = $error;
    header('Location: /views/admin/photos/create.view.php');
}

