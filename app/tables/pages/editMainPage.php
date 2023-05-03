<pre>
<?php

use App\modules\Element;
use App\modules\MainPage;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

$mainElement = Element::getByIdBlock($mainBlock->id)[0];

$data = [
    'title' => [
        'field_name' => 'заголовок',
        'expression' => '/^[а-яА-Яё\s\-\!\"\«\»]{20,70}$/u'
    ],
    'subtitle' => [
        'field_name' => 'подзаголовок',
        'expression' => '/^[а-яА-Яё\s\-\!\"\«\»]{30,150}$/u'
    ],
    // 'number' => [
    //     'field_name' => 'цифра',
    //     'expression' => '/^[0-9\+\-\!\"]{1,5}$/'
    // ],
    // 'text' => [
    //     'field_name' => 'текст',
    //     'expression' => '/^[а-яА-Яёa-z\s\-\!\"\«\»\<\>]{5,25}$/u'
    // ],
];

$_SESSION['post'] = $_POST;
$error = [];
foreach ($data as $value => $v) {
    if ($_POST[$value] == '') {
        $error[$value] = 'Поле не может быть пустым';
    } else {
        if ($v['expression'] != '') {
            if (!preg_match($v['expression'], $_POST[$value])) {
                $error[$value] = 'Некорректное значение поля';
            }
        }
    }
}

if ($_FILES['background']['name'] != '') {
    if ($_FILES['background']['type'] == 'image/png' || $_FILES['background']['type'] == 'image/jpeg' || $_FILES['background']['type'] == 'image/jpg') {
        unlink('C:/OSPanel/domains/premium-beauty/assets/images/main-page/' . $mainElement->background);
        $name = 'background_' . $_FILES['background']['name'];
        move_uploaded_file($_FILES['background']['tmp_name'], "C:/OSPanel/domains/premium-beauty/assets/images/main-page/" . $name);
        Element::editBackground($name);
    } else {
        $error['background'] = 'Неверный формат изображения';
    }
}
if ($_FILES['image']['name'] != '') {
    if ($_FILES['background']['type'] == 'image/png' || $_FILES['background']['type'] == 'image/jpeg' || $_FILES['background']['type'] == 'image/jpg') {
        unlink('C:/OSPanel/domains/premium-beauty/assets/images/main-page/' . $mainElement->main_photo);
        $name_image = 'image_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "C:/OSPanel/domains/premium-beauty/assets/images/main-page/" . $name_image);
        Element::editImage($name_image);
    } else {
        $error['image'] = 'Неверный формат изображения';
    }
}

if ($error != []) {
    $_SESSION['error'] = $error;
}
else{
    Element::edit($_POST);
    $_SESSION['ok'] = 'Изменения сохранены';
}
header('Location: /views/admin/pages/main/main_page.view.php');






?>
</pre>