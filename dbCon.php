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

    public static function isUsernameAvailable($username)
    {
        $conn = self::getConnection();

        $sql = "SELECT login FROM Users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        foreach ($stmt->fetchAll() as $user)
        {
            if ($user['login'] === $username)
            {
                echo 'The following login exists already in db: '.$username."<br/>";
                return false;
            }
        }

        return true;
    }

    public static function registerUser($username, $password)
    {
        if (self::isUsernameAvailable($username))
        {
            $conn = self::getConnection();

            $hashPass = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO Users (id, login, password) VALUES (NULL, :username, :password)";
            $conn->prepare($sql)->execute(['username' => $username, 'password' => $hashPass]);
        }
    }
}
?>