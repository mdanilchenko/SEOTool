<?php

class DBConnection
{
    public $pdo = array();
    private static $_instance = null;

    private function __construct()
    {
        $dsn = "mysql:host=".Constants::$DB_HOST.";dbname=".Constants::$DB_NAME.";charset=utf8";
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        try {
            $this->pdo = new PDO($dsn, Constants::$DB_USER, Constants::$DB_PASS, $opt);
        } catch (PDOException $e) {

            die('Подключение не удалось');
        }
    }

    protected function __clone(){}

    static public function getInstance()
    {
		
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
}