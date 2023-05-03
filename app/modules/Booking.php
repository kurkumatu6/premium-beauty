<?php

namespace App\modules;

use App\base\PDOConnection;

require_once $_SERVER['DOCUMENT_ROOT'] . '/boostrap.php';

class Booking
{
    //Подключение базы данных
    private static function connect($config = CONFIG_CONNECTION)
    {
        return PDOConnection::make($config);
    }

    //Добавление бронирования
    public static function add($idUser, $timeTable, $conn)
    {
        $date = date('Y-m-d H:i:s');
        $query = $conn->prepare("INSERT into bookings (id_timetable, id_user, created_at, update_at, id_status) values (:timeTable, :idUser, :created_at, :update_at, 1)");
        return $query->execute([
            'timeTable' => $timeTable, 'idUser' => $idUser, 'created_at' => $date, 'update_at' => $date
        ]);
    }

    //Получить id нового бронирования
    public static function getNewId($idUser, $conn)
    {
        $query = $conn->prepare("SELECT id FROM bookings WHERE id_user = :idUser ORDER BY created_at DESC LIMIT 1");
        $query->execute(['idUser' => $idUser]);
        return $query->fetch();
    }

    //Транзакция создания бронирования
    public static function create($idUser, $idTimeTable)
    {

        //устанавливаем подключение
        $conn = PDOConnection::make();

        //транзакция
        try {
            //открываем (начинаем) транзакцию
            $conn->beginTransaction();

            //1. Cоздаем новое бронирование
            Booking::add($idUser, $idTimeTable, $conn);

            //2. Получаем id нового бронирования
            $bookingId = Booking::getNewId($idUser, $conn)->id;

            //3. Принимаем транзакцию
            $conn->commit();

            return true;
        } catch (\PDOException $error) {
            //откатываем транзакцию - отменяем все действия
            $conn->rollBack();

            //смотрим ошибку
            echo ("ошибка " . $error->getMessage());
        }
    }

    //Получить все активные бронирования пользователя
    public static function userActive($id)
    {
        $querty = self::connect()->prepare("SELECT * FROM `bookings` WHERE id_status = 1 and id_user = :id or id_status = 2 and id_user = :id ORDER BY created_at DESC");
        $querty->execute((['id' => $id]));
        return $querty->fetchAll();
    }

    //Получить все неактивные бронирования пользователя
    public static function userNOActive($id)
    {
        $querty = self::connect()->prepare("SELECT * FROM `bookings` WHERE id_status = 3 and id_user = :id or id_status = 4 and id_user = :id or id_status = 5 and id_user = :id ORDER BY created_at DESC");
        $querty->execute((['id' => $id]));
        return $querty->fetchAll();
    }

    //Получить по id
    public static function getById($id)
    {
        $query = self::connect()->prepare("SELECT * FROM `bookings` WHERE id = :id");
        $query->execute(['id' => $id]);
        return $query->fetch();
    }

    //Получить бронирования по id пользователя, которые отменены или завершены
    public static function getСompleted($id)
    {
        $querty = self::connect()->prepare("SELECT * FROM `bookings` WHERE id_status = 3 or id_status = 4 or id_status = 5 and id_user = :id");
        $querty->execute((['id' => $id]));
        return $querty->fetchAll();
    }

    //Получить бронирования, на которые можно оставить отзыв
    public static function forReview($id)
    {
        $bookings = Booking::getСompleted($id);
        $res = [];
        foreach ($bookings as $booking) {
            if (Review::getByIdBooking($booking->id) == null) {
                array_push($res, $booking);
            }
        }
        return $res;
    }

    //Отменить бронирование пользователем
    public static function cancelUser($id, $text)
    {
        Booking::changeStatus(3, $id);
        $query = self::connect()->prepare("UPDATE bookings SET reason_cancel = :text where id = :id");
        $query->execute(['id' => $id, 'text' => $text]);
        return $query->fetch();
    }

    //Отменить бронирование администратором
    public static function cancelAdmin($id, $text)
    {
        Booking::changeStatus(4, $id);
        $query = self::connect()->prepare("UPDATE bookings SET reason_cancel = :text where id = :id");
        $query->execute(['id' => $id, 'text' => $text]);
        return $query->fetch();
    }

    //Получить все активные бронирования по id дня расписания и id пользователя
    public static function getByCourseAndUser($idTimeTable, $idUser)
    {
        $query = self::connect()->prepare("SELECT * FROM `bookings` WHERE (id_status = 1 or id_status = 2) AND id_timetable = :idTimeTable AND id_user = :idUser");
        $query->execute(['idTimeTable' => $idTimeTable, 'idUser' => $idUser]);
        return $query->fetchAll();
    }

    //Получить все бронирования по дню расписания
    public static function getByTimeTable($idTimeTable)
    {
        $query = self::connect()->prepare("SELECT * FROM `bookings` WHERE id_timetable = :idTimeTable ORDER BY created_at DESC");
        $query->execute(['idTimeTable' => $idTimeTable]);
        return $query->fetchAll();
    }

    //Получить все бронирования
    public static function getAll()
    {
        $query = self::connect()->query("SELECT * FROM `bookings` ORDER BY update_at DESC");
        return $query->fetchAll();
    }

    //Фильтр бронирований по статусу
    public static function getByStatus($idStatus)
    {
        $query = self::connect()->prepare("SELECT * FROM `bookings` WHERE id_status = :id_status ORDER BY update_at DESC");
        $query->execute(['id_status' => $idStatus]);
        return $query->fetchAll();
    }

    //Изменить статус
    public static function changeStatus($statusId, $id)
    {
        $date = date('Y-m-d H:i:s');
        $query = self::connect()->prepare("UPDATE bookings SET id_status = :statusId,  update_at = :date WHERE id = :id");
        return $query->execute(['statusId' => $statusId, 'id' => $id, 'date' => $date]);
    }

    //Получить бронирования по курсу
    public static function getByCourseId($courseId)
    {
        $bookings = Booking::getAll();
        $res = [];
        foreach ($bookings as $booking) {
            if (TimeTable::getById($booking->id_timetable)->course_id == $courseId) {
                array_push($res, $booking);
            }
            return $res;
        }
    }

    //Получить подтвреждённые бронирования по дню расписания
    public static function getByTimeTableIsConfirm($idTimeTable)
    {
        $query = self::connect()->prepare("SELECT * FROM `bookings` WHERE id_status = 2 AND id_timetable = :idTimeTable ORDER BY update_at DESC");
        $query->execute(['idTimeTable' => $idTimeTable]);
        return $query->fetchAll();
    }

    //Получить бронирования по курсу по статусу
    public static function getByCourseIdStatusId($courseId, $statusId)
    {
        $bookings = Booking::getByStatus($statusId);
        $res = [];
        foreach ($bookings as $booking) {
            if (TimeTable::getById($booking->id_timetable)->course_id == $courseId) {
                array_push($res, $booking);
            }
            return $res;
        }
    }
}
