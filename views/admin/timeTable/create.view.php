<?php

use App\modules\Course;

$todayDate = date('Y-m-d');

include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
?>
<link rel="stylesheet" href="/assets/styles/admin/timeTable-create.css">
<div class="timeTable-create">
    <h1>Добавить день в расписание</h1>
    <form action="/app/tables/timeTable/create.php" method="post" enctype="multipart/form-data">
        <div class="big-item">
            <div class="item">
                <p>Курс</p>
                <select name="course">
                    <?php if(isset($_SESSION['post']['course'])):?>
                        <option value="<?=$_SESSION['post']['course']?>"><?=Course::getById($_SESSION['post']['course'])->name?></option> 
                        <?php else:?>  
                    <option value="no">Не выбрано</option>
                    <?php endif?>
                    <?php 
                    $courses = Course::getAll();
                    foreach($courses as $course):?>
                    <option value="<?=$course->id?>"><?=$course->name?></option>
                    <?php endforeach?>
                </select>
            </div>
            <p class="error" style="color: red;"><?=$_SESSION['error']['course'] ?? ''?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Дата</p>
                <input name="date" value="<?=$_SESSION['post']['date'] ?? '' ?>" type="date" min="<?=$todayDate?>">
            </div>
            <p class="error" style="color: red;"><?=$_SESSION['error']['date'] ?? ''?></p>
        </div>
        <div class="big-item">
            <div class="item">
                <p>Время</p>
                <input name="time" type="time" value="<?=$_SESSION['post']['time'] ?? '' ?>">
            </div>
            <p class="error" style="color: red;"><?=$_SESSION['error']['time'] ?? ''?></p>
        </div>
        <button>Добавить</button>
    </form>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
unset($_SESSION['post']);
unset($_SESSION['error']);
?>