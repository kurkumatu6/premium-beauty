<?php
session_start();

use App\modules\Review;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

Review::delete($_GET['review_delete']);
header("Location: /views/admin/reviews/reviews.view.php");