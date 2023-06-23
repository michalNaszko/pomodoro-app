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

<div class="alert alert-warning" role="alert" style="display: none">
  Wrong login or password!
</div>

  <script>
    $(".btn-close").click(function() {
      $("#loginModal").modal('hide');
    });

    $('.text-info').on('click', function(e) {
            $('#loginModal').modal('show').find('.modal-content').load("login/register.php");
    });

    $('#login-form').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: 'login/test.php',
            type: 'POST',
            data:$('#login-form').serialize(),
            success:function(obj, textstatus, jqXHR){
              var data = $.parseJSON(obj);
              console.log('In test ajax success section: ' + obj);
              console.log('Type of obj: ' + typeof(obj));
              var expected = "success";
              console.log('Type of expected: ' + typeof(expected));
              console.log('In test ajax success section: ' + obj.result);
              if (data.result === "success")
              {
                window.location.href = "index.php";
              }
              else
              {
                $('.alert').show();
                setTimeout(function () {
                  // Closing the alert
                  $('.alert').hide();
                }, 2000);
              }
            }
        });
    });
  </script>

  <?php include '../dbCon.php'; {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = $_POST['username'];
      $password = $_POST['password'];
      if (Connection::login($username, $password)) {
        $_SESSION['logged'] = true;
        $_SESSION['username'] = $username;
        header("Location: ../index.php");
        die();
      }
    }
  }
  ?>