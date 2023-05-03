<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/header.php';
$result = $_SESSION['result'];
?>
<link rel="stylesheet" href="/assets/styles/booking-result.css">

<div id="indent"></div>
<div class="booking-result">

    <?php if($result == true):?>
    <h1>Успешно</h1>
    <p>Бронирование курса прошло успешно <br> Следите за статус в личном кабинете <br> Спасибо, что выбрали нас!</p>
    <div class="buttons">
        <a href="/"><button>На главную</button></a>
        <a href="/views/users/auth/profile.view.php"><button class="btn-contour">В личный кабинет</button></a>
    </div>
    <?php else:?>
        <h1>Что-то пошло не так</h1>
    <p><?=$result?></p>
    <div class="buttons">
        <a href="/"><button>На главную</button></a>
        <a href="/views/users/auth/profile.view.php"><button class="btn-contour">В личный кабинет</button></a>
        <?php endif?>
    </div>
    <div id="indent"></div>
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/footer.php';
    ?>