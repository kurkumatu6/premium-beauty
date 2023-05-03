<?php
session_start();

use App\modules\Photo;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';
$photo = Photo::getById($_GET['id_photo']);
Photo::delete($photo->id);
unlink("C:/OSPanel/domains/premium-beauty/assets/images/photos/" . $photo->image);
header('Location: /views/admin/photos/photos.view.php');

