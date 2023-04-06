<html>
    <head>
        <title>My first PHP Website</title>
    </head>
    <body>
        <h2>Login Page</h2>
        <a href="index.php">Click here to go back</a><br/><br/>
        <form action="login.php" method="POST">
           Enter Username: <input type="text" 
           name="username" required="required" /> <br/>
           Enter password: <input type="password" 
           name="password" required="required" /> <br/>
           <input type="submit" value="Login"/>
        </form>
    </body>
</html>

<?php include 'dbCon.php';{

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];

    Connection::login($username, $password);
}  
}
?>