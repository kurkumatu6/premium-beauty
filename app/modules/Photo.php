<?php
namespace App\modules;
use App\base\PDOConnection;

class Photo
{
    //Подключение базы данных
    private static function connect($config = CONFIG_CONNECTION)
    {
        return PDOConnection::make($config);
    }

    //Получить все фото
    public static function all(){
        $query = self::connect()->query("SELECT * FROM photos ORDER BY date DESC");
        return $query->fetchAll();
    }

    //Получить фото работ преподавателя
    public static function teacher(){
        $query = self::connect()->query("SELECT * FROM photos WHERE category = 'Преподаватель' ORDER BY date DESC");
        return $query->fetchAll();
    }

    //Получить фото работ учеников
    public static function student(){
        $query = self::connect()->query("SELECT * FROM photos WHERE category = 'Ученик' ORDER BY date DESC");
        return $query->fetchAll();
    }

    //Получить фото по id
    public static function getById($id){
        $querty = self::connect()->prepare("SELECT * FROM photos WHERE id = :id");
        $querty->execute((['id' => $id]));
        return $querty->fetch();
    }

    //Удалить фото по id
    public static function delete($id){
        $query = self::connect()->prepare("DELETE FROM photos WHERE id = :id");
        return $query->execute([
            'id' => $id
        ]);
    }

    //Добавить фото
    public static function create($category, $image){
        $date = date('Y-m-d H:i:s');
        $query = self::connect()->prepare("INSERT into photos (date, category, image) values (:date, :category, :image)");
        return $query->execute([
            'date' => $date,
            'category' => $category,
            'image' => $image     
        ]);
    }


}