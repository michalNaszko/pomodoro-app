<?php
session_start();
?>

<div class="modal-header border-bottom-0">
  <button type="button" class="btn-close" aria-label="Close"></button>
</div>
<div class="modal-body">
  <div class="form-title text-center">
    <h4>Login</h4>
  </div>
  <div class="d-flex flex-column text-center">
    <form action="login/login.php" method="POST" id="login-form">
      <div class="flex-item form-group">
        <input type="email" class="form-control" id="email1" name="username" placeholder="Your email address...">
      </div>
      <div class="flex-item form-group">
        <input type="password" class="form-control" id="password1" name="password" placeholder="Your password...">
      </div>
      <button type="submit" class="btn btn-info btn-block btn-round flex-item">Login</button>
    </form>
  </div>
</div>
<div class="modal-footer d-flex justify-content-center">
  <div class="signup-section">Do not have account? <a href="#a" class="text-info"> Create account</a>.</div>


  <script>
    $(".btn-close").click(function() {
      $("#loginModal").modal('hide');
    });

    $('.text-info').on('click', function(e) {
            $('#loginModal').modal('show').find('.modal-content').load("login/register.php");
    });
  </script>

  <?php include '../dbCon.php'; {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = $_POST['username'];
      $password = $_POST['password'];
      if (Connection::login($username, $password)) {
        $_SESSION['logged'] = true;
        $_SESSION['username'] = $username;
        echo $_SESSION['username'];
        header("Location: ../index.php");
        die();
      }
    }
  }
  ?>