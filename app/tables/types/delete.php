<?php

use App\modules\Type;

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

Type::delete($_GET['delete_type_id']);
header('Location: /views/admin/types/types.view.php');