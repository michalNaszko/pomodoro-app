<html>
    <head>
        <title>My first PHP Website</title>
    </head>
    <body>
        <h2>Registration Page</h2>
        <a href="index.php">Click here to go back</a><br/><br/>
        <form action="register.php" method="POST">
           Enter Username: <input type="text" 
           name="username" required="required" /> <br/>
           Enter password: <input type="password" 
           name="password" required="required" /> <br/>
           <input type="submit" value="Register"/>
        </form>
    </body>
</html>

<?php include 'dbCon.php';{

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $conn = Connection::getConnection();

        $username = $conn->quote($_POST['username']);
        $password = $conn->quote($_POST['password']);
        
        $sql = 'INSERT INTO Users (id, login, password) VALUES (NULL, $username, $password)';
        $conn->query($sql);
    }
    
}
?>