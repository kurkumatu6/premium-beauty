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
if (isset($_GET['booking_id'])) {
    $order = Booking::getById($_GET['booking_id']);
    $_SESSION['booking_id'] = $_GET['booking_id'];
} else {
    $order = Booking::getById($_SESSION['booking_id']);
}
$date = TimeTable::getById($order->id_timetable)->date;
?>
<link rel="stylesheet" href="/assets/styles/cancel-course.css">
<script defer src="/assets/scripts/cancel-booking.js"></script>

<div class="cont">
    <div class="cancel-course">
        <h1>Отмена бронирования</h1>
        <p><b>Курс: </b><?= Course::getById(TimeTable::getById($order->id_timetable)->course_id)->name ?></p>
        <p><b>Дата: </b><?= date("j", strtotime($date)) . ' ' . $month_list[date("n", strtotime($date))] . ' ' . date("Y", strtotime($date)) ?></p>
        <p><b>Время: </b><?= date("H:i", strtotime($date)) ?></p>
        <form action="/app/tables/bookings/cancelBooking.php" id="form-cancel">
            <label for="">
                <p><b>Укажите причину отмены</b></p>
            </label>
            <textarea name="text" id="" cols="30" rows="10"><?= $_SESSION['get']['text'] ?? '' ?></textarea>
            <p id="error"><?= $_SESSION['error'] ?? '' ?></p>
        </form>
        <div class="buttons">
            <button class="btn-contour">Готово</button>
            <a href="/views/users/auth/profile.view.php"><button>Вернуться</button></a>
        </div>
    </div>
</div>
<div class="modal" id="modal">

    <div class="modal-content">
        <h2>Вы уверены что хотите отменить бронирование?</h2>
        <div class="buttons-modal">
            <button class="btn-contour" type="submit" form="form-cancel">Отменить бронирование</button>
            <a href="/views/users/auth/profile.view.php"><button>Вернуться в личный кабинет</button></a>
        </div>
    </div>
    <p id="close">✕</p>
</div>

<?php
unset($_SESSION['post']);
unset($_SESSION['error']);
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/footer.php';
