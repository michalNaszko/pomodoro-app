<?php
class Connection
{
    private static $instance = null;
    private $conn = null;

    private function __construct()
    {        
        $servername = "db";
        $username = "root";
        $password = rtrim(file_get_contents("/run/secrets/db_root_password"));
        $db = "pomodoro";

        try {
            $this->conn = new PDO("mysql:host=$servername",$username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE DATABASE if not exists " . $db;
            $this->conn->exec($sql);
            $this->conn = null;
            $this->conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
            $sql = "CREATE TABLE if not exists Users (id int not null auto_increment primary key, login text not null, password text not null)";
            $this->conn->exec($sql);
            $sql = "CREATE TABLE if not exists WorkTime (User_id int, Date date not null, Time time not null)";
            $this->conn->exec($sql);
            $sql = "CREATE TABLE if not exists BreakTime (User_id int, Date date not null, Time time not null)";
            $this->conn->exec($sql);
            
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
                return true;
            }
            else
            {
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