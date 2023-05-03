<?php
session_start();

use App\modules\Booking;
use App\modules\Review;
use App\modules\User;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';
Review::deleteUser($_SESSION['deleteReview']);
User::block(Booking::getById(Review::getById($_SESSION['deleteReview'])->id_booking)->id_user);
header("Location: /views/admin/reviews/reviews.view.php");
?>