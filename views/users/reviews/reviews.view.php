<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/header.php';

use App\modules\Type;
use App\modules\Review;
use App\modules\User;
use App\modules\Course;
use App\modules\Answer;
use App\modules\Booking;
use App\modules\TimeTable;

$month_list = array(
    1  => 'января',
    2  => 'февраля',
    3  => 'марта',
    4  => 'апреля',
    5  => 'мая',
    6  => 'июня',
    7  => 'июля',
    8  => 'августа',
    9  => 'сентября',
    10 => 'октября',
    11 => 'ноября',
    12 => 'декабря'
);

$courses = Course::getAll();
?>
<link rel="stylesheet" href="/assets/styles/reviews.css">
<script defer src="/assets/scripts/review.js"></script>
<div class="reviews">
    <h1>Отзывы</h1>

    <form action="/views/users/reviews/reviews.view.php" method="POST">
        <h3>Учебная программа:</h3>
        <select name="course" id="course">
            <?php if (isset($_POST['btn']) && $_POST['course'] != 'all') : ?>
                <option value="<?= $_POST['course'] ?>"><?= Course::getById($_POST['course'])->name ?></option>
                <option value="all">Все</option>
            <?php elseif (isset($_POST['btn']) && $_POST['course'] == 'all') : ?>
                <option value="all">Все</option>
            <?php else : ?>
                <?php if (isset($_GET['idCourse'])) : ?>
                    <option value=""><?= Course::getById($_GET['idCourse'])->name ?></option>
                    <option value="all">Все</option>
                <?php else : ?>
                    <option value="">Выберите курс</option>
                    <option value="all">Все</option>
                <?php endif ?>
            <?php endif ?>
            <?php foreach ($courses as $course) : ?>
                <option value="<?= $course->id ?>"><?= $course->name ?></option>
            <?php endforeach ?>
        </select>
        <button name="btn">Применить</button>
    </form>

    <?php if (isset($_SESSION['auth']) && $_SESSION['auth'] == 'user') : ?>
        <?php if (Booking::forReview($_SESSION['user_id']) == null) : ?>
            <button id="btn_review_not" class="btn_review">Оставить отзыв</button>
        <?php else : ?>
            <a href="/views/users/reviews/createReview.view.php"><button class="btn_review">Оставить отзыв</button></a>
        <?php endif ?>
    <?php endif ?>


    <div class="gallery">
        <?php
        if (isset($_GET['idCourse'])) {
            $reviews = Review::getByCategory(($_GET['idCourse']));
        } else {
            if (isset($_POST['btn'])) {
                if ($_POST['course'] == 'all') {
                    $reviews = Review::getAll();
                } else {
                    $reviews = Review::getByCategory(($_POST['course']));
                }
            } else {
                $reviews = Review::getAll();
            }
        }

        if (count($reviews) == 0) : ?>
            <h2>Отзывов нет</h2>
            <?php else :
            foreach ($reviews as $review) :
                $user = User::getById(Booking::getById($review->id_booking)->id_user);
                $course = Course::getById(TimeTable::getById(Booking::getById($review->id_booking)->id_timetable)->course_id); ?>
                <div class="review">
                    <div class="avatar"><img class="images" src="/assets/images/avatars/<?= $user->avatar ?>" alt="Имя Фамилия" /></div>
                    <div class="info">
                        <h3><?= $user->name . ' ' . $user->surname ?></h3>
                        <p class="text" id="<?= $review->id ?>">
                            <?= $review->text ?>
                        </p>
                        <form action="/app/tables/reviews/changeReview.php" class="form-change" id="form-<?= $review->id ?>">
                            <textarea name="text" id="" cols="30" rows="10"><?= $review->text ?></textarea>
                            <input type="text" name="id_review" value="<?= $review->id ?>" style="display: none;">
                            <button>Готово</button>
                        </form>
                        <div class="small-info">
                            <div class="date">
                                <h5 class="item">Создан: <?= date("j", strtotime($review->created_date)) . ' ' . $month_list[date("n", strtotime($review->created_date))] . ' ' . date("Y", strtotime($review->created_date)) ?>г.</h5>
                                <?php if ($review->update_date != null) : ?>
                                    <h5 class="item">Изменён: <?= date("j", strtotime($review->update_date)) . ' ' . $month_list[date("n", strtotime($review->update_date))] . ' ' . date("Y", strtotime($review->update_date)) ?>г.</h5>
                                <?php endif ?>
                            </div>
                            <a href="/views/users/courses/course-more.view.php?id=<?= $review->id_course ?>">
                                <h5 class="item btn"> <?= $course->name ?></h5>
                            </a>
                            <?php if (isset($_SESSION['user_id']) && $user->id == $_SESSION['user_id']) : ?>
                                <div class="buttons-mini">
                                    <button class="edit-btn btn" value="<?= $review->id ?>">
                                        <h5>Редактировать</h5>
                                    </button>
                                    <a  href="/app/tables/reviews/deleteReview.php?id_review=<?= $review->id ?>">
                                        <h5 class="btn">Удалить</h5>
                                    </a>
                                </div>
                            <?php endif ?>
                            <p><?= $_SESSION['error-review'] ?? '' ?></p>
                        </div>
                    </div>
                </div>

                <?php
                if (Answer::getByIdReview($review->id) != null) :
                    $answer = Answer::getByIdReview($review->id);
                    $admin = User::getById($answer->id_user) ?>
                    <div class="review answer">
                        <div class="info">
                            <h5>Ответ на отзыв</h5>
                            <h3>Администратор <?= $admin->name ?></h3>
                            <p class="textAnswer">
                                <?= $answer->text ?>
                            </p>
                            <div class="small-info">
                                <h5 class="item"><?= date("j", strtotime($answer->created_date)) . ' ' . $month_list[date("n", strtotime($answer->created_date))] . ' ' . date("Y", strtotime($answer->created_date)) ?>г.</h5>
                            </div>
                        </div>
                    </div>
        <?php endif;
            endforeach;
        endif; ?>
    </div>
</div>
<div class="modal" id="modal">
    <div class="modal-content">
        <h2>Невозможно оставить отзыв</h2>
        <p>Вы не можете оставить отзыв, так как не прошли ни один курс</p>
        <div class="buttons-modal">
            <button id="btn-close" class="btn-contour">Закрыть</button>
        </div>
    </div>
    <p id="close">✕</p>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/footer.php';
?>