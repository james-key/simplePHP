<?php

namespace App\Database;

use PDO;
use App\App;

class Database
{
    private $connection;
    private $stmt;

    public function __construct() { }

    private function connect()
    {
        if (!$this->connection) {
            $env = (App::getInstance())->getEnv();
            
            $host = $env->get('DB_HOST');
            $database = $env->get('DB_DATABASE');
            $username = $env->get('DB_USERNAME');
            $password = $env->get('DB_PASSWORD');
            
            $this->connection = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        }
    }

    public function query($sql, $params = [])
    {
        $this->connect();
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
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
