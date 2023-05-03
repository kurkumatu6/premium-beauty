<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/header.php';
?>
<link rel="stylesheet" href="/assets/styles/photos.css">
<script defer src="/assets/scripts/modalPhoto.js"></script>

<?php

use App\modules\Photo;

if (isset($_POST['category']) && $_POST['category'] == 'teacher') {
    $photos = Photo::teacher();
} elseif (isset($_POST['category']) && $_POST['category'] == 'student') {
    $photos = Photo::student();
} else {
    $photos = Photo::teacher();
}
?>


<h1>Фото работ</h1>
<form action="/views/users/photos.view.php" method="POST">
    <div class="item">
        <input id="teacher" type="radio" name="category" value="teacher" onchange="this.form.submit()" <?php if (!isset($_POST['category']) || isset($_POST['category']) && $_POST['category'] == 'teacher') {
                                                                                                            echo ('checked');
                                                                                                        } else {
                                                                                                            echo ('');
                                                                                                        } ?>>
        <label for="teacher">
            <h4>Преподавателя</h4>
        </label>
    </div>
    <div class="item">
        <input id="student" type="radio" name="category" value="student" onchange="this.form.submit()" <?php if (isset($_POST['category']) && $_POST['category'] == 'student') {
                                                                                                            echo ('checked');
                                                                                                        } else {
                                                                                                            echo ('');
                                                                                                        } ?>>
        <label for="student">
            <h4>Учеников</h4>
        </label>
    </div>
</form>
<div class="gallery">
    <?php foreach ($photos as $photo) : ?>
        <img class="gallery-item" src="/assets/images/photos/<?= $photo->image ?>" id="<?= $photo->id ?>" data-att="<?= $product ?>" alt="/assets/images/photos/<?= $photo->image ?>">
    <?php endforeach ?>
</div>
<div class="modal" id="modal">

    <div class="modal-content">
        
        <!-- <img src="/assets/images/photos/C5OG4lDq4RY.jpg" alt=""> -->
        <!-- <div class="info">
            <div class="item">
                <p><b>Тип наращивания:</b> Объём</p>
            </div>
            <div class="item">
                <p><b>Дата работы:</b> 20 марта</p>
            </div>
            <div class="item">
                <p><b>Категория:</b> Преподавтель</p>
            </div>
            <div class="item">
                <p><b>Описание:</b> <br> Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi placeat amet quisquam aliquid fuga ipsam!</p>
            </div>
            <div class="buttons">
                <button class="btn-contour">закрыть</button>
            </div>
        </div> -->
    </div>
    <p id="close">✕</p>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/footer.php';
?>