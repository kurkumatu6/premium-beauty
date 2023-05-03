<?php

use App\modules\Type;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
?>

<link rel="stylesheet" href="/assets/styles/admin/edit-type.css">
<script defer src="/assets/scripts/type.js"></script>
<?php
if (isset($_GET['edit_type_id'])) {
    $type = Type::findById($_GET['edit_type_id']);
    $_SESSION['edit_type_id'] = $_GET['edit_type_id'];
} else {
    $type = Type::findById($_SESSION['edit_type_id']);
}
?>
<h1>Изменение типа наращивания</h1>
<p class="error" style="text-align: center; color: red;"><?= $_SESSION['error-type'] ?? '' ?></p>
<form action="/app/tables/types/edit.php">
    <div class="item">
        <label for="">
            <h4>Название</h4>
        </label>
        <input type="text" name="name" value="<?= $_SESSION['get']['name'] ?? $type->name ?>">
    </div>
    <div class="item">
        <label for="">
            <h4>Сокращённое название</h4>
        </label>
        <input type="text" name="abb_name" value="<?= $_SESSION['get']['abb_name'] ?? $type->abb_name ?>">
    </div>
    <input style="display: none;" type="text" name="id" value="<?=$type->id?>">
    <div class="buttons-modal">
        <button class="btn-contour" type="submit">Сохранить</button>
        <a href="/views/admin/types/types.view.php"><button id="btn-close">Назад</button></a>
    </div>
</form>

<h1> </h1>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
unset($_SESSION['get']);
unset($_SESSION['error-type']);
?>