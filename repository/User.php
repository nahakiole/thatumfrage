<?php
/**
 * Created by PhpStorm.
 * User: robin.glauser@gmail.com
 * Date: 12.11.13
 * Time: 18:21
 */

namespace Repository;

require_once './entity/User.php';

class UserExceptionWrongPassword extends \Exception {}

class UserExceptionNotFound extends \Exception {}

class UserExceptionNoUsernameGiven extends \Exception {}

class User {

    private static $users;

    private static function reloadUsers(){
        if (!isset(self::$users)) {
            $rawUsers = file_get_contents('./data/user.json');
            self::$users = json_decode($rawUsers, true);
        }
        return self::$users;
    }

    public static function saveUsers(){
        file_put_contents('./data/user.json', json_encode(self::$users));
    }

    public static function checkUser($name,$password){
        $users = self::reloadUsers();
        if (empty($name)){
            throw new UserExceptionNoUsernameGiven('Kein Username oder Passwort angegeben');
        }
        foreach ($users as $user){
            if ($user['name'] == $name){
                if ($user['password'] == md5($password)){
                    $userEntity = new \Entity\User();
                    $userEntity->name = $user['name'];
                    $userEntity->id = $user['id'];
                    return $userEntity;
                }
                else {
                    throw new UserExceptionWrongPassword('Falsches Passwort oder Benutzername wurde bereits gewählt.');
                }
            }
        }
        throw new UserExceptionNotFound('Benutzer mit dem Namen '.$name.' wurde nicht gefunden.');
    }

    public static function createUser($name,$password){
        $users = self::reloadUsers();
        $id = count($users);
        $users[$id] = array(
                'id' => $id+1,
                'name' => $name,
                'password' => $password
        );
        self::$users = $users;
        self::saveUsers();
        return self::getUserByName($name);
    }

    public static function getUserByName($name){
        $users = self::reloadUsers();
        foreach ($users as $user){
            if ($user['name'] == $name){
                    $userEntity = new \Entity\User();
                    $userEntity->name = $user['name'];
                    $userEntity->id = $user['id'];
                    return $userEntity;
            }
        }
        throw new UserExceptionNotFound('Benutzer mit dem Namen '.$name.' wurde nicht gefunden.');
    }
}
