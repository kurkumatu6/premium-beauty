<?php

namespace App\modules;

use App\base\PDOConnection;

class Info
{
    //Подключение базы данных
    private static function connect($config = CONFIG_CONNECTION)
    {
        return PDOConnection::make($config);
    }

    //Получить информацию страницы
    public static function get()
    {
        $querty = self::connect()->prepare("SELECT * FROM `information` WHERE id = 1");
        $querty->execute();
        return $querty->fetch();
    }

    //Изменить информацию страницы
    public static function edit($array)
    {
        $query = self::connect()->prepare("UPDATE `information` SET phone = :phone, email = :email WHERE id = 1");
        return $query->execute([
            'phone' =>  $array['phone'],
            'email' =>  $array['email']
        ]);
    }

    //Изменить логотип
    public static function editLogo($logo)
    {
        $query = self::connect()->prepare("UPDATE `information` SET logo = :logo WHERE id = 1");
        return $query->execute([
            'logo' =>  $logo
        ]);
    }

    //Изменить белый логотип
    public static function editWhiteLogo($logo)
    {
        $query = self::connect()->prepare("UPDATE `information` SET white_logo = :logo WHERE id = 1");
        return $query->execute([
            'logo' =>  $logo
        ]);
    }
}
