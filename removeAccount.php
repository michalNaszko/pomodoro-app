<?php include 'dbCon.php';{
session_start();

$aResult = array();
if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

if( !isset($aResult['error']) ) {
    switch($_POST['functionname']) {
        case 'removeAccount':
           removeAccount();
           break;

        default:
           $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
           break;
    }
}
echo json_encode($aResult);

    function removeAccount()
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

                $resultArray = array();
                
                $query = 'DELETE FROM `Work Time` WHERE (User_id = :id)';
                $resultArray[] = $conn->prepare($query)->execute(['id' => $id]);

                $query = 'DELETE FROM `Break Time` WHERE (User_id = :id)';
                $resultArray[] = $conn->prepare($query)->execute(['id' => $id]);

                $query = 'DELETE FROM `Users` WHERE (id = :id)';
                $resultArray[] = $conn->prepare($query)->execute(['id' => $id]);

                return $resultArray;
            }
            return null;
        }
        return null;
    }
    
}
?>