<?php


use App\modules\Answer;
use App\modules\Booking;
use App\modules\Course;
use App\modules\TimeTable;
use App\modules\User;
use App\modules\Review;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
?>

<link rel="stylesheet" href="/assets/styles/admin/reviews.css">
<script defer src="/assets/scripts/deleteReview.js"></script>
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
$courses = Course::getAll();
if (isset($_GET['idCourse'])) {
    $reviews = Review::getByCategory(($_GET['idCourse']));
} else {
    if (isset($_POST['btn'])) {
        if ($_POST['course'] == 'all') {
            $reviews = Review::getAllAdm();
        } else {
            $reviews = Review::getByCategory(($_POST['course']));
        }
    } else {
        $reviews = Review::getAllAdm();
    }
}
?>

<div class="buttons">
    <a href="/views/admin/timeTable/create.view.php"><button>Добавить день</button></a>
</div>
<form action="/views/admin/reviews/reviews.view.php" method="POST">
    <h3>Учебная программа:</h3>
    <select name="course" id="course">
        <?php if (isset($_POST['btn']) && $_POST['course'] != 'all') : ?>
            <option value="<?= $_POST['course'] ?>"><?= Course::getById($_POST['course'])->name ?></option>
            <option value="all">Все</option>
        <?php elseif (isset($_POST['btn']) && $_POST['course'] == 'all') : ?>
            <option value="all">Все</option>
        <?php else : ?>
            <?php if (isset($_GET['idCourse'])) : ?>
                <option value=""><?= Course::getById($_GET['idCourse'])->name ?></option>
                <option value="all">Все</option>
            <?php else : ?>
                <option value="">Выберите курс</option>
                <option value="all">Все</option>
            <?php endif ?>
        <?php endif ?>
        <?php foreach ($courses as $course) : ?>
            <option value="<?= $course->id ?>"><?= $course->name ?></option>
        <?php endforeach ?>
    </select>
    <button name="btn">Применить</button>
</form>
<?php if (count($reviews) == 0) : ?>
    <h3>Отзывов нет</h3>
<?php else : ?>
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
        <?php foreach ($reviews as $review) : ?>
            <tr>
                <td style="text-align: center;"><?= Course::getById(TimeTable::getById(Booking::getById($review->id_booking)->id_timetable)->course_id)->name  ?></td>
                <td style="text-align: center;"><?= date("j", strtotime(TimeTable::getById(Booking::getById($review->id_booking)->id_timetable)->date)) . ' ' . $month_list[date("n", strtotime(TimeTable::getById(Booking::getById($review->id_booking)->id_timetable)->date))] . ' ' . date("Y", strtotime(TimeTable::getById(Booking::getById($review->id_booking)->id_timetable)->date)) . ' в ' . date("H", strtotime(TimeTable::getById(Booking::getById($review->id_booking)->id_timetable)->date)) . ':' . date("m", strtotime(TimeTable::getById(Booking::getById($review->id_booking)->id_timetable)->date)) ?></td>
                <td style="text-align: center;"><?= User::getById(Booking::getById($review->id_booking)->id_user)->name . ' ' . User::getById(Booking::getById($review->id_booking)->id_user)->surname ?></td>
                <td style="text-align: center;"><?= $review->text ?></td>
                <td style="text-align: center;"><?= date("j", strtotime(TimeTable::getById(Booking::getById($review->id_booking)->id_timetable)->date)) . ' ' . $month_list[date("n", strtotime(TimeTable::getById(Booking::getById($review->id_booking)->id_timetable)->date))] . ' ' . date("Y", strtotime(TimeTable::getById(Booking::getById($review->id_booking)->id_timetable)->date)) ?>г.</td>
                <?php if ($review->update_date == null) : ?>
                    <td style="text-align: center;"> - </td>
                <?php else : ?>
                    <td style="text-align: center;"><?= date("j", strtotime($review->update_date)) . ' ' . $month_list[date("n", strtotime($review->update_date))] . ' ' . date("Y", strtotime($review->update_date)) ?>г.</td>
                <?php endif ?>
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
                    <td style="text-align: center;"><?= date("j", strtotime($answer->created_date)) . ' ' . $month_list[date("n", strtotime($answer->created_date))] . ' ' . date("Y", strtotime($answer->created_date)) ?>г.</td>
                    <td style="text-align: center;">-</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                </tr>
        <?php endif;
        endforeach ?>
    </table>
<?php endif ?>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
unset($_SESSION['post']);
unset($_SESSION['error']);
?>