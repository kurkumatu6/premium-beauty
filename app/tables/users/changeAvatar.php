<?php
session_start();

use App\modules\User;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

$user = User::getById($_SESSION['user_id']);

$_SESSION['error-profile'] = '';
if ($_FILES['avatar']['name'] == '') {
    $_SESSION['error-profile'] = 'Аватар не загружен';
}
elseif (
    $_FILES['avatar']['type'] != 'image/png' && $_FILES['avatar']['type']
    != 'image/jpeg' && $_FILES['avatar']['type'] != 'image/jpg'
) {
    $_SESSION['error-profile'] = 'Неверный формат аватарки';
}
$nameAvatar = 'user-' . $user->id;
if ($_SESSION['error-profile'] == '') {
    if ($user->avatar != 'default-1.png' && $user->avatar != 'default-2.png' && $user->avatar != 'default-3.png') {
        unlink('C:/OSPanel/domains/premium-beauty/assets/images/avatars/' . $user->avatar);
    }
    $img = $nameAvatar . '_' . $_FILES['avatar']['name'];
    move_uploaded_file($_FILES['avatar']['tmp_name'], "C:/OSPanel/domains/premium-beauty/assets/images/avatars/" . $img);
    User::changeAvatar($img, $_SESSION['user_id']);
    header("Location: /views/users/auth/profile.view.php");
}
header("Location: /views/users/auth/profile.view.php");
