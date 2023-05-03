<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/header.php';
?>
<link rel="stylesheet" href="/assets/styles/logIn.css">

<div class="login">
  <h1>Вход в личный кабинет</h1>
  <form action="/app/tables/users/logIn.php" method="GET">
    <div class="item">
      <label for="login">
        <h4>Логин</h4>
      </label>
      <input type="text" name="login" value="<?=$_SESSION['get']['login'] ?? ''?>"/>
    </div>
    <div class="item">
      <label for="password">
        <h4>Пароль</h4>
      </label>
      <input type="text" name="password" value="<?=$_SESSION['get']['[password]'] ?? ''?>"/>
    </div>
    <p class="error"><?= $_SESSION['error'] ?? '' ?></p>
    <button name="btn_login">Войти</button>
    <a href="/views/users/auth/singUp.view.php">
      <h4 class="registration">Зарегистрироваться</h4>
    </a>
  </form>
</div>

<?php
unset($_SESSION['get']);
unset($_SESSION['error']);
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/footer.php';
?>