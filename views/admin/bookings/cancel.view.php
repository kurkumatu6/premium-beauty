<?php

use App\modules\Booking;
use App\modules\Course;
use App\modules\TimeTable;
use App\modules\User;

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
);
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
if(isset($_GET['booking_id'])){
    $booking = Booking::getById($_GET['booking_id']);
    $_SESSION['booking_id'] = $_GET['booking_id'];
}
else{
    $booking = Booking::getById($_SESSION['booking_id']);
}
$date =TimeTable::getById($booking->id_timetable)->date;
?>
<link rel="stylesheet" href="/assets/styles/admin/cancel-booking.css">

<div class="cancel-course">
    <h1>Отмена бронирования</h1>
    <p><b>Студент: </b><?= User::getById($booking->id_user)->name . ' ' . User::getById($booking->id_user)->surname ?></p>
    <p><b>Курс: </b><?= Course::getById(TimeTable::getById($booking->id_timetable)->course_id)->name ?></p>
    <p><b>Дата: </b><?= date("j", strtotime($date)) . ' ' . $month_list[date("n", strtotime($date))] . ' ' . date("Y", strtotime($date)) ?></p>
    <p><b>Время: </b><?= date("H:i", strtotime($date)) ?></p>
    <form action="/app/tables/bookings/cancelBookingAdmin.php" id="form-cancel">
        <label for="">
            <p><b>Укажите причину отмены</b></p>
        </label>
        <textarea name="text" id="" cols="30" rows="10"><?=$_SESSION['get']['text'] ?? ''?></textarea>
        <p id="error"><?=$_SESSION['error'] ?? ''?></p>
        <button class="btn-contour" type="submit">Готово</button>
    </form>
</div>
<a href="/views/admin/bookings/bookings.view.php"><button>Вернуться</button></a>

<?php
unset($_SESSION['post']);
unset($_SESSION['error']);
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
