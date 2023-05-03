<pre>
<?php

use App\modules\Info;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

$data = [
    'phone' => [
        'field_name' => 'номер телефона',
        'expression' => ''
    ],
    'email' => [
        'field_name' => 'эллектроная почта',
        'expression' => ''
    ]
];

$_SESSION['post'] = $_POST;
$error = [];
foreach ($data as $value => $v) {
    if ($_POST[$value] == '') {
        $error[$value] = 'Поле не может быть пустым';
    } else {
        if ($v['expression'] != '') {
            if (!preg_match($v['expression'], $_POST[$value])) {
                $error[$value] = 'Некорректное значение поля ' . $v['field_name'] . '<br>';
            }
        }
    }
}


if ($_FILES['logo']['name'] != '') {
    if ($_FILES['logo']['type'] == 'image/png' || $_FILES['logo']['type'] == 'image/jpeg' || $_FILES['logo']['type'] == 'image/jpg') {
        unlink('C:/OSPanel/domains/premium-beauty/assets/images/templates/' . Info::get()->logo);
        $logo = 'logo_' . $_FILES['logo']['name'];
        move_uploaded_file($_FILES['logo']['tmp_name'], "C:/OSPanel/domains/premium-beauty/assets/images/templates/" . $logo);
        Info::editLogo($logo);
    } else {
        $error['logo'] = 'Неверный формат изображения';
    }
}
if ($_FILES['white_logo']['name'] != '') {
    if ($_FILES['white_logo']['type'] == 'image/png' || $_FILES['white_logo']['type'] == 'image/jpeg' || $_FILES['white_logo']['type'] == 'image/jpg') {
        unlink('C:/OSPanel/domains/premium-beauty/assets/images/templates/' . Info::get()->white_logo);
        $white_logo = 'white_logo_' . $_FILES['white_logo']['name'];
        move_uploaded_file($_FILES['white_logo']['tmp_name'], "C:/OSPanel/domains/premium-beauty/assets/images/templates/" . $white_logo);
        Info::editWhiteLogo($white_logo);
    } else {
        $error['white_logo'] = 'Неверный формат изображения';
    }
}
if ($error == []) {
    Info::edit($_POST);
    header('Location: /');
} else {
    $_SESSION['error'] = $error;
    header('Location: /views/admin/information.view.php');
}






?>
</pre>