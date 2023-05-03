<?php
session_start();

use App\modules\User;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

if (!preg_match('/^https:\/\/vk\.com\/\w*$/', $_GET['vk'])) {
    $_SESSION['error'] = 'Неккоректное значение новых данных';
} else {
    User::changeVk($_GET['vk'], $_SESSION['user_id']);
}
header("Location: /views/users/auth/profile.view.php");
