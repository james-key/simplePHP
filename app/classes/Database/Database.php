<?php

namespace App\Database;

use PDO;
use App\App;

class Database
{
    private static $connection;
    private $stmt;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        if (!self::$connection) {
            $env = (App::getInstance())->getEnv();

            $host = $env->get('DB_HOST');
            $database = $env->get('DB_DATABASE');
            $username = $env->get('DB_USERNAME');
            $password = $env->get('DB_PASSWORD');

            self::$connection = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        }
    }

    public function query($sql, $params = [])
    {
        $stmt = self::$connection->prepare($sql);

        foreach ($params as $key => &$value) {
            if (is_int($key)) {
                $key++;
            }
            
            if (is_int($value)) {
                $type = PDO::PARAM_INT;
            } elseif (is_bool($value)) {
                $type = PDO::PARAM_BOOL;
            } elseif (is_null($value)) {
                $type = PDO::PARAM_NULL;
            } else {
                $type = PDO::PARAM_STR;
            }
            $stmt->bindParam($key, $value, $type);
        }

        $stmt->execute();
        $this->stmt = $stmt;

        return $this;
    }

    public function get()
    {
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
