<?php
session_start();

use App\modules\Element;
use App\modules\Photo;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';
$photo = Element::getPhotoCaruselById($_GET['id_photo']);
Element::deleteInCarusel($photo->id);
unlink("C:/OSPanel/domains/premium-beauty/assets/images/tournaments/" . $photo->image);
header('Location: /views/admin/pages/about/editAbout.view.php#carusel');

