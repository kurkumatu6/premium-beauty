<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/header.php';
// if($_SESSION['auth'] != 'admin'){
//     header("Location: /");
// }
?>
<link rel="stylesheet" href="/assets/styles/admin/admin-panel.css">
<div class="admin-panel">
    <h1>Страницы сайта</h1>
    <a href="/views/admin/pages/main/main_page.view.php"><button>Главная</button></a>
    <a href="/views/admin/pages/about/editAbout.view.php"><button>О нас</button></a>
    <a href="/views/admin/information.view.php"><button>Информация сайта</button></a>
    <a href="/views/admin/adminPanel.view.php"><button>Назад</button></a>
</div>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/admin/templates/footer.php';
?>