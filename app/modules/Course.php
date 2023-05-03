<?php

namespace App\modules;

use App\base\PDOConnection;

class Course
{
    //Подключение базы данных
    private static function connect($config = CONFIG_CONNECTION)
    {
        return PDOConnection::make($config);
    }


    //Получить все курсы (от новых)
    public static function getAll()
    {
        $query = self::connect()->query("SELECT * FROM courses ORDER BY created_date DESC");
        return $query->fetchAll();
    }

    //Получить все доступные курсы (от новых)
    public static function getStatusIsYes()
    {
        $query = self::connect()->query("SELECT * FROM courses WHERE status = 'yes' ORDER BY created_date DESC");
        return $query->fetchAll();
    }

    //Получить курс по id
    public static function getById($id)
    {
        $querty = self::connect()->prepare("SELECT * FROM courses WHERE id = :id");
        $querty->execute((['id' => $id]));
        return $querty->fetch();
    }

    //Получить достпуные курсы по нескольким категориям
    public static function getByCategoriesStatusIsYes($array)
    {
        $res = [];
        $arrayId = [];
        foreach ($array as $id) {
            $query = self::connect()->prepare("SELECT * FROM types_in_courses WHERE id_types = :id");
            $query->execute(['id' => $id]);
            $temp = $query->fetchAll();
            foreach ($temp as $i) {
                if (!array_search(Course::getById($i->id_course)->id, $arrayId) && Course::getById($i->id_course)->status == 'yes') {
                    array_push($res, Course::getById($i->id_course));
                    array_push($arrayId, Course::getById($i->id_course)->id);
                }
            }
        }
        return $res;
    }

    //Получить продукты по нескольким категориям
    public static function getByCategories($array)
    {
        $res = [];
        $arrayId = [];
        foreach ($array as $id) {
            $query = self::connect()->prepare("SELECT * FROM types_in_courses WHERE id_types = :id");
            $query->execute(['id' => $id]);
            $temp = $query->fetchAll();
            foreach ($temp as $i) {
                if (!array_search(Course::getById($i->id_course)->id, $arrayId)) {
                    array_push($res, Course::getById($i->id_course));
                    array_push($arrayId, Course::getById($i->id_course)->id);
                }
            }
        }
        return $res;
    }

    //Создание нового курса
    public static function create($data, $image)
    {
        $date = date('Y-m-d H:i:s');
        $query = self::connect()->prepare("INSERT into courses (name, image, price, description, max_student, created_date, duration) values (:name, :image, :price, :description, :max_student, :created_date, :duration)");
        return $query->execute([
            'name' => $data['name'],
            'image' => $image,
            'price' => $data['price'],
            'description' => $data['description'],
            'max_student' => $data['max_student'],
            'created_date' => $date,
            'duration' => $data['duration'],
        ]);
    }

    //Удалить курс по id
    public static function delete($id)
    {
        $query = self::connect()->prepare("DELETE FROM courses WHERE id = :id");
        return $query->execute([
            'id' => $id
        ]);
    }

    //Изменить курс
    public static function edit($id, $data)
    {
        $query = self::connect()->prepare("UPDATE `courses` SET name = :name, price = :price, description = :description, max_student = :max_student, duration = :duration WHERE id = :id");
        return $query->execute([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'max_student' => $data['max_student'],
            'duration' => $data['duration'],
            'id' => $id
        ]);
    }

    //Изменить фото курса
    public static function editImage($image, $id)
    {
        $query = self::connect()->prepare("UPDATE `courses` SET image = :image WHERE id = :id");
        return $query->execute([
            'id' =>  $id,
            'image' => $image
        ]);
    }

    //Скрыть курс
    public static function hide($id)
    {
        $query = self::connect()->prepare("UPDATE `courses` SET status = 'no' WHERE id = :id");
        return $query->execute([
            'id' =>  $id
        ]);
    }

    //Показать курс
    public static function noHide($id)
    {
        $query = self::connect()->prepare("UPDATE `courses` SET status = 'yes' WHERE id = :id");
        return $query->execute([
            'id' =>  $id
        ]);
    }
}
