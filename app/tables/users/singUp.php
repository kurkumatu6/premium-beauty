<?php
session_start();

use App\modules\User;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

$data = [
    'name' => [
        'field_name' => 'имя',
        'expression' => '/^[а-яА-Я\s\-]{3,20}$/u'
    ],
    'surname' => [
        'field_name' => 'фамилия',
        'expression' => '/^[а-яА-Я\s\-]{3,20}$/u'
    ],
    'login' => [
        'field_name' => 'логин',
        'expression' => '/^[a-z0-9\-]{3,20}$/'
    ],
    'phone' => [
        'field_name' => 'номер телефона',
        'expression' => '/^(\+7)[\d]{10}|(89)[\d]{9}$/u'
    ],
    'email' => [
        'field_name' => 'почта',
        'expression' => '/^\w*@mail\.ru|@gmail\.com|@bk\.ru$/'
    ],
    'password' => [
        'field_name' => 'пароль',
        'expression' => '/^[а-яА-Яa-zA-Z0-9]{6,40}$/u'
    ],
    'password_repeat' => [
        'required' => 1,
        'field_name' => 'подтверждение пароля',
        'expression' => ''
    ],
    'rules' => [
        'field_name' => 'согласие с политикой',
        'expression' => ''
    ]
];

function validate($data)
{
    $error = [];
    $num = 0;
    foreach ($data as $value => $v) {
        if ($_POST[$value] == '') {
            $error[$value] = 'Поле ' . $v['field_name'] . ' не заполнено <br>';
            $num += 1;
        } else {
            if ($v['expression'] != '') {
                if (!preg_match($v['expression'], $_POST[$value])) {
                    $error[$value] = 'Некорректное значение поля ' . $v['field_name'] . '<br>';
                }
            }
        }
    }
    if ($num == 8) {
        $error = [];
        $error['all'] = 'Заполните форму';
    } else {
        if (User::getByLogin($_POST['login']) != null) {
            $error['login'] = 'Пользователь с таким логином уже существует <br>';
        }
        if (User::getByEmail($_POST['email']) != null) {
            $error['email'] = 'Пользователь с такой почтой уже существует <br>';
        }
        if ($_POST['password'] != $_POST['password_repeat']) {
            $error['all'] = 'Пароли не совпадают <br>';
        }
        if (!isset($_POST['rules']) || $_POST['rules'] == "off") {
            $error['all'] = 'Необходимо согласиться с политикой <br>';
        }
    }
    return $error;
}



if (isset($_POST['btn_singUp'])) {
    $_SESSION['post'] = $_POST;
    $_SESSION['error'] = validate($data);
    if (empty($_SESSION['error'])) {
        if (User::singUp($_POST)) {
            $_SESSION['auth'] = true;
            $user = User::ByLoginAndPassword($_POST['login'], $_POST['password']);
            $_SESSION['user_id'] = $user->id;
            header("Location: /views/users/auth/profile.view.php");
            die();
        }
    } else {
        header("Location: /views/users/auth/singUp.view.php");
        die();
    }
}
