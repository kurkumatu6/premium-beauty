<pre>
<?php

use App\modules\Course;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';
$course = Course::getById($_POST['id_course']);

$data = [
    'name' => [
        'field_name' => 'название',
        'expression' => ''
    ],
    'price' => [
        'field_name' => 'цена',
        'expression' => ''
    ],
    'description' => [
        'field_name' => 'описание',
        'expression' => ''
    ],
    'max_student' => [
        'field_name' => 'максимально студентов',
        'expression' => ''
    ],
    'duration' => [
        'field_name' => 'длительность',
        'expression' => ''
    ],
];

$_SESSION['post'] = $_POST;
$error = [];
foreach ($data as $value => $v) {
        if ($v['expression'] != '') {
            if (!preg_match($v['expression'], $_POST[$value])) {
                $error[$value] = 'Некорректное значение поля ' . $v['field_name'] . '<br>';
            }
        }
}
if ($error == []) {
    Course::edit($_POST['id_course'], $_POST);
    if($_FILES['image']['name'] != ''){
        unlink("C:/OSPanel/domains/premium-beauty/assets/images/courses/" . $course->image);
        $name = $_POST['name'] . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "C:/OSPanel/domains/premium-beauty/assets/images/courses/" . $name);
        Course::editImage($name, $_POST['id_course']);
    }
    header('Location: /views/admin/courses/courses.view.php');
} else {
    $_SESSION['error'] = $error;
    header('Location: /views/admin/courses/create.view.php');
}
?>
</pre>
