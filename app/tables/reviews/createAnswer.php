<?php

use App\modules\Answer;
use App\modules\Booking;
use App\modules\Review;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

if($_GET['text']==''){
    $_SESSION['get'] = $_GET;
    $_SESSION['error'] = 'Текст не написан';
    header("Location: /views/admin/reviews/answerCreate.view.php");
}
else{
Answer::create($_SESSION['user_id'], $_SESSION['idReview'], $_GET['text']);
header("Location: /views/admin/reviews/reviews.view.php");
}
?>