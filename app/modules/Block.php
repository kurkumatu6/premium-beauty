<?php

namespace App\modules;

use App\base\PDOConnection;

class Block
{
    //Подключение базы данных
    private static function connect($config = CONFIG_CONNECTION)
    {
        return PDOConnection::make($config);
    }

    //Получить блок по id
    public static function getById($id){
        $querty = self::connect()->prepare("SELECT * FROM blocks WHERE id = :id");
        $querty->execute((['id' => $id]));
        return $querty->fetch();
    }

    //Получить блок по названию
    public static function getByName($name){
        $querty = self::connect()->prepare("SELECT * FROM blocks WHERE name = :name");
        $querty->execute((['name' => $name]));
        return $querty->fetch();
    }

    //Получить все блоки страницы
    public static function getByIdPage($idPage)
    {
        $query = self::connect()->prepare("SELECT * FROM `blocks` WHERE id_pages = :idPage ORDER BY num ASC");
        $query->execute(['idPage'=>$idPage]);
        return $query->fetchAll();
    }
}