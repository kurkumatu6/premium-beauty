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
if(isset($_GET['course_id'])){
    $course_id = $_GET['course_id'];
    $_SESSION['course_id'] = $_GET['course_id'];
}
else{
    $course_id = $_SESSION['course_id'];
}


if (!isset($_POST['status']) || isset($_POST['status']) && $_POST['status'] == 'all') {
    $bookings = Booking::getByCourseId($course_id);
} else {
    $bookings = Booking::getByCourseIdStatusId($course_id, $_POST['status']);
}
$statuses = Status::getAll();
?>

<form action="/views/admin/bookings/bookingsCourse.view.php" method="POST">
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
                <input id="<?= $status->name ?>" type="radio" name="status" value="<?= $status->id ?>" onchange="this.form.submit()" <?php if (isset($_POST['category']) && $_POST['category'] == $status->id) {
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
if ($bookings == null || count($bookings) == 0) : ?>
    <h2>Бронирований нет</h2>
<?php else : ?>
    <table border="1">

        <tr>
            <td style="text-align: center;">id</td>
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
                <td style="text-align: center;"><?= $booking->id ?></td>
                <td style="text-align: center;"><?= TimeTable::getById($booking->id_timetable)->date ?></td>
                <td style="text-align: center;"><?= Course::getById(TimeTable::getById($booking->id_timetable)->course_id)->name ?></td>
                <td style="text-align: center;"><?= User::getById($booking->id_user)->name . ' ' . User::getById($booking->id_user)->surname ?></td>
                <td style="text-align: center;"><?= Status::getById($booking->id_status)->name ?></td>
                <?php if ($booking->id_status == 3 || $booking->id_status == 4) : ?>
                    <td style="text-align: center;"><?= $booking->reason_cancel ?></td>
                <?php else : ?>
                    <td style="text-align: center;"> - </td>
                <?php endif; ?>
                <td style="text-align: center;"><?= $booking->created_at ?></td>
                <td style="text-align: center;"><?= $booking->update_at ?></td>
                <?php if (Review::getByIdBooking($booking->id) == null) : ?>
                    <td style="text-align: center;">Нет</td>
                <?php else : ?>
                    <td style="text-align: center;">Есть</td>
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