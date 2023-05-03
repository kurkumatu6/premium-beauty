<?php

namespace App\modules;

use App\base\PDOConnection;

class Type
{
    //Подключение базы данных
    private static function connect($config = CONFIG_CONNECTION)
    {
        return PDOConnection::make($config);
    }

    //Получить все категории
    public static function getAll()
    {
        $query = self::connect()->query("SELECT * FROM types");
        return $query->fetchAll();
    }

    //Получить id категорий одного курса
    public static function idInCourse($idCourse)
    {
        $querty = self::connect()->prepare("SELECT * FROM types_in_courses WHERE id_course = :idCourse");
        $querty->execute((['idCourse' => $idCourse]));
        return $querty->fetchAll();
    }

    //Получить тип по id
    public static function findById($id)
    {
        $querty = self::connect()->prepare("SELECT * FROM types WHERE id = :id");
        $querty->execute((['id' => $id]));
        return $querty->fetch();
    }

    //Несколько категорий преобразовать в строку
    public static function categoriesInString($array)
    {
        $res = '';
        foreach ($array as $category) {
            $res = $res . Type::findById($category->id_types)->abb_name . ', ';
        }
        return $res;
    }

    //Создание нового типа
    public static function create($array)
    {
        $query = self::connect()->prepare("INSERT into types (name, abb_name) values (:name, :abb_name)");
        return $query->execute([
            'name' => $array['name'],
            'abb_name' => $array['abb-name'],
        ]);
    }

    //Получить тип по названию
    public static function getByName($name)
    {
        $querty = self::connect()->prepare("SELECT * FROM types WHERE name = :name");
        $querty->execute((['name' => $name]));
        return $querty->fetch();
    }

    //Удалить тип по id
    public static function delete($id)
    {
        $querty = self::connect()->prepare("DELETE FROM types WHERE id = :id");
        return $querty->execute((['id' => $id]));
    }

    //Изменить тип
    public static function edit($data)
    {
        $query = self::connect()->prepare("UPDATE types SET name = :name, abb_name = :abb_name WHERE id=:id");
        return $query->execute([
            'id' => $data['id'],
            'abb_name' => $data['abb_name'],
            'name' => $data['name'],
        ]);
    }
}
