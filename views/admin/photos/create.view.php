<?php

use App\modules\Info;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
?>
<link rel="stylesheet" href="/assets/styles/admin/create-photo.css">
<div class="admin-main">
    <h1>Добавить фото</h1>
    <form action="/app/tables/photos/create.php" method="post" enctype="multipart/form-data">
        <div class="big-item">
            <div class="item">
                <p>Фото</p>
                <input name="photo" type="file">
            </div>
            <p class="error" style="color: red;"><?= $_SESSION['error']['photo'] ?? '' ?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Категория</p>
                <div class="inputs">
                    <div class="item2">
                        <input type="radio" id="teacher" name="category" value="Преподаватель"<?php if(isset($_POST['category']) && $_POST['category'] == 'Преподаватель'){
                            echo('checked');}?>>
                        <label for="teacher">Преподаватель</label>
                    </div>
                    <div class="item2">
                        <input type="radio" id="student" name="category" value="Ученик"<?php if(isset($_POST['category']) && $_POST['category'] == 'Ученик'){
                            echo('checked');}?>>
                        <label for="student">Ученик</label>
                    </div>
                </div>
            </div>
            <p class="error" style="color: red;"><?= $_SESSION['error']['category'] ?? '' ?></p>
        </div>
        <button>Добавить</button>
    </form>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
unset($_SESSION['error']);
?>