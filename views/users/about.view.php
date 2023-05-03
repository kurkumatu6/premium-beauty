<?php

use App\modules\Block;
use App\modules\Element;
use App\modules\Page;

include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/header.php';
$page = Page::getById(2);
?>
<link rel="stylesheet" href="/assets/styles/about.css">
<script defer src="/assets/scripts/slider.js"></script>

<div class="about">
    <?php $face = Block::getByName('Лицевой');
    $faceElement = Element::getByIdBlock($face->id)[0] ?>
    <h1><?= $page->name ?></h1>
    <hr />
    <div class="academi chapter">
        <h2><?= $faceElement->title ?></h2>
        <img class="photo-big" src="/assets/images/about/<?= $faceElement->main_photo ?>" alt="Общее фото учениц" />
        <p class="text"><?= $faceElement->text ?>
        </p>
    </div>
    <div class="tourney chapter">
        <?php $carousel = Block::getByName('Карусель');
        $carouselElement = Element::getByIdBlock($carousel->id)[0];
        $photos = Element::getAllPhotosById($carouselElement->id); 
        $num = 0?>
        <h2><?= $carouselElement->title ?></h2>
        <p style="display: none;" id="count-photo"><?=count($photos)?></p>
        <div class="slider">
            <div class="arrow" id="left" ><</div>
                    <img src="/assets/images/tournaments/<?=$photos[0]->image?>" id="<?=$num?>" class="slider-photo" alt="" style="display: block;">
                    <?php foreach($photos as $photo):
                        $num = $num+1;?>
                        <img src="/assets/images/tournaments/<?=$photo->image?>" id="<?=$num?>" class="slider-photo" alt="" style="display: none;">
                        <?php endforeach?>
            <div class="arrow" id="right">></div>
        </div>
            <p class="text"><?= $carouselElement->text ?>
            </p>
        </div>
        <div class="meetings chapter">
            <?php
            $PhTxGr = Block::getByName('Фото + текст горизонталь');;
            $PhTxGrElements = Element::getByIdBlock($PhTxGr->id);
            $x = 0; ?>
            <?php foreach ($PhTxGrElements as $element) :
                $x = $x + 1;
                if ($x % 2 != 0) : ?>
                    <h2><?= $element->title ?></h2>
                    <div class="block">
                        <div class="block-photo">
                            <img class="photo-small" src="/assets/images/about/<?= $element->main_photo ?>" alt="Процесс наращивания ресниц" />
                        </div>
                        <div class="block-text r">
                            <p>
                                <?= $element->text ?>
                            </p>
                        </div>
                    </div>
                <?php else : ?>
                    <h2><?= $element->title ?></h2>
                    <div class="block">
                        <div class="block-text l">
                            <p>
                                <?= $element->text ?>
                            </p>
                        </div>
                        <div class="block-photo">
                            <img class="photo-small" src="/assets/images/about/<?= $element->main_photo ?>" alt="Процесс наращивания ресниц" />
                        </div>
                    </div>
            <?php endif;
            endforeach ?>

        </div>
        <hr />
        <div class="chapter teacher">
            <?php
            $PhTx = Block::getByName('Фото + текст');
            $PhTxElement = Element::getByIdBlock($PhTx->id)[0]; ?>

            <h2><?= $PhTxElement->title ?></h2>
            <img src="/assets/images/about/<?= $PhTxElement->main_photo ?>" class="teacher-photo" alt="Мастер преподаватель - Саетова Алёна" />
            <p class="text">
                <?= $PhTxElement->text ?>
            </p>
        </div>
        <div class="buttons">
            <a class="app" href="#app"><button>Наверх</button></a>
        </div>

    </div>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/footer.php';
    ?>