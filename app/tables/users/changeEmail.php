<?php
session_start();

use App\modules\User;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

if (!preg_match('/^\w*@mail\.ru|@gmail\.com|@bk\.ru$/', $_GET['email'])) {
    $_SESSION['error-profile'] = 'Неккоректное значение новых данных';
} else {
    User::changeEmail($_GET['email'], $_SESSION['user_id']);
}
header("Location: /views/users/auth/profile.view.php");
