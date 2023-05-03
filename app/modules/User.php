<?php
namespace App\modules;
use App\base\PDOConnection;

class User
{
    //Подключение базы данных
    private static function connect($config = CONFIG_CONNECTION)
    {
        return PDOConnection::make($config);
    }

    //Создание нового пользователя
    public static function singUp($data){
        $avatar = rand(1, 2);
        $query = self::connect()->prepare("INSERT into users (login, password, phone, email, name, surname, avatar) values (:login, :password, :phone, :email, :name, :surname, :avatar)");
        return $query->execute([
            'login' => $data['login'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'phone' => $data['phone'],
            'email' => $data['email'],
            'name' => $data['name'],
            'surname' => $data['surname'], 
            'avatar' => 'default-' . $avatar . '.png',        
        ]);
    }

    //Получить пользователя по логину
    public static function getByLogin($login){
        $query = self::connect()->prepare("SELECT users.* FROM users WHERE login = :login;");
        $query->execute(['login'=>$login]);
        return $query->fetch(); 
    }

    //Получить пользователя по почте
    public static function getByEmail($email){
        $query = self::connect()->prepare("SELECT users.* FROM users WHERE email = :email;");
        $query->execute(['email'=>$email]);
        return $query->fetch(); 
    }

    //Получить пользователя по id
    public static function getById($id){
        $query = self::connect()->prepare("SELECT users.* FROM users WHERE id = :id;");
        $query->execute(['id'=>$id]);
        return $query->fetch(); 
    }

    //Получить пользователя по логину и паролю
    public static function ByLoginAndPassword($login, $password){
        $query = self::connect()->prepare("SELECT * FROM users WHERE users.login = :login");
        $query->execute([':login' => $login]);

        $user = $query->fetch();
        if(password_verify($password, $user->password)){
            return $user;
        }
        return null;    
    }
    
    //Изменить имя и фамилию
    public static function changeFio($surname, $name, $id)
    {
        $query = self::connect()->prepare("UPDATE users SET surname = :surname,  name = :name WHERE id = :id");
        return $query->execute(['surname' => $surname, 'name' => $name, 'id' => $id]);
    }

    //Изменить номер телефона
    public static function changePhone($phone, $id)
    {
        $query = self::connect()->prepare("UPDATE users SET phone = :phone WHERE id = :id");
        return $query->execute(['phone' => $phone, 'id' => $id]);
    }

    //Изменить почту
    public static function changeEmail($email, $id)
    {
        $query = self::connect()->prepare("UPDATE users SET email = :email WHERE id = :id");
        return $query->execute(['email' => $email, 'id' => $id]);
    }

    //Изменить вк
    public static function changeVk($vk, $id)
    {
        $query = self::connect()->prepare("UPDATE users SET vk = :vk WHERE id = :id");
        return $query->execute(['vk' => $vk, 'id' => $id]);
    }

    //Изменить аватар
    public static function changeAvatar($avatar, $id)
    {
        $query = self::connect()->prepare("UPDATE users SET avatar = :avatar WHERE id = :id");
        return $query->execute(['avatar' => $avatar, 'id' => $id]);
    }

    //Блокировка пользователя
    public static function block($id)
    {
        $query = self::connect()->prepare("UPDATE users SET in_block = 'yes' WHERE id = :id");
        return $query->execute(['id' => $id]);
    }

    //Разблокировка пользователя
    public static function unblock($id)
    {
        $query = self::connect()->prepare("UPDATE users SET in_block = NULL WHERE id = :id");
        return $query->execute(['id' => $id]);
    }

    //Получить всех пользователей
    public static function noAdmin(){
        $query = self::connect()->query("SELECT * FROM users where role = 'user'");
        return $query->fetchAll();
    }
}