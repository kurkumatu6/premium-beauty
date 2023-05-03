<?php

use App\modules\Booking;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

$_SESSION['result'] = Booking::create($_SESSION['user_id'], $_GET['timePlane']);
header('Location: /views/users/courses/booking-result.view.php');
?>
