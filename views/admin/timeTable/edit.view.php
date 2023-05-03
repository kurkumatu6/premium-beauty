<?php

use App\modules\Course;
use App\modules\TimeTable;
use App\modules\Booking;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';

$todayDate = date('Y-m-d');
if (isset($_GET['day_id'])) {
    $day = TimeTable::getById($_GET['day_id']);
} else {
    $day = TimeTable::getById($_SESSION['post']['id_day']);
}
?>
<link rel="stylesheet" href="/assets/styles/admin/timeTable-create.css">
<div class="timeTable-create">
    <h1>Изменить день в расписание</h1>
    <form action="/app/tables/timeTable/edit.php" method="post" enctype="multipart/form-data">
        <input name="id_day" value="<?= $day->id ?>" style="display: none;">
        <div class="big-item">
            <div class="item">
                <p>Курс</p>
                <select name="course">
                    <?php if (isset($_SESSION['post']['course'])) : ?>
                        <option value="<?= $_SESSION['post']['course'] ?>"><?= Course::getById($_SESSION['post']['course'])->name ?></option>
                    <?php else : ?>
                        <option value="<?= Course::getById($day->course_id)->id ?>"><?= Course::getById($day->course_id)->name ?></option>
                    <?php endif ?>
                    <?php
                    $courses = Course::getAll();
                    foreach ($courses as $course) : ?>
                        <option value="<?= $course->id ?>"><?= $course->name ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <p class="error" style="color: red;"><?= $_SESSION['error']['course'] ?? '' ?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Дата</p>
                <input name="date" value="<?= $_SESSION['post']['date'] ?? date('Y-m-d', strtotime($day->date)) ?>" type="date" min="<?= $todayDate ?>">
            </div>
            <p class="error" style="color: red;"><?= $_SESSION['error']['date'] ?? '' ?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Время</p>
                <input name="time" type="time" value="<?= $_SESSION['post']['time'] ?? date('H:i', strtotime($day->date)) ?>">
            </div>
            <p class="error" style="color: red;"><?= $_SESSION['error']['time'] ?? '' ?></p>
        </div>
        <button>Сохранить</button>
    </form>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
unset($_SESSION['post']);
unset($_SESSION['error']);
?>