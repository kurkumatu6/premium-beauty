<?php
session_start();

use App\modules\User;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

if (!preg_match('/^(\+7)[\d]{10}|(89)[\d]{9}$/u', $_GET['phone'])) {
    $_SESSION['error-profile'] = 'Неккоректное значение новых данных';
} else {
    User::changePhone($_GET['phone'], $_SESSION['user_id']);
}
header("Location: /views/users/auth/profile.view.php");
