<?php include '../dbCon.php'; {
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (Connection::registerUser($username, $password)) {
    $_SESSION['logged'] = true;
    $_SESSION['username'] = $username;
    header("Location: ../index.php");
    die();
  }
}
}
?>

<div class="modal-header border-bottom-0">
  <button type="button" class="btn-close" aria-label="Close"></button>
</div>
<div class="modal-body">
  <div class="form-title text-center">
    <h4>Register</h4>
  </div>
  <div class="d-flex flex-column text-center">
    <form action="login/register.php" method="POST" id="login-form">
      <div class="flex-item form-group">
        <input type="email" class="form-control" id="email1" name="username" placeholder="Your email address...">
      </div>
      <div class="flex-item form-group">
        <input type="password" class="form-control" id="password1" name="password" placeholder="Your password...">
      </div>
      <button type="submit" class="btn btn-info btn-block btn-round flex-item">Register</button>
    </form>
  </div>
</div>
<div class="modal-footer d-flex justify-content-center">

  <script>
    $(".btn-close").click(function() {
      $("#loginModal").modal('hide');
    });
  </script>
