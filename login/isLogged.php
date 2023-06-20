<?php
 
    if (isset($_SESSION['logged']))
    {
    $result = $_SESSION['logged'];
    }
    else
    {
    $result = false;
    }

    echo json_encode($result);

?>