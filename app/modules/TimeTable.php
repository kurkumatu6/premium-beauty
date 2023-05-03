<?php
namespace App\modules;
use App\base\PDOConnection;

class TimeTable
{
    //Подключение базы данных
    private static function connect($config = CONFIG_CONNECTION)
    {
        return PDOConnection::make($config);
    }

    //Получить актуальные даты на курс (до начала осталось не менее 1 дня и ещё есть свободные места)
    public static function getTopicalByCourseId($id, $idUser){
        $date = date('Y-m-d') . ' 00:00:00';
        $query = self::connect()->prepare("SELECT * FROM timetable where date > :date and course_id = :id ORDER BY date DESC");
        $query->execute(['date'=>$date, 'id'=>$id]);
        $days = $query->fetchAll();
        $res = [];
        foreach ($days as $day){
            $freePlaces = Course::getById($id)->max_student - count(Booking::getByTimeTable($day->id));
            if ($freePlaces > 0 && Booking::getByCourseAndUser($id, $idUser) == null){
                array_push($res, $day);
            }
        }
        return $res;
    }

    //Получить день расписания по id
    public static function getById($id){
        $query = self::connect()->prepare("SELECT * FROM `timetable` WHERE id = :id");
        $query->execute(['id'=>$id]);
        return $query->fetch(); 
    }

    //Получить предстоящие дни расписания (от ближайших)
    public static function upcoming()
    {
        $date = date('Y-m-d') . ' 00:00:00';
        $query = self::connect()->prepare("SELECT * FROM timetable WHERE date > :date ORDER BY date DESC");
        $query->execute(['date'=>$date]);
        return $query->fetchAll();
    }

    //Получить прошедшие дни расписания (от ближайших)
    public static function old()
    {
        $date = date('Y-m-d') . ' 00:00:00';
        $query = self::connect()->prepare("SELECT * FROM timetable WHERE date < :date ORDER BY date DESC");
        $query->execute(['date'=>$date]);
        return $query->fetchAll();
    }


    //Получить все дни расписания (по датам от ближайших)
    public static function getAll()
    {
        $query = self::connect()->query("SELECT * FROM timetable ORDER BY date DESC");
        return $query->fetchAll();
    }

    //Добавить день в расписание
    public static function create($array, $date){
        $query = self::connect()->prepare("INSERT INTO timetable (course_id, date) VALUES(:course_id, :date)");
        return $query->execute([
            'course_id' => $array['course'],
            'date' => $date, 
        ]);
    }

    //Удалить день по id
    public static function delete($id)
    {
        $query = self::connect()->prepare("DELETE FROM timetable WHERE id = :id");
        return $query->execute([
            'id' => $id
        ]);
    }

    //Изменить день
    public static function edit($array, $date)
    {
        $query = self::connect()->prepare("UPDATE timetable SET course_id = :course_id, date = :date WHERE id = :id");
        return $query->execute([
            'course_id' =>  $array['course'],
            'date' =>  $date,
            'id' =>  $array['id_day'],
        ]);
    }


}