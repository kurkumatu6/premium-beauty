<?php
session_start();

use App\modules\Element;
use App\modules\Photo;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';
$element = Element::getById($_GET['id_element']);
Element::delete($_GET['id_element']);
unlink("C:/OSPanel/domains/premium-beauty/assets/images/about/" . $element->main_photo);
header('Location: /views/admin/pages/about/editAbout.view.php');

