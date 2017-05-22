<?php

class DAOMethods
{
    public static function getUserById($id)
    {
        $user = null;
        $pdo = DBConnection::getInstance()->pdo;
        try {
            $smt = $pdo->prepare("SELECT * FROM `users` WHERE `id`=:id LIMIT 1;");
            if ($smt->execute(array('id'=>$id))) {
                if ($smt->rowCount() > 0) {
                    $row = $smt->fetch(PDO::FETCH_ASSOC);
                    $user = User::fromPdo($row);
                }
            }
        } catch (PDOException $e) {

        }
        return $user;
    }
    public static function getUserByEmail($email)
    {
        $user = null;
        $pdo = DBConnection::getInstance()->pdo;
        try {
            $smt = $pdo->prepare("SELECT * FROM `users` WHERE `email`=:email LIMIT 1;");
            if ($smt->execute(array('email'=>$email))) {
                if ($smt->rowCount() > 0) {
                    $row = $smt->fetch(PDO::FETCH_ASSOC);
                    $user = User::fromPdo($row);
                }
            }
        } catch (PDOException $e) {

        }
        return $user;
    }
    public static function addUser(User $user)
    {
        $result = false;
        $pdo = DBConnection::getInstance()->pdo;
        try {
            $smt = $pdo->prepare("INSERT INTO `users` (`id`, `email`, `pass`, `blocked`, `reg_date`, `reg_time`, `ip`) VALUES (NULL, :email, :pass, :blocked, :date, :time, :ip);");
            if ($smt->execute(array('email'=>$user->getEmail(),'pass'=>$user->getPass(),'blocked'=>$user->getBlocked(),'date'=>$user->getDate(),'time'=>$user->getTime(),'ip'=>$user->getIp()))) {
                $result = true;
            }
        } catch (PDOException $e) {
            print_r($e);
        }
        return $result;
    }

}