<?php
namespace App\modules;
use App\base\PDOConnection;

class Review
{
    //Подключение базы данных
    private static function connect($config = CONFIG_CONNECTION)
    {
        return PDOConnection::make($config);
    }

    //Получить все отзывы (которые не перенесены в архив)
    public static function getAll(){
        $query = self::connect()->query("SELECT * FROM reviews where in_delete IS NULL ORDER BY created_date DESC");
        return $query->fetchAll();
    }

    //Получить все отзывы
    public static function getAllAdm(){
        $query = self::connect()->query("SELECT * FROM reviews ORDER BY created_date DESC");
        return $query->fetchAll();
    }

    //Получить отзыв по id
    public static function getById($id)
    {
        $querty = self::connect()->prepare("SELECT * FROM reviews WHERE id = :id");
        $querty->execute((['id' => $id]));
        return $querty->fetch();
    }

    //Получить отзыв по id бронирования
    public static function getByIdBooking($idBooking)
    {
        $querty = self::connect()->prepare("SELECT * FROM reviews WHERE id_booking = :id_booking");
        $querty->execute((['id_booking' => $idBooking]));
        return $querty->fetch();
    }
    
    //Получить отзывы по курсу
    public static function getByCategory($idCourse)
    {
        $reviews = Review::getAll();
        $res = [];
        foreach ($reviews as $review){
            if (Course::getById(TimeTable::getById(Booking::getById($review->id_booking)->id_timetable)->course_id)->id == $idCourse){
                array_push($res, $review);
            }
        }
        return $res;
    }  
    
    //Создание нового отзыва
    public static function create($id_booking, $text){
        $date = date('Y-m-d H:i:s');
        $query = self::connect()->prepare("INSERT INTO reviews (id_booking, text, created_date) VALUES (:id_booking, :text, :date)");
        return $query->execute([
            'id_booking' => $id_booking,
            'text' => $text, 
            'date' => $date,
        ]);
    }

    //Изменить текст отзыва
    public static function changeText($idReview, $text)
    {
        $date = $date = date('Y-m-d');
        $query = self::connect()->prepare("UPDATE reviews SET text = :text, update_date = :date WHERE id = :idReview");
        return $query->execute(['text' => $text, 'idReview' => $idReview, 'date' => $date]);
    }

    //Удалить отзыв пользователем (отправить в архив)
    public static function deleteUser($idReview)
    {
        $date = $date = date('Y-m-d');
        $query = self::connect()->prepare("UPDATE reviews SET in_delete = 'yes', update_date = :date WHERE id = :idReview");
        return $query->execute(['idReview' => $idReview, 'date' => $date]);
    }

    //Удалить отзыв
    public static function delete($id)
    {
        Answer::delete($id);
        $querty = self::connect()->prepare("DELETE FROM reviews WHERE id = :id");
        return $querty->execute([
            'id' => $id
        ]);
    }
}