<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/header.php';
?>
<link rel="stylesheet" href="/assets/styles/courses.css">

<?php
use App\modules\Course;
use App\modules\Type;

$categories = Type::getAll();
?>

<h1>Учебные курсы</h1>
<form action="/views/users/courses/courses.view.php" method="POST">
    <div class="container">
        <div>
            <div class="parameters sort">
                <h3>Сортировка по:</h3>
                <div class="item"><input type="radio" <?php if (!isset($_POST['sorting']) || $_POST['sorting'] == 'from-new') {
                                                            echo ('checked');
                                                        } ?> id="from-new" value="from-new" name="sorting"> <label for="from-new">От новых</label></div>
                <div class="item"><input type="radio" <?php if (isset($_POST['sorting']) && $_POST['sorting'] == 'from-old') {
                                                            echo ('checked');
                                                        } ?> id="from-old" value="from-old" name="sorting"> <label for="from-old">От старых</label></div>
                <div class="item"><input type="radio" <?php if (isset($_POST['sorting']) && $_POST['sorting'] == 'from-cheap') {
                                                            echo ('checked');
                                                        } ?> id="from-cheap" value="from-cheap" name="sorting"> <label for="from-cheap">От дешевых</label></div>
                <div class="item"><input type="radio" <?php if (isset($_POST['sorting']) && $_POST['sorting'] == 'from-expensive') {
                                                            echo ('checked');
                                                        } ?> id="from-expensive" value="from-expensive" name="sorting"> <label for="from-expensive">От дорогих</label></div>
            </div>
        </div>
        <div>
            <h3>Фильтр по категории:</h3>
            <div class="parameters filter">
                <?php foreach ($categories as $category) : ?>
                    <div class="item"><input type="checkbox" <?php if (isset($_POST[$category->id])) {
                                                                    echo ('checked');
                                                                }
                                                                ?> name="<?= $category->id ?>" id="<?= $category->id ?>" value="<?= $category->id ?>"> <label for="<?= $category->id ?>"><?= $category->abb_name ?></label></div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <button name="btn">Применить</button>
</form>
<div class="courses-gallery">
    <?php
    $courses = Course::getStatusIsYes();
    if (isset($_POST['btn'])) {
        $categoryArray = $_POST;
        if (count($categoryArray) >= 1) {
            $courses = Course::getByCategoriesStatusIsYes($categoryArray);
        }
        if (count($_POST) == 2) {
            $courses = Course::getStatusIsYes();
        }
    }

    function fromNew($a, $b)
    {
        if ($a->created_date == $b->created_date) {
            return 0;
        }
        return ($a->created_date > $b->created_date) ? -1 : 1;
    }
    function fromOld($a, $b)
    {
        if ($a->created_date == $b->created_date) {
            return 0;
        }
        return ($a->created_date < $b->created_date) ? -1 : 1;
    }
    function fromChep($a, $b)
    {
        if ($a->price == $b->price) {
            return 0;
        }
        return ($a->price < $b->price) ? -1 : 1;
    }
    function fromExpensive($a, $b)
    {
        if ($a->price == $b->price) {
            return 0;
        }
        return ($a->price > $b->price) ? -1 : 1;
    }
    if (isset($_POST['sorting'])) {
        if ($_POST['sorting'] == 'from-new') {
            usort($courses, 'fromNew');
        } elseif ($_POST['sorting'] == 'from-old') {
            usort($courses, 'fromOld');
        } elseif ($_POST['sorting'] == 'from-cheap') {
            usort($courses, 'fromChep');
        } elseif ($_POST['sorting'] == 'from-expensive') {
            usort($courses, 'fromExpensive');
        }
    }
    foreach ($courses as $course) : ?>
        <div class="course">
            <img src="/assets/images/courses/<?= $course->image ?>" alt="">
            <h3><?= $course->price ?> рублей</h3>
            <p class="name"><?= $course->name ?></p>
            <div class="buttons">
                <?php if (isset($_SESSION['auth']) && $_SESSION['auth'] == 'user') : ?>
                    <a href="/views/users/courses/course-booking.view.php?id=<?= $course->id ?>"><button>Бронировать</button></a>
                <?php endif ?>
                <a href="/views/users/courses/course-more.view.php?id=<?= $course->id ?>"><button>Подробнее</button></a>
            </div>
        </div>
    <?php endforeach ?>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/footer.php';
?>