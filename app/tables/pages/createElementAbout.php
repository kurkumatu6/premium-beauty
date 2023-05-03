<pre>
<?php

use App\modules\Element;
use App\modules\MainPage;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';


$error = [];
if ($_POST['text'] == ''){
    $error['text'] = 'Поле не может быть пустым';
}
if($_FILES['image']['name'] == ''){
    $error['image'] = 'Поле не может быть пустым';
}
elseif (
    $_FILES['image']['type'] != 'image/png' && $_FILES['image']['type']
    != 'image/jpeg' && $_FILES['image']['type'] != 'image/jpg'
) {
    $error['image'] = 'Неверный формат изображения';
}


if ($error != []) {
    $_SESSION['post'] = $_POST;
    $_SESSION['error'] = $error;
    // header('Location: /views/admin/pages/about/createElement.view.php');
}
else{    
    $date = date('Y-m-d');
    $name = $date . '_' . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "C:/OSPanel/domains/premium-beauty/assets/images/about/" . $name);
    Element::create($_POST, 5, $name);
    header('Location: /views/admin/pages/about/editAbout.view.php');
}
?>
</pre>