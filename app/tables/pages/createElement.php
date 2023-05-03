<pre>
<?php

use App\modules\Element;
use App\modules\MainPage;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';
$data = [
    'title' => [
        'field_name' => 'заголовок',
        'expression' => '/^[0-9а-яА-Яё\s\-\!\"\«\»]{1,5}$/u'
    ],
    'subtitle' => [
        'field_name' => 'подзаголовок',
        'expression' => '/^[а-яА-Яёa-z\s\-\!\"\«\»\<\>]{4,25}$/u'
    ],
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

if ($error != []) {
    $_SESSION['error'] = $error;
    header('Location: /views/admin/pages/main/createElement.view.php');
}
else{
    Element::create($_POST, 1, null);
    header('Location: /views/admin/pages/main/main_page.view.php');
}







?>
</pre>