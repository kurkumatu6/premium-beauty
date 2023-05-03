<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/header.php';

use App\modules\Booking;
use App\modules\Course;
use App\modules\TimeTable;
use App\modules\Type;

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

$course = Course::getById($_GET['id']);
$categories = Type::idInCourse($_GET['id']);
$dates = TimeTable::getTopicalByCourseId($course->id, $_SESSION['user_id']);
?>
<link rel="stylesheet" href="/assets/styles/more-course.css">
<script defer src="/assets/scripts/booking.js"></script>

<div class="course">
    <div class="head">
        <img src="/assets/images/courses/<?= $course->image ?>" alt="">
        <div class="info">
            <h2><?= $course->name ?></h2>
            <br>
            <p><b>Максимально человек: </b><?= $course->max_student ?></p>
            <p><b>Категории: </b><?= Type::categoriesInString($categories) ?></p>
            <p><b>Дата создания: </b><?= $course->created_date ?></p>
            <br>
            <h3><?= $course->price ?> рублей</h3>
        </div>
    </div>
    <div style="display: block;" class="booking">
        <h2>Бронирование курса: <?= $course->name ?></h2>
        <?php if ($dates == null) : ?>
            <p>На данный момент свободных мест нет</p>
            <a href="/views/users/courses/courses.view.php"><button id="back">Назад</button></a>
        <?php else : ?>
            <form action="/app/tables/bookings/createBoking.php">
                <div class="item f">
                    <label for="">
                        <p><b>Выберите удобную дату: </b></p>
                    </label>
                    <select name="timePlane">

                        <?php foreach ($dates as $date) : ?>
                            <option value="<?= $date->id ?>"><?= date("j", strtotime($date->date)) . ' ' . $month_list[date("n", strtotime($date->date))] . ' в ' . date("H", strtotime($date->date)) . ':' . date("m", strtotime($date->date)) ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="item">
                    <p><b>Длительность: </b> примерно <?= $course->duration ?></p>
                </div>
                <div class="item">
                    <p><b>Максимальное кол-во обучающихся: </b> <?= $course->max_student ?> человек</p>
                </div>
                <div class="item">
                    <p><b>Кол-во записанных на курс: </b> <?= count(Booking::getByTimeTable($date->id)) ?> чел.</p>
                </div>
                <div class="item">
                    <p><b>С собой принести: </b> пинцеты: прямой и загнутый</p>
                </div>
                <p><b>Стоимость: </b><?= $course->price ?> рублей</p>
                <button type="submit">Подтвердить</button>
            </form>
            <a href="/views/users/courses/course-more.view.php?id=<?= $course->id ?>"><button id="cancel">Отмена</button></a>
        <?php endif ?>
        

    </div>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/footer.php';
?>