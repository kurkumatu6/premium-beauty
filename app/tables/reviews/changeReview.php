<?php
session_start();

use App\modules\Review;
use App\modules\User;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';
//!preg_match('/^[а-яА-Я\s\-]{3,20}$/u'
if ($_GET['text'] == '') {
    $_SESSION['error-review'] = 'Неккоректный текст отзыва';
} else {
    Review::changeText($_GET['id_review'], $_GET['text']);
}
header("Location: /views/users/reviews/reviews.view.php");
