<?php
session_start();

use App\modules\Booking;
use App\modules\Review;
use App\modules\TimeTable;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

$bad = ["хуй", "залупа", "пенис", "пизда", "хер", "блядь", "бля", "ебать", "ебаться", "член", "пидарас", "пидорас", "пидр", "гандон", "мразь", "хуйло", "уебан", "тварь", "сука", "шлюха", "мудак", "дрочить", "дрочила", "МАТ"];

if ($_GET['text'] == '' or $_GET['booking'] == '') {
    $_SESSION['get'] = $_GET;
    $_SESSION['error'][0] = 'Не все поля заполнены';
    header("Location: /views/users/reviews/createReview.view.php");
} else {
    $worlds = array_filter(explode(' ', $_GET['text']));
    $a = 0;
    if (count($worlds) == 1) {
        foreach ($bad as $b) {
            if ($worlds[0] == $b) {
                $a = 'f';
            }
        }
    } else {
        foreach ($bad as $b) {
            if ($worlds[0] == $b) {
                $a = 'f';
            }
        }
        foreach ($bad as $b) {
            if (array_search($b, $worlds) != false) {
                $a = 'f';
            }
        }
    }
    if ($a == 0) {
        Review::create($_GET['booking'], $_GET['text']);
        header("Location: /views/users/reviews/reviews.view.php");
    } else {
        $_SESSION['get'] = $_GET;
        $_SESSION['error'][0] = 'Неккоректный отзыв';
        header("Location: /views/users/reviews/createReview.view.php");
    }
}
