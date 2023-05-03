<?php

use App\modules\Booking;
use App\modules\Course;
use App\modules\TimeTable;
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/header.php';
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
$bookings = Booking::getСompleted($_SESSION['user_id']); 
?>
<link rel="stylesheet" href="/assets/styles/create-review.css">
<div class="create-review">
    <form action="/app/tables/reviews/createReview.php">
        <h1>Создание отзыва</h1>
        <div class="item">
            <label for="">
                <h3>Курс</h3>
            </label>
            <select name="booking">
            <?php foreach ($bookings as $booking) : 
                $course = Course::getById(TimeTable::getById($booking->id_timetable)->course_id)?>
                    <option value="<?= $booking->id ?>">
                    Курс: <?= $course->name . 
                    '  Дата: ' . date("j", strtotime(TimeTable::getById($booking->id_timetable)->date)) . 
                    ' ' . $month_list[date("n", strtotime(TimeTable::getById($booking->id_timetable)->date))] . 
                    ' в ' . date("H", strtotime(TimeTable::getById($booking->id_timetable)->date)) . 
                    ':' . date("m", strtotime(TimeTable::getById($booking->id_timetable)->date)) ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="item">
            <label for="Текст">
                <h3>Текст</h3>
            </label>
            <textarea name="text" id="" cols="30" rows="10"><?= $_SESSION['get']['text'] ?? '' ?></textarea>
        </div>
        <p><?= $_SESSION['error'][0] ?? '' ?></p>
        <button name="btn">Оставить отзыв</button>
    </form>
</div>
<?php
unset($_SESSION['get']);
unset($_SESSION['error']);
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/footer.php';
?>