
<?php
use App\modules\TimeTable;
use App\modules\Course;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';
$day = TimeTable::getById($_POST['id_day']);
$course = Course::getById($_POST['course']);

$_SESSION['post'] = $_POST;
$error = [];
if ($_POST['free_places'] > $course->max_student) {
    $error['free_places'] = 'Слишком большое количество свободных мест для выбранного курса';
}
if ($error == []) {
    $date = $_POST['date'] . ' ' . $_POST['time'];
    TimeTable::edit($_POST, $date);
    header('Location: /views/admin/timeTable/timeTable.view.php');
} else {
    $_SESSION['error'] = $error;
    header('Location: /views/admin/timeTable/edit.view.php');
}
