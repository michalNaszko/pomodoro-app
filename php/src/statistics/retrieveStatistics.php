<?php include '../dbCon.php';{
session_start();

$aResult = array();
if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

if( !isset($aResult['error']) ) {
    switch($_POST['functionname']) {
        case 'retrieveStatistics':
            if (isset($_POST['period']) and isset($_POST['activity']))
            {
                $aResult['result'] = retrieveStatistics($_POST['period'], $_POST['activity']);
            }
            else
            {
                $aResult['error'] = 'Lack of arguments for function '.$_POST['functionname'].'!';
            }
           break;

        default:
           $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
           break;
    }
}
echo json_encode($aResult);

    function retrieveStatistics($period, $activity)
    {
        if(!isset($_SESSION['logged'])) 
            return null;

        if($_SESSION['logged'])
        {
            $conn = Connection::getConnection();
            $username = $_SESSION ['username'];

            $query = 'SELECT id FROM Users WHERE (login = :username)';
            $stmt = $conn->prepare($query);
            $stmt->execute(['username' => $username]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (is_array($row))
            {
                switch ($activity) {
                    case 'Break time':
                        $table = 'BreakTime';
                        break;
                    case 'Focus time':
                        $table = 'WorkTime';
                        break;
                    default:
                        return null;
                }

                switch ($period) {
                    case 'This week':
                        $timeCondition = 'Date >= DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY) AND Date <= CURDATE()';
                        break;
                    case 'Last week':
                        $timeCondition = 'WEEK(Date, 1) = WEEK(DATE_SUB(CURDATE(), INTERVAL 1 WEEK), 1)';
                        break;
                    case 'This month':
                        $timeCondition = 'MONTH(Date) = MONTH(CURDATE())';
                        break;
                    case 'Last month':
                        $timeCondition = 'MONTH(Date) = (MONTH(CURDATE()) - 1)';
                        break;
                    default:
                        return null;
                }

                $id = $row['id'];

                $query = 'SELECT Date, Time FROM '.'`'.$table.'` WHERE (User_id = :id) AND '.$timeCondition.' ORDER BY Date';
                $stmt = $conn->prepare($query);
                $stmt->execute(['id' => $id]);

                $rows = $stmt->fetchAll();
                if (is_array($rows))
                {
                    $result = array_map(function($r) {
                        return ['Date' => $r['Date'], 'Time' => $r['Time']];
                    }, $rows);
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