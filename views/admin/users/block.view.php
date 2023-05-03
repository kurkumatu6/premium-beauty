<?php

use App\modules\User;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';

if(isset($_GET['block_user_id'])){
    $user = User::getById($_GET['block_user_id']);
    $_SESSION['block_user_id'] = $_GET['block_user_id'];
}
else{
    $user = User::getById($_SESSION['block_user_id']);
}
?>
<link rel="stylesheet" href="/assets/styles/admin/block-user.css">
<div class="cancel-course">
    <h1>Блокировка пользователя</h1>
    <p><b>Имя: </b><?= $user->name ?></p>
    <p><b>Фамилия: </b><?= $user->surname ?></p>
    <p><b>Почта: </b><?= $user->email ?></p>
    <form action="/app/tables/users/block.php">
        <label for="">
            <p><b>Укажите причину блокировки</b></p>
        </label>
        <textarea name="text" id="" cols="30" rows="10"><?= $_SESSION['get']['text'] ?? '' ?></textarea>
        <p id="error"><?= $_SESSION['error'] ?? '' ?></p>
        <input type="text" name="userId" value="<?=$user->id?>" style="display: none;">
        <button class="btn-contour" type="submit">Готово</button>
    </form>
</div>
<a href="/views/admin/users/users.view.php"><button>Вернуться</button></a>

<?php
unset($_SESSION['post']);
unset($_SESSION['error']);
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
