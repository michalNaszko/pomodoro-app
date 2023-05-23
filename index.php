<?php
    session_start();
    if (isset($_GET["logout"]))
    {
        $_SESSION['logged']=false;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <link rel="stylesheet" href="index.css">
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
                        if($_SESSION['logged']==false)
                        {
                    ?>
                            <li class="nav-item">
                                <a class="nav-link" href="login/login.php">Login</a>
                            </li>
                    <?php
                        }
                        else
                        {
                    ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="goToStatistics();">Statistics</a>
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
                <button id="btn-time-work" class="p-2 flex-fill btn btn-outline-light" type="button">Work</button>
                <button id="btn-time-sBreak" class="p-2 flex-fill btn btn-outline-light" type="button">Short break</button>
                <button id="btn-time-lBreak" class="p-2 flex-fill btn btn-outline-light" type="button">Long break</button>
            </div>

            <div id="timer-string" class="blocktext">25:00</div>

            <button id="btn-start" class="start btn btn-outline-light" type="button">Start</button>

        </div>

        <script src="pomodoro.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <script type="text/javascript">
            function goToStatistics() {
                console.log("In goToStatistics!!!");
                var sessionExist='<?php echo isset($_SESSION['logged']);?>';
                console.log("1 In goToStatistics!!!");
                if (sessionExist) {
                    var isLogged='<?php echo $_SESSION['logged'];?>';
                    console.log("2 In goToStatistics!!!");
                    console.log(isLogged);
                    if (isLogged)
                    {
                        console.log("3 In goToStatistics!!!");
                        window.location.href = 'statistics/index.php';
                        return false;
                    }
                }
                window.location.href = 'index.php';
                return false;
            }
        </script>
    </body>
</html> 