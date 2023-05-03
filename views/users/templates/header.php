<?php

use App\modules\User;
use App\modules\Info;

session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

$white_logo = Info::get()->white_logo;
$logo = Info::get()->logo;
$phone = Info::get()->phone;
$email = Info::get()->email;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Обучение наращиванию ресниц Челябинск</title>
    <link rel="stylesheet" href="/assets/styles/basic.css">
    <link rel="stylesheet" href="/assets/styles/header.css">
    <link rel="stylesheet" href="/assets/styles/footer.css">
    <a name="app"></a>

<body>
    <div id="page-all">
        <header>
            <a href="/">
                <img src="/assets/images/templates/<?= $logo ?>" id="logo-header" alt="Логотип Премим Бьюти">
            </a>
            <a href="/views/users/about.view.php">
                <h3 class="text-header">О НАС</h3>
            </a>
            <a href="/views/users/photos.view.php">
                <h3 class="text-header">ФОТО РАБОТ</h3>
            </a>
            <a href="/views/users/courses/courses.view.php">
                <h3 class="text-header">КУРСЫ</h3>
            </a>
            <a href="/views/users/reviews/reviews.view.php">
                <h3 class="text-header">ОТЗЫВЫ</h3>
            </a>
            <?php if (isset($_SESSION['auth']) && $_SESSION['auth'] == 'user') : ?>
                <a href="/views/users/auth/profile.view.php">
                    <button class="green header-button"><?= User::getById($_SESSION['user_id'])->name ?></button>
                </a>
            <?php elseif (isset($_SESSION['auth']) && $_SESSION['auth'] == 'admin') : ?>
                <a href="/views/admin/adminPanel.view.php">
                    <button class="green header-button"><?= 'admin' . ' ' . User::getById($_SESSION['user_id'])->name ?></button>
                </a>
            <?php else : ?>
                <a href="/views/users/auth/logIn.view.php">
                    <button class="green header-button">ВОЙТИ</button>
                </a>
            <?php endif ?>
        </header>
        </head>