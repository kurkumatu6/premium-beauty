<?php
use App\modules\User;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
?>

<link rel="stylesheet" href="/assets/styles/admin/users.css">
<script defer src="/assets/scripts/type.js"></script>
<?php
$users = User::noAdmin();
?>
<p class="error" style="text-align: center; color: red;"><?= $_SESSION['error-type'] ?? '' ?></p>
<h1>Пользователи</h1>
<?php if (count($users) == 0) : ?>
    <h3>Пользователей нет</h3>
<?php else : ?>
    <table border="1">
        <tr>
            <td style="text-align: center;">Имя</td>
            <td style="text-align: center;">Фамилия</td>
            <td style="text-align: center;">Логин</td>
            <td style="text-align: center;">Номер телефона</td>
            <td style="text-align: center;">Почта</td>
            <td style="text-align: center;">Страница вк</td>
            <td style="text-align: center;">Статус</td>
            <td style="text-align: center;">Действия</td>
        </tr>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td style="text-align: center;"><?= $user->name ?></td>
                <td style="text-align: center;"><?= $user->surname ?></td>
                <td style="text-align: center;"><?= $user->login ?></td>
                <td style="text-align: center;"><?= $user->phone ?></td>
                <td style="text-align: center;"><?= $user->email ?></td>
                <?php if ($user->vk == null):?>
                <td style="text-align: center;"> - </td>
                <?php else:?>
                <td style="text-align: center;"><a href="<?= $user->vk ?>"><?= $user->vk ?></a></td>
                <?php endif?>
                <?php if ($user->in_block == 'yes') : ?>
                    <td style="text-align: center;">Заблокирован</td>
                    <td style="text-align: center;"><a href="/app/tables/users/unblock.php?block_user_id=<?= $user->id ?>">Снять блокировку</a></td>
                <?php else: ?>
                    <td style="text-align: center;">Активен</td>
                    <!-- <td style="text-align: center;"><a href="/app/tables/users/block.php?block_user_id=<?= $user->id ?>">Заблокировать</a></td> -->
                    <td style="text-align: center;"><a href="/views/admin/users/block.view.php?block_user_id=<?= $user->id ?>">Заблокировать</a></td>
                <?php endif ?>
            </tr>
        <?php endforeach ?>
    </table>
<?php endif ?>
<div class="modal" id="modal-create">

    <div class="modal-content">
        <h2>Добавить новый тип наращивания ресниц</h2>
        <form action="/app/tables/types/create.php">
            <div class="item">
                <label for="">
                    <h4>Название</h4>
                </label>
                <input type="text" name="name" value="<?= $_GET['name'] ?? '' ?>">
            </div>
            <div class="item">
                <label for="">
                    <h4>Сокращённое название</h4>
                </label>
                <input type="text" name="abb-name" value="<?= $_GET['abb-name'] ?? '' ?>">
            </div>
            <div class="buttons-modal">
                <button class="btn-contour" type="submit">Сохранить</button>
                <button id="btn-close">Закрыть</button>
            </div>
        </form>

    </div>
    <p id="close">✕</p>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
unset($_SESSION['get']);
unset($_SESSION['error-type']);
?>