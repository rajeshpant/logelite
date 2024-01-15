<?php
class DB
{
    public $host;
    private $user;
    private $pass;
    private $dbName;
    private static $instance;
    public static $connection;
    
    private function __construct() { }
    
    static function getInstance() {
        if(!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    function connect($host, $user, $pass, $dbName) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbName = $dbName;
        self::$connection = mysqli_connect($this->host, $this->user, $this->pass, $this->dbName);
    }
}