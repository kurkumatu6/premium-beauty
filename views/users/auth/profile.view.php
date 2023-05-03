<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/header.php';
?>
<link rel="stylesheet" href="/assets/styles/profile.css">
<script defer src="/assets/scripts/change-profile.js"></script>
<?php

use App\modules\Booking;
use App\modules\Course;
use App\modules\Status;
use App\modules\TimeTable;
use App\modules\User;

$user = User::getById($_SESSION['user_id']);
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

if (isset($_POST['category']) && $_POST['category'] == 'active') {
    $orders = Booking::userActive($_SESSION['user_id']);
} elseif (isset($_POST['category']) && $_POST['category'] == 'noActive') {
    $orders = Booking::userNOActive($_SESSION['user_id']);
} else {
    $orders = Booking::userActive($_SESSION['user_id']);
}

?>

<body>
    <h1>Личный кабинет</h1>
    <div class="profile">
        <div class="avatar" id="avatar">
            <div class="image"><img src="/assets/images/avatars/<?= $user->avatar ?>" alt=""></div>
            <button class="btn-change" value="avatar" id="btn-change-avatar">Изменить</button>
        </div>
        <form class="form-avatar" id="form-avatar" action="/app/tables/users/changeAvatar.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="avatar"><button id="form-avatar-btn">Готово</button>
        </form>

        <div class="info">
            <div class="item fio" id="fio">
                <?php if ($user->role == 'admin') : ?>
                    <h3><?= $user->name . ' ' . $user->surname . ' ' . $user->role ?></h3><button class="btn-change" value="fio">Изменить</button>
                <?php else : ?>
                    <h3><?= $user->name . ' ' . $user->surname ?></h3><button class="btn-change" value="fio">Изменить</button>
                <?php endif ?>
            </div>

            <form class="fio" id="form-fio" action="/app/tables/users/changeName.php">
                <input type="text" name="name" value="<?= $user->name ?>"> <input name="surname" type="text" value="<?= $user->surname ?>"><button>Готово</button>
            </form>

            <div class="item">
                <p><b>Логин: </b><?= $user->login ?></p><a href=""></a>
            </div>
            <div class="item phone" id="phone">
                <p><b>Номер телефона: </b><?= $user->phone ?></p><button class="btn-change" value="phone">Изменить</button>
            </div>
            <form class="phone" id="form-phone" action="/app/tables/users/changePhone.php">
                <input type="text" name="phone" value="<?= $user->phone ?>"> <button>Готово</button>
            </form>
            <div class="item email" id="email">
                <p><b>Почта: </b><?= $user->email ?></p><button class="btn-change" value="email">Изменить</button>
            </div>
            <form class="email" id="form-email" action="/app/tables/users/changeemail.php">
                <input type="text" name="email" value="<?= $user->email ?>"> <button>Готово</button>
            </form>

            <div class="item vk" id="vk">
                <p><b>Страница вк: </b><?php if ($user->vk == null) {
                                            echo ('Данных нет');
                                        } else {
                                            echo ($user->vk);
                                        } ?></p><button class="btn-change" value="vk"><?php if ($user->vk == null) {
                                                                                            echo ('Добавить');
                                                                                        } else {
                                                                                            echo ('Изменить');
                                                                                        } ?></button>
            </div>
            <form class="vk" id="form-vk" action="/app/tables/users/changeVk.php">
                <input type="text" name="vk" value="<?= $user->vk ?>"> <button>Готово</button>
            </form>
            <div class="item">
                <p id="error"><?= $_SESSION['error-profile'] ?? '' ?></p>
            </div>
        </div>
    </div>
    <h1>Бронирования</h1>
    <a id="bookings"></a>
    <form action="/views/users/auth/profile.view.php#bookings" method="POST">
        <div class="item">
            <input id="teacher" type="radio" name="category" value="active" onchange="this.form.submit()" <?php if (!isset($_POST['category']) || isset($_POST['category']) && $_POST['category'] == 'active') {
                                                                                                                echo ('checked');
                                                                                                            } else {
                                                                                                                echo ('');
                                                                                                            } ?>>
            <label for="teacher">
                <h4>Активные</h4>
            </label>
        </div>
        <div class="item">
            <input id="student" type="radio" name="category" value="noActive" onchange="this.form.submit()" <?php if (isset($_POST['category']) && $_POST['category'] == 'noActive') {
                                                                                                                echo ('checked');
                                                                                                            } else {
                                                                                                                echo ('');
                                                                                                            } ?>>
            <label for="student">
                <h4>Отменённые и завершённые</h4>
            </label>
        </div>
    </form>
    <div class="orders">
        <?php if ($orders == null) : ?>
            <p>Бронирований нет</p>
        <?php else : ?>
            <?php foreach ($orders as $order) :
                $date = TimeTable::getById($order->id_timetable)->date ?>
                <div class="order">
                    <h3><?= Course::getById(TimeTable::getById($order->id_timetable)->course_id)->name ?></h3>
                    <p><b>Дата: </b><?= date("j", strtotime($date)) . ' ' . $month_list[date("n", strtotime($date))] . ' ' . date("Y", strtotime($date)) ?></p>
                    <p><b>Время: </b><?= date("H:i", strtotime($date)) ?></p>
                    <p><b>Статус: </b><?= Status::getById($order->id_status)->name ?></p>
                    <?php if ($order->id_status == 3 || $order->id_status == 4) : ?>
                        <p><b>Причина отмены: </b><?= $order->reason_cancel ?></p>
                    <?php elseif ($order->id_status != 5) : ?>
                        <a href="/views/users/courses/cancel-booking.view.php?booking_id=<?= $order->id ?>">Отменить</a>
                    <?php endif ?>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
    <hr>
    <div class="buttons">
        <a href="/app/tables/users/exit.php"><h4 class="exit">Выйти из аккаунта</h4></a>
    </div>
    <hr>
</body>

<?php
unset($_SESSION['error-profile']);
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/footer.php';
