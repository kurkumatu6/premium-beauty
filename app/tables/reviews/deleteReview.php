<?php
session_start();

use App\modules\Review;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';
Review::deleteUser($_GET['id_review']);
header("Location: /views/users/reviews/reviews.view.php");
?>