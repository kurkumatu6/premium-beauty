<?php
session_start();

use App\modules\Course;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';
$course = Course::getById($_GET['course_id']);
Course::delete($course->id);
unlink("C:/OSPanel/domains/premium-beauty/assets/images/courses/" . $course->image);
header('Location: /views/admin/courses/courses.view.php');
