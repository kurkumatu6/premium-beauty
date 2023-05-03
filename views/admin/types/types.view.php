<?php
use App\modules\Type;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
?>

<link rel="stylesheet" href="/assets/styles/admin/types.css">
<script defer src="/assets/scripts/type.js"></script>
<?php
$types = Type::getAll();
?>

<div class="buttons">
    <button class="btn-create">Добавить тип наращивания</button>

</div>
<p class="error" style="text-align: center; color: red;"><?= $_SESSION['error-type'] ?? '' ?></p>
<?php if (count($types) == 0) : ?>
    <h3>Типов нет</h3>
<?php else : ?>
    <table border="1">
        <tr>
            <td style="text-align: center;">Название</td>
            <td style="text-align: center;">Сокращённое название</td>
            <td style="text-align: center;">Действия</td>
        </tr>
        <?php foreach ($types as $type) : ?>
            <tr>
                <td style="text-align: center;"><?= $type->name ?></td>
                <td style="text-align: center;"><?= $type->abb_name ?></td>
                <td>
                    <a href="/app/tables/types/delete.php?delete_type_id=<?=$type->id?>">Удалить</a>
                    <a href="/views/admin/types/editType.view.php?edit_type_id=<?=$type->id?>">Изменить</a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
<?php endif ?>
<div class="modal" id="modal-create">

    <div class="modal-content" >
        <h2>Добавить новый тип наращивания ресниц</h2>
        <form action="/app/tables/types/create.php">
            <div class="item">
                <label for=""><h4>Название</h4></label>
                <input type="text" name="name" value="<?=$_GET['name'] ?? ''?>">
            </div>
            <div class="item">
                <label for=""><h4>Сокращённое название</h4></label>
                <input type="text" name="abb-name" value="<?=$_GET['abb-name'] ?? ''?>">
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