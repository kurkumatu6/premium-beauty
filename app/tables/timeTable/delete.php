<?php
session_start();

use App\modules\Course;
use App\modules\TimeTable;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';
TimeTable::delete($_GET['day_id']);
header('Location: /views/admin/timeTable/timeTable.view.php');
