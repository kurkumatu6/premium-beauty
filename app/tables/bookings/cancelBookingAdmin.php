<?php

use App\modules\Booking;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

if($_GET['text']==''){
    $_SESSION['get'] = $_GET;
    $_SESSION['error'] = 'Причина отмены не указана';
    header("Location: /views/admin/bookings/cancel.view.php");
}
else{
Booking::cancelAdmin($_SESSION['booking_id'], $_GET['text']);
header("Location: /views/admin/bookings/bookings.view.php");
}
?>