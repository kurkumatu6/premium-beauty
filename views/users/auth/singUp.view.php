<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/header.php';
// var_dump($_SESSION['error']);
?>
<link rel="stylesheet" href="/assets/styles/singUp.css">

<div class="singUp">
  <h1>Регистрация</h1>
  <form action="/app/tables/users/singUp.php" method="POST">
    <div class="item">
      <label for="name">
        <h4>Имя</h4>
      </label>
      <div class="field">
        <input type="text" name="name" value="<?= $_SESSION['post']['name'] ?? '' ?>" />
        <h5 class="error-singUp"><?= $_SESSION['error']['name'] ?? ' ' ?></h5>
      </div>
    </div>
    <div class="item">
      <label for="surname">
        <h4>Фамилия</h4>
      </label>
      <div class="field">
        <input type="text" name="surname" value="<?= $_SESSION['post']['surname'] ?? '' ?>" />
        <h5 class="error-singUp"><?= $_SESSION['error']['surname'] ?? ' ' ?></h5>
      </div>
    </div>
    <div class="item">
      <label for="login">
        <h4>Логин</h4>
      </label>
      <div class="field">
        <input type="text" name="login" value="<?= $_SESSION['post']['login'] ?? '' ?>" />
        <h5 class="error-singUp"><?= $_SESSION['error']['login'] ?? ' ' ?></h5>
      </div>
    </div>
    <div class="item">
      <label for="phone">
        <h4>Телефон</h4>
      </label>
      <div class="field">
        <input type="text" name="phone" value="<?= $_SESSION['post']['phone'] ?? '' ?>" />
        <h5 class="error-singUp"><?= $_SESSION['error']['phone'] ?? ' ' ?></h5>
      </div>
    </div>
    <div class="item">
      <label for="email">
        <h4>Почта</h4>
      </label>
      <div class="field">
        <input type="text" name="email" value="<?= $_SESSION['post']['email'] ?? '' ?>" />
        <h5 class="error-singUp"><?= $_SESSION['error']['email'] ?? ' ' ?></h5>
      </div>
    </div>
    <div class="item">
      <label for="password">
        <h4>Пароль</h4>
      </label>
      <div class="field">
        <input type="text" name="password" value="<?= $_SESSION['post']['password'] ?? '' ?>" />
        <h5 class="error-singUp"><?= $_SESSION['error']['password'] ?? 'Длина пароля должна быть от 6 символов' ?></h5>
      </div>
    </div>
    <div class="item">
      <label for="password_repeat">
        <h4>Подтвреждение</h4>
      </label>
      <div class="field">
        <input type="text" name="password_repeat" value="<?= $_SESSION['post']['password_repeat'] ?? '' ?>" />
        <h5 class="error-singUp"><?= $_SESSION['error']['password_repeat'] ?? '' ?></h5>
      </div>
    </div>
    <div class="item">
      <input type="checkbox" name="rules" id="rules">
      <label for="rules">
        <h4 class="politics">Я согласен с политикой конфидинциальности</h4>
      </label>
    </div>
    <p class="error"><?= $_SESSION['error']['all'] ?? '' ?></p>
    <button name="btn_singUp">Зарегистрироваться</button>
    <a href="/views/users/auth/logIn.view.php">
      <h4 class="registration">Войти</h4>
    </a>
  </form>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/views/users/templates/footer.php';
unset($_SESSION['post']);
unset($_SESSION['error']); ?>