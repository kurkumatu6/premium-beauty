<?php

use App\modules\Type;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';
$_SESSION['get'] = $_GET;
$_SESSION['error-type'] = '';
if($_GET['name'] !='' && $_GET['abb-name'] != ''){
    if(Type::getByName($_GET['name']) != null){
        $_SESSION['error-type'] = 'Тип с таким названием уже существует';
    }
    else{
    Type::create($_GET);
    }
}
else{
    $_SESSION['error-type'] = 'Не все поля заполнены';
}
var_dump($_SESSION['error-type']);
header('Location: /views/admin/types/types.view.php');
