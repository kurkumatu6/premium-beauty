<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/header.php';

use App\modules\Course;
use App\modules\Type;
use App\modules\TimeTable;
use App\modules\Booking;

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
if (isset($_SESSION['user_id'])){
$dates = TimeTable::getTopicalByCourseId($course->id, $_SESSION['user_id']);
}
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
            <p><b>Дата создания: </b><?= date("j", strtotime($course->created_date)) . ' ' . $month_list[date("n", strtotime($course->created_date))] . ' ' . date("Y", strtotime($course->created_date)) ?>г</p>
            <br>
            <h3><?= $course->price ?> рублей</h3>

            <div class="buttons">
                <?php if (isset($_SESSION['auth']) && $_SESSION['auth'] == 'user') : ?>
                    <a href="#bokingView"><button id="btn-booking">Забронировать</button></a>
                    <a id='bokingView'></a>
                <?php else : ?>
                    <button class="btn-blocked">Забронировать</button>
                    <h5>Чтобы забронировать курс, необходимо <a href="/views/users/auth/logIn.view.php">Авторизироваться</a></h5>
                <?php endif ?>
            </div>
        </div>
    </div>
    <p id="description"><?= $course->description ?></p>
    <div class="booking">
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
                    <p><b>Максимальное кол-во обучающихся: </b> <?= $course->max_student ?> чел.</p>
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
    <div class="buttons two">
        <a href="/views/users/reviews/reviews.view.php?idCourse=<?= $course->id ?>"><button class="back">Посмотреть отзывы</button></a>
        <a href="/views/users/courses/courses.view.php"><button class="back btn-contour">Все курсы</button></a>
    </div>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/footer.php';
?>