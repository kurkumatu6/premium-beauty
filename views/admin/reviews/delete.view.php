<?php


use App\modules\Answer;
use App\modules\Booking;
use App\modules\Course;
use App\modules\TimeTable;
use App\modules\User;
use App\modules\Review;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
$_SESSION['deleteReview'] = $_GET['deleteReview'];
?>

<link rel="stylesheet" href="/assets/styles/admin/delete-reviews.css">

<div class="delete-review">
    <h2>Вы уверены что хотите удалить отзыв и заблокировать его автора?</h2>
    <div class="buttons-modal">
        <a href=""></a>
        <a href="/app/tables/reviews/deleteReviewAdmin.php"><button class="btn-contour">Удалить</button></a>
        <a href="/views/admin/reviews/reviews.view.php"><button id="btn-close">Назад</button></a>
    </div>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
unset($_SESSION['post']);
unset($_SESSION['error']);
?>