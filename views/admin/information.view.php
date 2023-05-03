<?php

use App\modules\Info;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
?>
<link rel="stylesheet" href="/assets/styles/admin/main.css">
<div class="admin-main">
    <h1>Изменение информации сайта</h1>
    <form action="/app/tables/info/edit-info.php" method="post" enctype="multipart/form-data">
        <h3>Форма изменения данных</h3>
        <div class="big-item">
            <div class="item">
                <p>Логотип</p>
                <input name="logo" type="file">
            </div>
            <p class="error" style="color: red;"><?=$_SESSION['error']['logo'] ?? ''?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Белый логотип</p>
                <input name="white_logo" type="file">
            </div>
            <p class="error" style="color: red;"><?=$_SESSION['error']['white_logo'] ?? ''?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Номер телефона</p>
                <input name="phone" type="text" value="<?= $_SESSION['post']['phone'] ?? Info::get()->phone ?>">
            </div>
            <p class="error" style="color: red;"><?=$_SESSION['error']['phone'] ?? ''?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Почта</p>
                <input name="email" type="text" value="<?=$_SESSION['post']['email'] ?? Info::get()->email ?>">
            </div>
            <p class="error" style="color: red;"><?=$_SESSION['error']['email'] ?? ''?></p>
        </div>
        <button>Сохранить</button>
    </form>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
unset($_SESSION['post']);
unset($_SESSION['error']);
?>