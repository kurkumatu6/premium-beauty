<?php
session_start();

use App\modules\Course;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';
$course = Course::getById($_GET['course_id']);
Course::hide($course->id);
header('Location: /views/admin/courses/courses.view.php');
