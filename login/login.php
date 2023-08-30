<?php include '../dbCon.php'; {
session_start();
$result['result'] = 'fail';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];
  if (Connection::login($username, $password)) {
    $_SESSION['logged'] = true;
    $_SESSION['username'] = $username;
    $result['result'] = 'success';
  }
}
$result['logged'] = $_SESSION['logged'];
echo json_encode($result);
}