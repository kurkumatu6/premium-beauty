<?php
namespace App\modules;
use App\base\PDOConnection;

class Status
{
    //Подключение базы данных
    private static function connect($config = CONFIG_CONNECTION)
    {
        return PDOConnection::make($config);
    }

    //Получить статус по id
    public static function getById($id){
        $querty = self::connect()->prepare("SELECT * FROM statuses WHERE id = :id");
        $querty->execute((['id' => $id]));
        return $querty->fetch();
    } 

    //Получить все статусы
    public static function getAll()
    {
        $query = self::connect()->query("SELECT * FROM `statuses`");
        return $query->fetchAll();
    }
}