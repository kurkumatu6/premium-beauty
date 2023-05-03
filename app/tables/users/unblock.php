<?php 
session_start();

use App\modules\User;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

User::unblock($_GET['block_user_id']);
header("Location: /views/admin/users/users.view.php");
