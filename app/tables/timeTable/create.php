
<?php

use App\modules\Course;
use App\modules\TimeTable;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

$_SESSION['post'] = $_POST;
$error = [];
$course = Course::getById($_POST['course']);
if ($_POST['course'] == 'no') {
    $error['course'] = 'Поле не заполнено';
}
if ($_POST['date'] == '') {
    $error['date'] = 'Поле не заполнено';
}
if ($_POST['time'] == '') {
    $error['time'] = 'Поле не заполнено';
}
if ($error == []) {
    $date = $_POST['date'] . ' ' . $_POST['time'];
    TimeTable::create($_POST, $date);
    header('Location: /views/admin/timeTable/timeTable.view.php');
} else {
    $_SESSION['error'] = $error;
    header('Location: /views/admin/timeTable/create.view.php');
}
