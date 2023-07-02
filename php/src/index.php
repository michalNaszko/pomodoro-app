<?php
session_start();
if (isset($_GET["logout"])) {
    $_SESSION['logged'] = false;
}

if (!isset($_SESSION['logged'])) {
    $_SESSION['logged'] = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type = "text/javascript" src="statistics/dashboard.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="index.css">
    <link href="login/login.css" rel="stylesheet">
    <link href="statistics/dashboard.css" rel="stylesheet">
    <title>Pomodoro</title>

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Tenth navbar example">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
                <ul class="navbar-nav">
                    <?php
                    if ($_SESSION['logged'] == false) {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" id="loginHref" href="login/login.html">Login</a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="goToStatistics();">Statistics</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Remove Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?logout=true">Log Out</a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="timer-container p-5 text-white bg-dark rounded-3">

        <div class="d-flex bd-highlight">
            <button id="btn-time-work" class="p-2 flex-fill btn btn-outline-light active" type="button">Work</button>
            <button id="btn-time-sBreak" class="p-2 flex-fill btn btn-outline-light" type="button">Short break</button>
            <button id="btn-time-lBreak" class="p-2 flex-fill btn btn-outline-light" type="button">Long break</button>
        </div>

        <div id="timer-string" class="blocktext">01:00</div>

        <button id="btn-start" class="start btn btn-outline-light" type="button">Start</button>

    </div>

    <script src="pomodoro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $('#loginHref').on('click', function(e) {
            e.preventDefault();
            $('#loginModal').modal('show').find('.modal-content').load("login/login.html");
        });

        function goToStatistics() {
            var sessionExist = '<?php echo isset($_SESSION['logged']); ?>';
            if (sessionExist) {
                var isLogged = '<?php echo $_SESSION['logged']; ?>';
                console.log(isLogged);
                if (isLogged) {
                    $('#loginStat').modal('show').find('.modal-content').load("statistics/statisticsModal.php");
                    return false;
                }
            }
            window.location.href = 'index.php';
            return false;
        }
    </script>


    <!-- Modal for removing account -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-removing">
            <div class="modal-content">
                <div class="modal-body">
                    Are you sure that you want to remove account?
                </div>
                <div class="modal-footer">
                    <button id="btn-remove-account" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal for login/register -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-login" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <!-- Modal for statistics -->
    <div class="modal fade" id="loginStat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-fullscreen-xl-down modal-dialog-centered modal-stat" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>

</body>

</html>