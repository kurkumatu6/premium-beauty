<?php

use App\modules\Block;
use App\modules\Element;
use App\modules\Page;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
$page = Page::getById(1);
$mainElement = Element::getByIdBlock(Block::getByName('Главный')->id)[0];
$advElements = Element::getByIdBlock(Block::getByName('Преимущества')->id);
?>
<link rel="stylesheet" href="/assets/styles/admin/main.css">
<div class="admin-main">
    <h1>Изменение внешнего вида главной страницы</h1>
    <a href="/"><button class="btn-contour" id="pageOk">Посмотреть главную страницу</button></a>
    <form action="/app/tables/pages/editMainPage.php" method="post" enctype="multipart/form-data">
        <h3>Форма изменения данных</h3>
        <div class="big-item">
            <div class="item">
                <p>Фон страницы</p>
                <input name="background" type="file">
            </div>
            <p class="error" style="color: red;"><?= $_SESSION['error']['background'] ?? '' ?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Фотография</p>
                <input name="image" type="file">
            </div>
            <p class="error" style="color: red;"><?= $_SESSION['error']['image'] ?? '' ?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Заголовок</p>
                <input name="title" type="text" value="<?= $_SESSION['post']['title'] ?? $mainElement->title ?>">
            </div>
            <p class="error" style="color: red;"><?= $_SESSION['error']['title'] ?? '' ?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Подзаголовок</p>
                <input name="subtitle" type="text" value="<?= $_SESSION['post']['subtitle'] ?? $mainElement->subtitle ?>">
            </div>
            <p class="error" style="color: red;"><?= $_SESSION['error']['subtitle'] ?? '' ?></p>
        </div>
        <p><?= $_SESSION['ok'] ?? '' ?></p>
        <button>Сохранить</button>
    </form>
    <h2>Модуль "Преимущества"</h2>
    <a id="adv"></a>
    <table style="width: 900px;">
        <tr>
            <th>№</th>
            <th>Цифра</th>
            <th>Текст</th>
            <th>Действия</th>
        </tr>
        <?php
        $num = 0;
        foreach ($advElements as $element) :
            $num = $num + 1; ?>
            <tr>
                <td><?= $num ?></td>
                <td><?= $element->title ?></td>
                <td><?= $element->subtitle ?></td>
                <td><a href="/app/tables/pages/deleteElement.php?id_element=<?=$element->id?>">Удалить</a></td>
            <?php endforeach ?>
            </tr>
    </table>
    <a href="/views/admin/pages/main/createElement.view.php"><button class="dowm">Добавить элемент</button></a>

</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
unset($_SESSION['post']);
unset($_SESSION['error']);
unset($_SESSION['ok']);
?>