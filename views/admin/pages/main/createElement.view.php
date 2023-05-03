<?php

use App\modules\Block;
use App\modules\Element;
use App\modules\Page;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
?>
<link rel="stylesheet" href="/assets/styles/admin/main.css">
<div class="admin-main">
    <h1>Добавить элемент в блок "Преимущества"</h1>
    <form action="/app/tables/pages/createElement.php" method="post" enctype="multipart/form-data">
        <div class="big-item">
            <div class="item">
                <p>Заголовок</p>
                <input name="title" type="text" value="<?= $_SESSION['post']['title'] ?? '' ?>">
            </div>
            <p class="error" style="color: red;"><?= $_SESSION['error']['title'] ?? '' ?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Подзаголовок</p>
                <input name="subtitle" type="text" value="<?= $_SESSION['post']['subtitle'] ?? '' ?>">
            </div>
            <p class="error" style="color: red;"><?= $_SESSION['error']['subtitle'] ?? '' ?></p>
        </div>
        <button>Сохранить</button>
    </form>
    <a href="/views/admin/pages/main/main_page.view.php"><button class="dowm">Назад</button></a>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
unset($_SESSION['post']);
unset($_SESSION['error']);
?>