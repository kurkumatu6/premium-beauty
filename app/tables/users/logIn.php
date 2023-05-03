<?php
session_start();

use App\modules\User;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

if (isset($_GET['btn_login'])) {
    $_SESSION['get'] = $_GET;
    if (!isset($_GET['login']) && !isset($_GET['password']) || $_GET['login'] == '' && $_GET['password'] == '') {
        $_SESSION['error'] = 'Введите данные';
        header("Location: /views/users/auth/logIn.view.php");
        die();
    }
    $user = User::getByLogin($_GET['login']);
    if ($user == null) {
        $_SESSION['error'] = 'Пользователь не найден';
        $_SESSION['auth'] = false;
        header("Location: /views/users/auth/logIn.view.php");
        die();
    } else {
        $user = User::ByLoginAndPassword($_GET['login'], $_GET['password']);
        if ($user == null) {
            $_SESSION['error'] = 'Неверный пароль';
            header("Location: /views/users/auth/logIn.view.php");
        } else {
            if ($user->role == 'admin') {
                $_SESSION['auth'] = 'admin';
                $_SESSION['user_id'] = $user->id;
                header("Location: /views/admin/adminPanel.view.php");
            } else {
                if($user->in_block == 'yes'){
                    $_SESSION['error'] = 'Аккаунт заблокирован за нарушение правил сайта';
                    header("Location: /views/users/auth/logIn.view.php");
                }
                else{
                $_SESSION['auth'] = 'user';
                $_SESSION['user_id'] = $user->id;
                header("Location: /views/users/auth/profile.view.php");
                }
            }
        }
    }
}
