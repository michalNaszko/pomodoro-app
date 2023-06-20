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

        $query = "SELECT login FROM Users";
        $stmt = $conn->prepare($query);
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
            
            $query = "INSERT INTO Users (id, login, password) VALUES (NULL, :username, :password)";
            return $conn->prepare($query)->execute(['username' => $username, 'password' => $hashPass]);
        }

        return false;
    }

    public static function login($username, $password)
    {
        $login = FALSE;
        $conn = self::getConnection();

        $query = 'SELECT * FROM Users WHERE (login = :username)';
        $stmt = $conn->prepare($query);
        $stmt->execute(['username' => $username]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (is_array($row))
        {
            if (password_verify($password, $row['password']))
            {
                $login = TRUE;
                echo "You are logged!\n"."<br/>";
                return true;
            }
            else
            {
                echo "Wrong password!\n"."<br/>";
                return false;
            }
        }
        else
        {
            return false;
        }
        return false;
    }
}
?>