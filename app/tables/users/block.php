<?php

use App\modules\Booking;
use App\modules\User;
use App\modules\Info;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

$user = User::getById($_GET['userId']);
if($_GET['text']==''){
    $_SESSION['get'] = $_GET;
    $_SESSION['error'] = 'Причина блокировки не указана';
    header("Location: /views/admin/users/block.view.php");
}
else{
    $text = $user->name .", здравствствуйте! \n" .
    "Информируем вас, что ваш аккаунт с логином " . $user->login . "\n" .
    "на сайте Академия наращивания ресниц Премиум бьюти " . "\nзаблокирован по следущей причине: \n" .
    $_GET['text'] . "\n" .
    'Чтобы получить доступ к аккаунта, свяжитесь с нами.' . "\n \n" .
    'Наш сайт - premium.beauty.ru' . "\n" .
    'Номер телефона - ' . Info::get()->phone .  "\n" .
    'Эллектронная почта - ' . Info::get()->email .  "\n";
    if (mail($user->email, 'Ваш аккаунт заблокирован',$text) != true){
        $_SESSION['error'] = 'Сообщение не отправлено, пользователь не заблокирован';
        header("Location: /views/admin/users/block.view.php");
    }
    else{
        User::block($user->id);
        header("Location: /views/admin/users/users.view.php");
    }
}