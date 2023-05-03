<?php

use App\modules\Course;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
?>
<link rel="stylesheet" href="/assets/styles/admin/course-create.css">
<div class="course-create">
    <h1>Добавить курс</h1>
    <form action="/app/tables/courses/create.php" method="post" enctype="multipart/form-data">
        <div class="big-item">
            <div class="item">
                <p>Название</p>
                <input name="name" type="text" value="<?= $_SESSION['post']['name'] ?? ''?>">
            </div>
            <p class="error" style="color: red;"><?=$_SESSION['error']['name'] ?? ''?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Фото</p>
                <input name="image" type="file">
            </div>
            <p class="error" style="color: red;"><?=$_SESSION['error']['image'] ?? ''?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Цена</p>
                <input name="price" type="text" value="<?= $_SESSION['post']['price'] ?? ''?>">
            </div>
            <p class="error" style="color: red;"><?=$_SESSION['error']['price'] ?? ''?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Описание</p>
                <textarea name="description" id="description" cols="30" rows="10"><?=$_SESSION['post']['description'] ?? '' ?></textarea>
            </div>
            <p class="error" style="color: red;"><?=$_SESSION['error']['description'] ?? ''?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Максимально студентов</p>
                <input name="max_student" type="text" value="<?= $_SESSION['post']['max_student'] ?? ''?>">
            </div>
            <p class="error" style="color: red;"><?=$_SESSION['error']['max_student'] ?? ''?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Длительность</p>
                <input name="duration" type="text" value="<?= $_SESSION['post']['duration'] ?? ''?>">
            </div>
            <p class="error" style="color: red;"><?=$_SESSION['error']['duration'] ?? ''?></p>
        </div>
        <button>Сохранить</button>
    </form>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
unset($_SESSION['post']);
unset($_SESSION['error']);
?>