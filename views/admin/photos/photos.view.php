<?php

use App\modules\Photo;
use App\modules\Type;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
?>
<link rel="stylesheet" href="/assets/styles/admin/photos.css">
<?php
$month_list = array(
    1  => 'января',
    2  => 'февраля',
    3  => 'марта',
    4  => 'апреля',
    5  => 'мая',
    6  => 'июня',
    7  => 'июля',
    8  => 'августа',
    9  => 'сентября',
    10 => 'октября',
    11 => 'ноября',
    12 => 'декабря'
);
if (isset($_POST['category']) && $_POST['category'] == 'teacher') {
    $photos = Photo::teacher();
} elseif (isset($_POST['category']) && $_POST['category'] == 'student') {
    $photos = Photo::student();
} else {
    $photos = Photo::all();
}
?>

<div class="buttons">
    <a href="/views/admin/photos/create.view.php"><button>Добавить фото</button></a>
</div>
<form action="/views/admin/photos/photos.view.php" method="POST">
    <h2>Фильтр по категориям</h2>
    <div class="parameters">
        <div class="item">
            <input id="all" type="radio" name="category" value="all" onchange="this.form.submit()" <?php if (!isset($_POST['category']) || isset($_POST['category']) && $_POST['category'] == 'all') {
                                                                                                        echo ('checked');
                                                                                                    } else {
                                                                                                        echo ('');
                                                                                                    } ?>>
            <label for="all">
                <h4>Все</h4>
            </label>
        </div>
        <div class="item">
            <input id="teacher" type="radio" name="category" value="teacher" onchange="this.form.submit()" <?php if (isset($_POST['category']) && $_POST['category'] == 'teacher') {
                                                                                                                echo ('checked');
                                                                                                            } else {
                                                                                                                echo ('');
                                                                                                            } ?>>
            <label for="teacher">
                <h4>Преподаватель</h4>
            </label>
        </div>
        <div class="item">
            <input id="student" type="radio" name="category" value="student" onchange="this.form.submit()" <?php if (isset($_POST['category']) && $_POST['category'] == 'student') {
                                                                                                                echo ('checked');
                                                                                                            } else {
                                                                                                                echo ('');
                                                                                                            } ?>>
            <label for="student">
                <h4>Ученик</h4>
            </label>
        </div>
    </div>
</form>
<table border="1">
    <tr>
        <td style="text-align: center;">Дата загрузки</td>
        <td style="text-align: center;">Категория</td>
        <td style="text-align: center; width: 150px;">Фото</td>
        <td style="text-align: center;">Действия</td>
    </tr>
    <?php foreach ($photos as $photo) : ?>
        <tr>
            <td style="text-align: center;"><?= date("j", strtotime($photo->date)) . ' ' . $month_list[date("n", strtotime($photo->date))] . ' ' . date("Y", strtotime($photo->date)) ?>г</td>
            <td style="text-align: center;"><?= $photo->category ?></td>
            <td style="width: 150px;" id="table"><img src="/assets/images/photos/<?= $photo->image ?>" alt=""></td>
            <td style="text-align: center;"><a href="/app/tables/photos/delete.php?id_photo=<?= $photo->id ?>">Удалить</a></td>
        </tr>
    <?php endforeach ?>
</table>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
?>