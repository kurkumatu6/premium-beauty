<?php

use App\modules\Block;
use App\modules\Element;
use App\modules\Page;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
?>
<link rel="stylesheet" href="/assets/styles/admin/main.css">
<div class="admin-main">
    <h1>Добавить изображение в карусель</h1>
    <form action="/app/tables/pages/addPhotoInCarusel.php" method="post" enctype="multipart/form-data">
        <div class="big-item">
            <div class="item">
                <p>Изображение</p>
                <input type="file" name="image">
            </div>
            <p class="error" style="color: red;"><?= $_SESSION['error']['image'] ?? '' ?></p>
        </div>
        <button>Сохранить</button>
    </form>
    <a href="/views/admin/pages/about/editAbout.view.php"><button>Назад</button></a>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
unset($_SESSION['post']);
unset($_SESSION['error']);
?>