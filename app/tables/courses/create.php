<pre>
<?php

use App\modules\Course;
use App\modules\MainPage;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

$data = [
    'name' => [
        'field_name' => 'название',
        'expression' => '/^[а-яА-ЯёA-Za-z\s\-\!\"\«\»\+]{5,50}$/u'
    ],
    'price' => [
        'field_name' => 'цена',
        'expression' => '/^[0-9]{2,5}$/u'
    ],
    'description' => [
        'field_name' => 'описание',
        'expression' => '/^[а-яА-ЯёA-Za-z\s\-\!\"\«\»\+]{20,2000}$/u'
    ],
    'max_student' => [
        'field_name' => 'максимально студентов',
        'expression' => '/^[1-9]{1,2}/u'
    ],
    'duration' => [
        'field_name' => 'длительность',
        'expression' => ''
    ],
];

$_SESSION['post'] = $_POST;
$error = [];
foreach ($data as $value => $v) {
    if ($_POST[$value] == '') {
        $error[$value] = 'Поле не заполнено';
    } else {
        if ($v['expression'] != '') {
            if (!preg_match($v['expression'], $_POST[$value])) {
                $error[$value] = 'Некорректное значение поля';
            }
        }
    }
}
if ($_FILES['image']['name'] == '') {
    $error['image'] = 'Изображение не загружено';
}
elseif (
    $_FILES['image']['type'] != 'image/png' && $_FILES['image']['type']
    != 'image/jpeg' && $_FILES['image']['type'] != 'image/jpg'
) {
    $error['image'] = 'Неверный формат изображения';
}
if ($error == []) {
    
    $date = date('Y-m-d');
    $name = $_POST['name'] . '_' . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "C:/OSPanel/domains/premium-beauty/assets/images/courses/" . $name);
    Course::create($_POST, $name);
    header('Location: /views/admin/courses/courses.view.php');
} else {
    $_SESSION['error'] = $error;
    header('Location: /views/admin/courses/create.view.php');
}
?>
</pre>
