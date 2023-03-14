<?php
class Connection
{
    private static $con = null;

    private function __construct()
    {
        $servername = ini_get("mysql.default.servername");
        $username = ini_get("mysql.default.user");
        $password = ini_get("mysql.default.password");
        $db = ini_get("mysql.default.db");

        try {
            self::$con = new PDO("mysql:host=$servername;dbname=$db", 
                             $username, $password);
            
        }
        catch(PDOException $s) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    function __destructor() {
        self::$con = null;
    }

    public static function getConnection()
    {
        if (self::$con == null)
        {
            self::$con = new Connection();
        }

        return self::$con;
    }
}
?>