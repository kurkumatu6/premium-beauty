<?php

namespace App\modules;

use App\base\PDOConnection;

class Page
{
    //Подключение базы данных
    private static function connect($config = CONFIG_CONNECTION)
    {
        return PDOConnection::make($config);
    }

    //Получить страницу по id
    public static function getById($id){
        $querty = self::connect()->prepare("SELECT * FROM pages WHERE id = :id");
        $querty->execute((['id' => $id]));
        return $querty->fetch();
    }

    //Изменить навзание страницы
    public static function editName($name, $idPage){
        $query = self::connect()->prepare("UPDATE pages SET name = :name WHERE id = :id");
        return $query->execute([
            'name' => $name,
            'id' => $idPage,
        ]);
    }
}