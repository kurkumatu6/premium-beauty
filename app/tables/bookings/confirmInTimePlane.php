<?php

use App\modules\Booking;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

Booking::changeStatus(2, $_GET['booking_id']);
header('Location: /views/admin/timeTable/timeTable.view.php');
?>
<img src="/views/admin/timeTable/timeTable.view.php" alt="">
