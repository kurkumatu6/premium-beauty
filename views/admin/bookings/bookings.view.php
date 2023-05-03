<?php

use App\modules\Booking;
use App\modules\Course;
use App\modules\Review;
use App\modules\Status;
use App\modules\TimeTable;
use App\modules\User;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';

?>
<link rel="stylesheet" href="/assets/styles/admin/timeTable.css">
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
if (isset($_GET['idTimePlane'])) {
    $bookings = Booking::getByTimeTable($_GET['idTimePlane']);
} else {
    if (!isset($_POST['status']) || isset($_POST['status']) && $_POST['status'] == 'all') {
        $bookings = Booking::getAll();
    } else {
        $bookings = Booking::getByStatus($_POST['status']);
    }
}
$statuses = Status::getAll();
?>

<div class="buttons">
    <!-- <a href="/views/admin/timeTable/create.view.php"><button>Добавить бронирование</button></a> -->
</div>

<form action="/views/admin/bookings/bookings.view.php" method="POST">
    <div class="parameters">
        <div class="item">
            <input id="all" type="radio" name="status" value="all" onchange="this.form.submit()" <?php if (!isset($_POST['status']) || isset($_POST['status']) && $_POST['status'] == 'all') {
                                                                                                        echo ('checked');
                                                                                                    } else {
                                                                                                        echo ('');
                                                                                                    } ?>>
            <label for="all">
                <h4>Все</h4>
            </label>
        </div>
        <?php foreach ($statuses as $status) : ?>
            <div class="item">
                <input id="<?= $status->name ?>" type="radio" name="status" value="<?= $status->id ?>" onchange="this.form.submit()" <?php if (isset($_POST['status']) && $_POST['status'] == $status->id) {
                                                                                                                                            echo ('checked');
                                                                                                                                        } else {
                                                                                                                                            echo ('');
                                                                                                                                        } ?>>
                <label for="<?= $status->name ?>">
                    <h4><?= $status->name ?></h4>
                </label>
            </div>
        <?php endforeach ?>
    </div>
</form>

<?php
if (count($bookings) == 0) : ?>
    <h2>Бронирований нет</h2>
<?php else : ?>
    <table border="1">

        <tr>
            <td style="text-align: center;">Дата</td>
            <td style="text-align: center;">Курс</td>
            <td style="text-align: center;">Студент</td>
            <td style="text-align: center;">Статус</td>
            <td style="text-align: center;">Причина отмены</td>
            <td style="text-align: center;">Создан</td>
            <td style="text-align: center;">Обновлён</td>
            <td style="text-align: center;">Отзыв</td>
            <td style="text-align: center;">Действия</td>
        </tr>
        <?php
        foreach ($bookings as $booking) : ?>
            <tr>
                <td style="text-align: center;"><?= date("j", strtotime(TimeTable::getById($booking->id_timetable)->date)) . ' ' . $month_list[date("n", strtotime(TimeTable::getById($booking->id_timetable)->date))] . ' ' . date("Y", strtotime(TimeTable::getById($booking->id_timetable)->date)) . 'г ' . date("H", strtotime(TimeTable::getById($booking->id_timetable)->date)) . ':' . date("m", strtotime(TimeTable::getById($booking->id_timetable)->date)) ?></td>
                <td style="text-align: center;"><?= Course::getById(TimeTable::getById($booking->id_timetable)->course_id)->name ?></td>
                <td style="text-align: center;"><?= User::getById($booking->id_user)->name . ' ' . User::getById($booking->id_user)->surname ?></td>
                <td style="text-align: center;"><?= Status::getById($booking->id_status)->name ?></td>
                <?php if ($booking->id_status == 3 || $booking->id_status == 4) : ?>
                    <td style="text-align: center;"><?= $booking->reason_cancel ?></td>
                <?php else : ?>
                    <td style="text-align: center;"> - </td>
                <?php endif; ?>
                <td style="text-align: center;"><?= date("j", strtotime($booking->created_at)) . ' ' . $month_list[date("n", strtotime($booking->created_at))] . ' ' . date("Y", strtotime($booking->created_at)) . ' в ' . date("H", strtotime($booking->created_at)) . ':' . date("m", strtotime($booking->created_at)) ?></td>
                <td style="text-align: center;"><?= date("j", strtotime($booking->update_at)) . ' ' . $month_list[date("n", strtotime($booking->update_at))] . ' ' . date("Y", strtotime($booking->update_at)) . ' в ' . date("H", strtotime($booking->update_at)) . ':' . date("m", strtotime($booking->update_at)) ?></td>
                <?php if (Review::getByIdBooking($booking->id) == null) : ?>
                    <td style="text-align: center;">Нет</td>
                <?php else : ?>
                    <td style="text-align: center;"><a href="/views/admin/reviews/oneReview.view.php?one_review=<?=Review::getByIdBooking($booking->id)->id?>">Открыть</a></td>
                <?php endif ?>
                <td style="text-align: center;">
                    <?php if ($booking->id_status == 1) : ?>
                        <a href="/app/tables/bookings/confirm.php?booking_id=<?= $booking->id ?>">Подтвердить</a><br>
                    <?php elseif ($booking->id_status == 1 || $booking->id_status == 2) : ?>
                        <a href="/views/admin/bookings/cancel.view.php?booking_id=<?= $booking->id ?>">Отменить</a>
                    <?php else : ?>
                        <p>Действий нет</p>
                    <? endif ?>
                </td>
            <tr>
            <?php endforeach; ?>
    </table>
<?php endif ?>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
unset($_SESSION['post']);
unset($_SESSION['error']);
?>