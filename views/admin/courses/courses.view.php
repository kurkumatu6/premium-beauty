<?php

use App\modules\Course;
use App\modules\Photo;
use App\modules\Type;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
?>
<link rel="stylesheet" href="/assets/styles/admin/courses.css">
<script defer src="/assets/scripts/OpenDescription.js"></script>

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
function formNewF($a, $b)
{
    if ($a->created_date == $b->created_date) {
        return 0;
    }
    return ($a->created_date > $b->created_date) ? -1 : 1;
}
$categories = Type::getAll();
$courses = Course::getAll();
$oldDays = [];
if (isset($_POST['btn'])) {
    $categoryArray = $_POST;
    if (count($categoryArray) >= 1) {
        $courses = Course::getByCategories($categoryArray);
        usort($courses, 'formNewF');
    }
    if (count($categoryArray) == 1) {
        $courses = Course::getAll();
    }
}
?>

<div class="buttons">
    <a href="/views/admin/courses/create.view.php"><button>Добавить курс</button></a>
</div>
<form action="/views/admin/courses/courses.view.php" method="POST">
    <div class="container">
        <div>
            <h3>Фильтр по категории:</h3>
            <div class="parameters filter">
                <?php foreach ($categories as $category) : ?>
                    <div class="item"><input type="checkbox" <?php if (isset($_POST[$category->id])) {
                                                                    echo ('checked');
                                                                }
                                                                ?> name="<?= $category->id ?>" id="<?= $category->id ?>" value="<?= $category->id ?>"> <label for="<?= $category->id ?>"><?= $category->abb_name ?></label></div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <button name="btn">Применить</button>
</form>
<table border="1">
    <tr>
        <td style="text-align: center;">Название</td>
        <td style="text-align: center;">Фото</td>
        <td style="text-align: center; width: 150px;">Цена</td>
        <td style="text-align: center; width: 500px;">Описание</td>
        <td style="text-align: center;">Макс. студентов</td>
        <td style="text-align: center;">Дата создания</td>
        <td style="text-align: center;">Статус</td>
        <td style="text-align: center;">Длительность</td>
        <td style="text-align: center;">Действия</td>
    </tr>
    <?php foreach ($courses as $course) : ?>
        <tr>
            <td style="text-align: center;"><?= $course->name ?></td>
            <td style="text-align: center;"><img src="/assets/images/courses/<?= $course->image ?>" alt=""></td>
            <td style="text-align: center; width: 150px;"><?= $course->price ?>р.</td>
            <td style="text-align: center; width: 400px; padding: 20px;">
                <p class="description-btn" id="<?= $course->id ?>">Показать описание</p>
                <p id="desc-<?= $course->id ?>" style=" display: none;"><?= $course->description ?></p>
            </td>
            <td style="text-align: center;"><?= $course->max_student ?></td>
            <td style="text-align: center;"><?= date("j", strtotime($course->created_date)) . ' ' . $month_list[date("n", strtotime($course->created_date))] . ' ' . date("Y", strtotime($course->created_date)) ?>г</td>
            <td style="text-align: center;"><?= $course->status ?></td>
            <td style="text-align: center;"><?= $course->duration ?></td>
            <td style="text-align: center;">
                <a href="/views/admin/bookings/bookingsCourse.view.php?course_id=<?= $course->id ?>">Бронирования</a><br>
                <a href="/app/tables/courses/delete.php?course_id=<?= $course->id ?>">Удалить</a><br>
                <a href="/views/admin/courses/edit.view.php?course_id=<?= $course->id ?>">Изменить</a><br>
                <?php if ($course->status == 'yes') : ?>
                    <a href="/app/tables/courses/hide.php?course_id=<?= $course->id ?>">Скрыть</a>
                <?php else : ?>
                    <a href="/app/tables/courses/noHide.php?course_id=<?= $course->id ?>">Показать</a>
            </td>
        <?php endif ?>
        </td>
        </tr>
    <?php endforeach ?>
</table>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
unset($_SESSION['post']);
unset($_SESSION['error']);
?>