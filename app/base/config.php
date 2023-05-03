<?php
//Константа со значениями необходимыми для подключения БД
const CONFIG_CONNECTION = [
    'host'=>'localhost',
    'dbname'=>'a0811856_premium_beauty',
    'login'=>'a0811856_premium_beauty',
    'password'=>'K2i7QzQN',
    'options'=>[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]
];
