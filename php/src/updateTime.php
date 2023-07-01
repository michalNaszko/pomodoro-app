<?php include 'dbCon.php';{
session_start();

$aResult = array();
if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

if( !isset($aResult['error']) ) {
    switch($_POST['functionname']) {
        case 'updateTime':
            if (isset($_POST['time']) and isset($_POST['activity']))
            {
                $aResult['result'] = updateTime($_POST['time'], $_POST['activity']);
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

    function updateTime($time, $activity)
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
                $id = $row['id'];

                if (strpos($activity, "work") !== false) {
                    $table = 'WorkTime';
                }
                else
                {
                    $table = 'BreakTime';
                }

                $query = 'SELECT Date, Time FROM '.'`'.$table.'` WHERE (User_id = :id) AND (Date = CURDATE()) ORDER BY Date';
                $stmt = $conn->prepare($query);
                $stmt->execute(['id' => $id]);

                $rows = $stmt->fetchAll();
                if (is_array($rows))
                {
                    if ($stmt->rowCount() > 0)
                    {
                        $query = "UPDATE "."`".$table."` SET Time = ADDTIME(Time, '00:".$time."') WHERE (User_id = :id) AND (Date = :date)";
                        return $conn->prepare($query)->execute(['id' => $id, 'date' => date("Y-m-d")]);
                    }
                    else
                    {
                        $query = 'INSERT INTO '.'`'.$table.'` (User_id, Date, Time) VALUES (:id, :date, :time)';
                        return $conn->prepare($query)->execute(['id' => $id, 'date' => date("Y-m-d"), 'time' => '00:'.$time]);
                    }
                }
                return null;
            }
        }
    }
    return null;
}
?>