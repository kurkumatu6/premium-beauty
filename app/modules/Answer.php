<?php

namespace App\modules;

use App\base\PDOConnection;

class Answer
{
    //Подключение базы данных
    private static function connect($config = CONFIG_CONNECTION)
    {
        return PDOConnection::make($config);
    }

    //Получить ответ по id отзыва
    public static function getByIdReview($id)
    {
        $querty = self::connect()->prepare("SELECT * FROM answers WHERE id_review = :id");
        $querty->execute((['id' => $id]));
        return $querty->fetch();
    }

    //Получить ответ по id
    public static function getById($id)
    {
        $querty = self::connect()->prepare("SELECT * FROM answers WHERE id = :id");
        $querty->execute((['id' => $id]));
        return $querty->fetch();
    }

    //Оставить ответ на отзыв
    public static function create($idUser, $idReview, $text)
    {
        $date = date('Y-m-d H:i:s');
        $querty = self::connect()->prepare("INSERT INTO answers (id_user, id_review, text, created_date) VALUES(:id_user, :id_review, :text, :created_date)");
        return $querty->execute(([
            'id_user' => $idUser,
            'id_review' => $idReview,
            'text' => $text,
            'created_date' => $date,
        ]));
    }

    //Удалить ответ
    public static function delete($idReview)
    {
        $querty = self::connect()->prepare("DELETE FROM answers WHERE id_review = :idReview");
        return $querty->execute([
            'idReview' => $idReview
        ]);
    }
}
