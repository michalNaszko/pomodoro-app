<?php include '../dbCon.php';{
session_start();

$aResult = array();
if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }
if( !isset($aResult['error']) ) {
    switch($_POST['functionname']) {
        case 'retrieveStatistics':
            $aResult['result'] = retrieveStatistics();
           break;

        default:
           $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
           break;
    }
}
echo json_encode($aResult);

    function retrieveStatistics()
    {
        if(!isset($_SESSION['logged'])) 
            return null;
        if($_SESSION['logged'])
        {
            $conn = Connection::getConnection();
            $username = $_SESSION ['username'];
            // echo $username."<br/>";
            $query = 'SELECT id FROM Users WHERE (login = :username)';
            $stmt = $conn->prepare($query);
            $stmt->execute(['username' => $username]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (is_array($row))
            {
                $id = $row['id'];

                $query = 'SELECT Date, Time FROM `Work Time` WHERE (User_id = :id) ORDER BY Date';
                $stmt = $conn->prepare($query);
                $stmt->execute(['id' => $id]);

                $rows = $stmt->fetchAll();
                if (is_array($rows))
                {
                    $result = array_map(function($r) {
                        return ['Date' => $r['Date'], 'Time' => $r['Time']];
                    }, $rows);
                    // echo "Inside if"."<br/>";
                    return $result;
                }
                return null;
            }
            else
            {
                echo "Wrong login!\n"."<br/>";
                return null;
            }
        }
    }
    
}
?>