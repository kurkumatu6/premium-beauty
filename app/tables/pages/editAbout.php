<pre>
<?php

use App\modules\Element;
use App\modules\Page;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

$data = [
    'name' => [
        'id_block' => '',
        'field_name' => 'название страницы',
        'expression' => '/^[а-яА-Яё\s\-\!\"\«\»]{3,60}$/u'
    ],
    // Лицевой блок
    'title6' => [
        'id_block' => '6',
        'field_name' => 'заголовок',
        'expression' => '/^[а-яА-Яё\s\-\!\"\«\»]{5,60}$/u'
    ],
    'text6' => [
        'id_block' => '6',
        'field_name' => 'текст',
        'expression' => ''
    ],
    // Карусель
    'title4' => [
        'id_block' => '4',
        'field_name' => 'заголовок',
        'expression' => '/^[а-яА-Яё\s\-\!\"\«\»]{5,60}$/u'
    ],
    'text4' => [
        'id_block' => '4',
        'field_name' => 'текст',
        'expression' => ''
    ],
    // Преподаватель
    'title3' => [
        'id_block' => '3',
        'field_name' => 'заголовок',
        'expression' => '/^[а-яА-Яё\s\-\!\"\«\»]{5,60}$/u'
    ],
    'text3' => [
        'id_block' => '3',
        'field_name' => 'текст',
        'expression' => ''
    ],
];

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

if ($error == []){
    Page::editName($_POST['name'], 2);
    Element::editInfoByBlockId($_POST['title6'], $_POST['text6'], 6);
    Element::editInfoByBlockId($_POST['title4'], $_POST['text4'], 4);
    Element::editInfoByBlockId($_POST['title3'], $_POST['text3'], 3);
    $_SESSION['post'] = $_POST;
    $_SESSION['ok'] = 'Изминения сохранены';
}
else{
    $_SESSION['error'] = $error;

}
header('Location: /views/admin/pages/about/editAbout.view.php');
?>
</pre>