<?php

use App\modules\Block;
use App\modules\Element;
use App\modules\MainPage;

include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/header.php'; 
$mainBlock = Block::getByName('Главный');
$advBlock = Block::getByName('Преимущества');

$mainElement = Element::getByIdBlock($mainBlock->id)[0];
?>
<link rel="stylesheet" href="/assets/styles/main.css">

<div class="main" style=" background-image: url(/assets/images/main-page/<?=$mainElement->background?>);
  background-repeat: no-repeat;
  background-position: center center;
  background-attachment: fixed;">
    <div class="main-chapter">
        <div class="item photo">
            <img src="/assets/images/main-page/<?=$mainElement->main_photo?>" id="photo-teacher" alt="Преподаватель Академии Алёна Саетова" />
        </div>
        <div class="item text">
            <h1 id="title" style="text-align: left;"><?=$mainElement->title?></h1>
            <h3 id="subtitle">
            <?=$mainElement->subtitle?>
            </h3>
            <div class="buttons">
                <a href="/views/users/courses/courses.view.php"><button id="choose" class="green">Выбрать курс</button></a>
                <a href="/views/users/about.view.php"><button id="more" class="contour">Подробнее</button></a>
            </div>
        </div>
    </div>
    <div class="adv-chapter">
        <?php 
        $advElements = Element::getByIdBlock($advBlock->id);
        foreach ($advElements as $element):?>
        <div class="item">
            <h1 class="num" id="num-1"><?=$element->title?></h1>
            <h3 class="text" id="text-2"><?=$element->subtitle?></h3>
        </div>
        <?php endforeach?>
    </div>
</div>

<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/footer.php'; 
?>