<?php

use App\modules\Block;
use App\modules\Element;
use App\modules\Page;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
?>
<link rel="stylesheet" href="/assets/styles/admin/main.css">
<div class="admin-main">
    <h1>Добавить элемент в блок "Преимущества"</h1>
    <form action="/app/tables/pages/createElementAbout.php" method="post" enctype="multipart/form-data">
        <div class="big-item">
            <div class="item">
                <p>Заголовок</p>
                <input name="title" type="text" value="<?= $_SESSION['post']['title'] ?? '' ?>">
            </div>
            <p class="error" style="color: red;"><?= $_SESSION['error']['title'] ?? '' ?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Текст</p>
                <textarea name="text" id="" cols="30" rows="10"><?= $_SESSION['post']['text'] ?? '' ?></textarea>
            </div>
            <p class="error" style="color: red;"><?= $_SESSION['error']['text'] ?? '' ?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Изображение</p>
                <input type="file" name="image">
            </div>
            <p class="error" style="color: red;"><?= $_SESSION['error']['image'] ?? '' ?></p>
        </div>
        <button>Сохранить</button>
    </form>
    <a href="/views/admin/pages/about/editAbout.view.php"><button style="margin-bottom: 50px;">Назад</button></a>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
unset($_SESSION['post']);
unset($_SESSION['error']);
?>