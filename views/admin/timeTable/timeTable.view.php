<?php

use App\modules\Booking;
use App\modules\Course;
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
if (!isset($_POST['category']) || isset($_POST['category']) && $_POST['category'] == 'upcoming') {
    $days = TimeTable::upcoming();
} else {
    $days = TimeTable::old();
}
?>

<div class="buttons">
    <a href="/views/admin/timeTable/create.view.php"><button>Добавить день</button></a>
</div>
<form action="/views/admin/timeTable/timeTable.view.php" method="POST">
    <div class="parameters">
        <div class="item">
            <input id="all" type="radio" name="category" value="upcoming" onchange="this.form.submit()" <?php if (!isset($_POST['category']) || isset($_POST['category']) && $_POST['category'] == 'upcoming') {
                                                                                                            echo ('checked');
                                                                                                        } else {
                                                                                                            echo ('');
                                                                                                        } ?>>
            <label for="all">
                <h4>Предстоящие</h4>
            </label>
        </div>
        <div class="item">
            <input id="teacher" type="radio" name="category" value="old" onchange="this.form.submit()" <?php if (isset($_POST['category']) && $_POST['category'] == 'old') {
                                                                                                            echo ('checked');
                                                                                                        } else {
                                                                                                            echo ('');
                                                                                                        } ?>>
            <label for="teacher">
                <h4>Прошедшие</h4>
            </label>
        </div>
    </div>
</form>
<table class="big" border="1">
    <tr>
        <td style="text-align: center;">Курс</td>
        <td style="text-align: center;">Дата</td>
        <td style="text-align: center;">Свободные</td>
        <td style="text-align: center;">Зарезервированные</td>
        <td style="text-align: center;">Подтверждённые</td>
        <td style="text-align: center;">Студенты</td>
        <td style="text-align: center;">Действия</td>
    </tr>
    <?php foreach ($days as $day) : ?>
        <tr>
            <td style="text-align: center;"><?= Course::getById($day->course_id)->name ?></td>
            <td style="text-align: center;"><?= date("j", strtotime($day->date)) . ' ' . $month_list[date("n", strtotime($day->date))] . ' ' . date("Y", strtotime($day->date)) . 'г ' . date("H", strtotime($day->date)) . ':' . date("m", strtotime($day->date))?></td>
            <td style="text-align: center;"><?= Course::getById($day->course_id)->max_student - count(Booking::getByTimeTableIsConfirm($day->id)) ?></td>
            <td style="text-align: center;"><?= count(Booking::getByTimeTable($day->id)) ?></td>
            <td style="text-align: center;"><?= count(Booking::getByTimeTableIsConfirm($day->id)) ?></td>
            <td style="text-align: center;">
                <?php
                $bookings = Booking::getByTimeTable($day->id);
                if (count($bookings) == 0) { ?>
                    <p>Бронирований нет</p>
                <?php } else { ?>
                    <table>
                        <?php foreach ($bookings as $booking) : ?>
                            <tr>
                                <td class="mini"><?= User::getById($booking->id_user)->name . ' ' . User::getById($booking->id_user)->surname ?></td>
                                <td class="mini"><?= Status::getById($booking->id_status)->name ?></td>
                                <td class="mini"><?= User::getById($booking->id_user)->phone ?></td>
                                <td class="mini"><?= User::getById($booking->id_user)->email ?></td>
                                <?php if (!isset($_POST['category']) || isset($_POST['category']) && $_POST['category'] == 'upcoming'){
                                 if ($booking->id_status == 1) : ?>
                                    <td class="mini"><a href="/app/tables/bookings/confirmInTimePlane.php?booking_id=<?= $booking->id ?>">Подтвердить</a><br></td>
                                <?php else : ?>
                                    <td class="mini">  - </td>
                                <?php endif; } ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php } ?>
            </td>
            <td style="text-align: center;">
                <?php if (count($bookings) == 0) : ?>
                    <a href="/app/tables/timeTable/delete.php?day_id=<?= $day->id ?>">Удалить</a><br>
                <?php endif ?>
                <?php if (!isset($_POST['category']) || isset($_POST['category']) && $_POST['category'] == 'upcoming') : ?>
                    <a href="/views/admin/timeTable/edit.view.php?day_id=<?= $day->id ?>">Изменить</a><br>
                <?php else : ?>
                    -
                <?php endif ?>
            </td>

        </tr>
    <?php endforeach ?>
</table>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
unset($_SESSION['post']);
unset($_SESSION['error']);
?>