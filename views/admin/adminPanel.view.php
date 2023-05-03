<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
// if($_SESSION['auth'] != 'admin'){
//     header("Location: /");
// }
?>
<link rel="stylesheet" href="/assets/styles/admin/admin-panel.css">
<div class="admin-panel">
    <h1>Административная панель</h1>
    <a href="/views/admin/pages/pages.view.php"><button>Страницы</button></a>
    <a href="/views/admin/photos/photos.view.php"><button>Портфолио</button></a>
    <a href="/views/admin/courses/courses.view.php"><button>Учебные курсы</button></a>
    <a href="/views/admin/timeTable/timeTable.view.php"><button>Расписание</button></a>
    <a href="/views/admin/bookings/bookings.view.php"><button>Бронирования</button></a>
    <a href="/views/admin/reviews/reviews.view.php"><button>Отзывы</button></a>
    <a href="/views/admin/types/types.view.php"><button>Типы</button></a>
    <a href="/views/admin/users/users.view.php"><button>Пользователи</button></a>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
?>