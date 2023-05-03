<?php
session_start();

use App\modules\User;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

if (!preg_match('/^[а-яА-Я\s\-]{3,20}$/u', $_GET['name']) || !preg_match('/^[а-яА-Я\s\-]{3,20}$/u', $_GET['surname'])) {
    $_SESSION['error-profile'] = 'Неккоректное значение новых данных';
} else {
    User::changeFio($_GET['surname'], $_GET['name'], $_SESSION['user_id']);
}
header("Location: /views/users/auth/profile.view.php");
