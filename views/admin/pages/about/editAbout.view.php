<?php

use App\modules\Block;
use App\modules\Element;
use App\modules\Page;

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
$page = Page::getById(2);
$blocks = Block::getByIdPage(2);
?>
<link rel="stylesheet" href="/assets/styles/admin/main.css">
<div class="admin-main">
    <h1>Изменение внешнего вида страницы "<?= $page->name ?>"</h1>
    <a href="/views/users/about.view.php"><button class="btn-contour" id="pageOk">Посмотреть страницу</button></a>
    <p><?= $_SESSION['ok'] ?? '' ?></p>
    <form action="/app/tables/pages/editAbout.php" method="post" enctype="multipart/form-data">
        <div class="big-item">
            <div class="item">
                <p>Название страницы:</p>
                <input name="name" type="text" value="<?= $_SESSION['post']['name'] ?? $page->name ?>">
            </div>
            <p class="error" style="color: red;"><?= $_SESSION['error']['name'] ?? '' ?></p>
        </div>
        <?php foreach ($blocks as $block) :
            $elements = Element::getByIdBlock($block->id); ?>
            <div class="group-block">
                <h3>Блок: "<?= $block->name ?>"</h3>
                <?php if (count(Element::getByIdBlock($block->id)) > 1) : ?>
<div class="block">
                    <?php foreach ($elements as $element) : ?>
                        <div class="group-in-element">
                            <div class="photo-and-text">
                                <img class="photo" src="/assets/images/about/<?= $element->main_photo ?>" alt="">
                                <p><?= $element->text ?></p>

                            </div>
                            <a id="delete" href="/app/tables/pages/deleteElementAbout.php?id_element=<?= $element->id ?>">Удалить</a>
                        </div>

                    <?php endforeach ?>
                    <br>
                    <a id="add" href="/views/admin/pages/about/createElement.view.php">Добавить элемент</a>
                    </div>

                <?php else : ?>
                    <?php foreach ($elements as $element) : ?>
                        <?php if ($element->title != null) : ?>
                            <div class="big-item">
                                <div class="item">
                                    <p>Заголовок</p>
                                    <input name="title<?= $block->id ?>" type="text" value="<?= $_SESSION['post']['title' . $block->id] ?? $element->title ?>">
                                </div>
                                <p class="error" style="color: red;"><?= $_SESSION['error']['title' . $block->id] ?? '' ?></p>
                            </div>
                        <?php endif ?>
                        <?php if ($block->name == 'Карусель') :
                            $caruselElement = Element::getByIdBlock($block->id)[0]; ?>
                            <a id="carusel"></a>
                            <h3>Элементы карусели:</h3>
                            <a id="carusel"></a>
                            <div class="big-carusel">
                            <div class="carusel">
                            <?php $photos =  Element::getAllPhotosById($caruselElement->id);
                            if (count($photos) == 1) : ?>

                                        <img class="mini-photo" src="/assets/images/tournaments/<?= $photos[0]->image ?>" alt="">
     
                                <?php else :
                                foreach ($photos as $photo) : ?>
                           <div class="photo-carusel">
                                            <img class="mini-photo" src="/assets/images/tournaments/<?= $photo->image ?>" alt="">
                            
                                    <a href="/app/tables/pages/deleteCaruselPhoto.php?id_photo=<?= $photo->id ?>">Удалить</a>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                            </div>
                            <a id="add2" href="/views/admin/pages/about/addPhotoINvarusel.view.php">Добавить фото</a>
                            </div>
                        <?php endif ?>
                        <?php if ($element->subtitle != null) : ?>
                            <div class="big-item">
                                <div class="item">
                                    <p>Подзаголовок</p>
                                    <input name="subtitle<?= $block->id ?>" type="text" value="<?= $_SESSION['post']['subtitle' . $block->id] ?? $element->title ?>">
                                </div>
                                <p class="error" style="color: red;"><?= $_SESSION['error']['subtitle' . $block->id] ?? '' ?></p>
                            </div>
                        <?php endif ?>

                        <?php if ($element->main_photo != null) : ?>
                            <div class="big-item">
                                <div class="item">
                                    <p>Главное фото</p>
                                    <input name="image<?= $block->id ?>" type="file">
                                </div>
                                <p class="error" style="color: red;"><?= $_SESSION['error']['image' . $block->id] ?? '' ?></p>
                            </div>
                        <?php endif ?>

                        <?php if ($element->text != null) : ?>
                            <div class="big-item">
                                <div class="item">
                                    <p>Текст</p>
                                    <textarea name="text<?= $block->id ?>" id="" cols="30" rows="10"> <?= $_SESSION['post']['text .$block->id'] ?? $element->text ?></textarea>
                                </div>
                                <p class="error" style="color: red;"><?= $_SESSION['error']['text' . $block->id] ?? '' ?></p>
                            </div>
                        <?php endif ?>

                <?php endforeach;
                endif ?>
            </div>
        <?php endforeach ?>

        <button type="submit">Сохранить</button>
    </form>

</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
unset($_SESSION['post']);
unset($_SESSION['error']);
unset($_SESSION['ok']);
?>