<?php
namespace App\base;

//Подключение базы данных
class PDOConnection
{
    public static function make($config = CONFIG_CONNECTION)
    {
        return new \PDO(
            "mysql:host=" . $config['host'] . ";dbname=" . $config['dbname'],
            $config['login'],
            $config['password'],
            $config['options']
        );
    }
}
