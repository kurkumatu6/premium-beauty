<?php


use App\modules\Answer;
use App\modules\Booking;
use App\modules\Course;
use App\modules\TimeTable;
use App\modules\User;
use App\modules\Review;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
$review = Review::getById($_GET['one_review'])
?>

<link rel="stylesheet" href="/assets/styles/admin/reviews.css">
<?php

?>


    <table border="1">
        <tr>
            <td style="text-align: center;">Курс</td>
            <td style="text-align: center;">Дата прохождения курса</td>
            <td style="text-align: center;">Автор</td>
            <td style="text-align: center;">Текст</td>
            <td style="text-align: center;">Дата Создания</td>
            <td style="text-align: center;">Дата обновления</td>
            <td style="text-align: center;">Статус отзыва</td>
            <td style="text-align: center;">Действия</td>
        </tr>
            <tr>
                <td style="text-align: center;"><?= Course::getById(TimeTable::getById(Booking::getById($review->id_booking)->id_timetable)->course_id)->name  ?></td>
                <td style="text-align: center;"><?= TimeTable::getById(Booking::getById($review->id_booking)->id_timetable)->date ?></td>
                <td style="text-align: center;"><?= User::getById(Booking::getById($review->id_booking)->id_user)->name . ' ' . User::getById(Booking::getById($review->id_booking)->id_user)->surname ?></td>
                <td style="text-align: center;"><?= $review->text ?></td>
                <td style="text-align: center;"><?= $review->created_date ?></td>
                <td style="text-align: center;"><?= $review->update_date ?></td>
                <?php if ($review->in_delete == 'yes') : ?>
                    <td style="text-align: center;"> Удалён </td>
                <?php else : ?>
                    <td style="text-align: center;"> Опубликован </td>
                <?php endif ?>
                <td style="text-align: center;">
                    <?php if (Answer::getByIdReview($review->id) == null) : ?>
                        <a href="/views/admin/reviews/answerCreate.view.php?idReview=<?= $review->id ?>">Ответить</a> <br>
                    <?php endif ?>
                    <?php if ($review->in_delete != 'yes') : ?>
                        <a href="/views/admin/reviews/delete.view.php?deleteReview=<?= $review->id ?>">Удалить</a>
                    <?php else : ?>
                        <a href="/app/tables/reviews/totalDelete.php?review_delete=<?= $review->id ?>">Удалить окончательно</a> <br>
                    <?php endif ?>
                </td>
            </tr>
            <?php
            if (Answer::getByIdReview($review->id) != null) :
                $answer = Answer::getByIdReview($review->id);
                $admin = User::getById($answer->id_user) ?>
                <tr>
                    <td style="text-align: center;">ОТВЕТ НА ОТЗЫВ</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"><?= User::getById($answer->id_user)->name ?></td>
                    <td style="text-align: center;"><?= $answer->text ?></td>
                    <td style="text-align: center;"><?= $answer->created_date ?></td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                </tr>
        <?php endif?>
    </table>
<div class="buttons">
    <a href="/views/admin/bookings/bookings.view.php"><button>Назад</button></a>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
unset($_SESSION['post']);
unset($_SESSION['error']);
?>