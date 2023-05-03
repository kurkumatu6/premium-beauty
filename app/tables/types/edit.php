<?php

use App\modules\Type;

use function PHPSTORM_META\type;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

$_SESSION['get'] = $_GET;
$_SESSION['error-type'] = '';
if ($_GET['name'] != '' && $_GET['abb_name'] != '') {
    if (Type::getByName($_GET['name']) != null) {
        $_SESSION['error-type'] = 'Тип с таким названием уже существует';
    } else {
        Type::edit($_GET);
        header('Location: /views/admin/types/types.view.php');
    }
} else {
    $_SESSION['error-type'] = 'Не все поля заполнены';
}


header('Location: /views/admin/types/editType.view.php');

