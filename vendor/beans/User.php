<?php

class User
{
    private $id;
    private $email;
    private $pass;
    private $blocked;
    private $date;
    private $time;
    private $ip;

    public static function fromPdo($row){
        return new User($row['id'],$row['email'],$row['pass'],$row['blocked'],$row['reg_date'],$row['reg_time'],$row['ip']);
    }
    /**
     * User constructor.
     * @param $id
     * @param $email
     * @param $pass
     * @param $blocked
     * @param $date
     * @param $time
     * @param $ip
     */
    public function __construct($id, $email, $pass, $blocked, $date, $time, $ip)
    {
        $this->id = $id;
        $this->email = $email;
        $this->pass = $pass;
        $this->blocked = $blocked;
        $this->date = $date;
        $this->time = $time;
        $this->ip = $ip;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @param mixed $pass
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    /**
     * @return mixed
     */
    public function getBlocked()
    {
        return $this->blocked;
    }

    /**
     * @param mixed $blocked
     */
    public function setBlocked($blocked)
    {
        $this->blocked = $blocked;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }
}