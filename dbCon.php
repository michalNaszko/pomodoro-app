<?php
class Connection
{
    private static $instance = null;
    private $conn = null;

    private function __construct()
    {        
        $servername = getenv("mysql.default.servername");
        $username = getenv("mysql.default.user");
        $password = getenv("mysql.default.password");
        $db = getenv("mysql.default.db");

        try {
            $this->conn = new PDO("mysql:host=$servername;dbname=$db", 
                             $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        }
        catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    function __destructor() {
        $this->conn = null;
    }

    public static function getConnection()
    {
        if (self::$instance == null)
        {
            self::$instance = new Connection();
        }

        return self::$instance->conn;
    }
}
?>