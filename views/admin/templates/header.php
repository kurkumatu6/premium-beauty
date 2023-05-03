<?php

use App\modules\Info;

session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';
$white_logo = Info::get()->white_logo;
$logo = Info::get()->logo;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Обучение наращиванию ресниц Челябинск</title>
    <link rel="stylesheet" href="/assets/styles/basic.css">
    <link rel="stylesheet" href="/assets/styles/admin/header.css">
    <link rel="stylesheet" href="/assets/styles/admin/footer.css">
    <a name="app"></a>
    <header>
        <a href="/">
            <h3 class="text-header">САЙТ</h3>
        </a>
        <a href="/views/admin/adminPanel.view.php">
            <h3 class="text-header">ПАНЕЛЬ АДМИНИСТРАТОРА</h3>
        </a>
        <a href="/views/admin/adminPanel.view.php">
            <button class="green header-button">admin Анастасия</button>
        </a>
        <a href="/app/tables/users/exit.php">
            <h3 class="text-header">ВЫЙТИ</h3>
        </a>
    </header>
</head>

<body>
<?php if($_SESSION['auth'] != 'admin'){
    header("Location: /");
}?>