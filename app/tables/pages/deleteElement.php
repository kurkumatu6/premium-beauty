<?php
session_start();

use App\modules\Element;
use App\modules\Photo;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';
Element::delete($_GET['id_element']);
header('Location: /views/admin/pages/main/main_page.view.php#adv');

