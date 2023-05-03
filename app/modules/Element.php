<?php

namespace App\modules;

use App\base\PDOConnection;

class Element
{
    //Подключение базы данных
    private static function connect($config = CONFIG_CONNECTION)
    {
        return PDOConnection::make($config);
    }

    //Получить элемент по id
    public static function getById($id){
        $querty = self::connect()->prepare("SELECT * FROM `elements` WHERE id = :id");
        $querty->execute((['id' => $id]));
        return $querty->fetch();
    }

    //Получить все элементы блока
    public static function getByIdBlock($idBlock)
    {
        $query = self::connect()->prepare("SELECT * FROM `elements` WHERE id_blocks = :idBlock");
        $query->execute(['idBlock'=>$idBlock]);
        return $query->fetchAll();
    }

    //Изменить фото главной страницы
    public static function editImage($image)
    {
        $query = self::connect()->prepare("UPDATE `elements` SET main_photo = :image WHERE id = 4");
        return $query->execute([
            'image' =>  $image
        ]);
    }

    //Изменить фон главной страницы
    public static function editBackground($background)
    {
        $query = self::connect()->prepare("UPDATE `elements` SET background = :background WHERE id = 4");
        return $query->execute([
            'background' =>  $background
        ]);
    }

    //Изменить информацию блока
    public static function editInfoByBlockId($title, $text, $idBlock){
        $query = self::connect()->prepare("UPDATE elements SET title = :title, text = :text WHERE id_blocks = :id_blocks");
        return $query->execute([
            'title' => $title,
            'text' => $text,
            'id_blocks' => $idBlock,
        ]);
    }

    //Изменить информацию главной страницы
    public static function edit($array)
    {
        $query = self::connect()->prepare("UPDATE `elements` SET title = :title, subtitle = :subtitle WHERE id = 4");
        return $query->execute([
            'title' =>  $array['title'],
            'subtitle' =>  $array['subtitle'],
        ]);
    }

    //Удалить элеменет по id
    public static function delete($id){
        $query = self::connect()->prepare("DELETE FROM elements WHERE id = :id");
        return $query->execute([
            'id' => $id
        ]);
    }

    //Добавить элемент
    public static function create($array, $id_block, $main_photo){
        $query = self::connect()->prepare("INSERT into elements (title, subtitle, id_blocks, main_photo, text) values (:title, :subtitle, :id_block, :main_photo, :text)");
        return $query->execute([
            'id_block' => $id_block,
            'title' => $array['title'],
            'subtitle' => $array['subtitle'] ?? null,
            'main_photo' => $main_photo,  
            'text' => $array['text'] ?? null
        ]);
    }

    //Получить все фотографии элемента
    public static function getAllPhotosById($elementId)
    {
        $query = self::connect()->prepare("SELECT * FROM `photos_in_element` WHERE id_elements = :id");
        $query->execute(['id'=>$elementId]);
        return $query->fetchAll();
    }

    //Удалить фото из карусели
    public static function deleteInCarusel($id){
        $query = self::connect()->prepare("DELETE FROM photos_in_element WHERE `photos_in_element`.`id` = :id");
        return $query->execute([
            'id' => $id
        ]);
    }

    //Получить фото карусели по id
    public static function getPhotoCaruselById($id){
        $querty = self::connect()->prepare("SELECT * FROM `photos_in_element` WHERE id = :id");
        $querty->execute((['id' => $id]));
        return $querty->fetch();
    }

    //Добавить элемент
    public static function addPhotoInCarusel($image){
        $query = self::connect()->prepare("INSERT into photos_in_element (image, id_elements) values (:image, :id_elements)");
        return $query->execute([
            'image' => $image,
            'id_elements' => 6,
        ]);
    }
}