<?php

use App\modules\Booking;
use App\modules\Course;
use App\modules\Review;
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
if(isset($_GET['idReview'])){
    $review = Review::getById($_GET['idReview']);
    $_SESSION['idReview'] = $_GET['idReview'];
}
else{
    $review = Review::getById($_SESSION['idReview']);
}
?>
<link rel="stylesheet" href="/assets/styles/admin/answerCreate.css">

<div class="cancel-course">
    <h1>Оставить ответ на отзыв</h1>
    <p><b>Студент: </b><?= User::getById(Booking::getById($review->id_booking)->id_user)->name . ' ' . User::getById(Booking::getById($review->id_booking)->id_user)->surname ?></p>
    <p><b>Курс: </b><?= Course::getById(TimeTable::getById(Booking::getById($review->id_booking)->id_timetable)->course_id)->name ?></p>
    <p><b>Дата прохождения: </b><?= TimeTable::getById(Booking::getById($review->id_booking)->id_timetable)->date?></p>
    <form action="/app/tables/reviews/createAnswer.php" id="form-cancel">
        <label for="">
            <p><b>Текст ответа</b></p>
        </label>
        <textarea name="text" id="" cols="30" rows="10"><?=$_SESSION['get']['text'] ?? ''?></textarea>
        <p id="error"><?=$_SESSION['error'] ?? ''?></p>
        <button class="btn-contour" type="submit">Готово</button>
    </form>
</div>
<a href="/views/admin/reviews/reviews.view.php"><button>Вернуться</button></a>

<?php
unset($_SESSION['post']);
unset($_SESSION['error']);
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
