<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: *");

    include("DbConnect.php");
    $conn = new DbConnect();
    $db = $conn->connect();
    $url_path = explode('/', $_SERVER['REQUEST_URI']);
    $method = $_SERVER['REQUEST_METHOD'];
    $url_matcher = $method.' '.$url_path[1];
    switch($url_matcher) {
        case 'POST user':
            $user = json_decode(file_get_contents('php://input'));
            $sql = "INSERT INTO User(user_id, first_name, last_name, email, phone, gender, user_role) values('AMIA00124', :first_name, :last_name, :email, :phone, :gender, null)";
            $stmt = $db->prepare($sql);
            //$date = date('Y-m-d');
            $stmt->bindParam(':first_name', $user->first_name);
            $stmt->bindParam(':last_name', $user->last_name);
            $stmt->bindParam(':email', $user->email);
            $stmt->bindParam(':phone', $user->phone);
            $stmt->bindParam(':gender', $user->gender);
            //$stmt->bindParam(':created_at', $date);
            if($stmt->execute()) {
                $data = ['status' => 1, 'message' => "Record successfully created"];
            } else {
                $data = ['status' => 0, 'message' => "Failed to create record."];
            }
            echo json_encode($data);
            break;
        case 'GET user':
            $sql = "SELECT * FROM User WHERE user_id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $url_path[2]);
            $stmt->execute();
            $user = $stmt->fetch();
            echo json_encode($user);
            break;
        case 'GET users':
            $sql = "SELECT * FROM User";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            echo json_encode($users);       
            break;
        case 'PUT user': 
            $user = json_decode(file_get_contents('php://input'));
            $sql = "UPDATE User set first_name=:first_name, last_name=:last_name, email=:email, phone=:phone, gender=:gender WHERE user_id = :user_id";    
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':first_name', $user->first_name);
            $stmt->bindParam(':last_name', $user->last_name);
            $stmt->bindParam(':email', $user->email);
            $stmt->bindParam(':phone', $user->phone);
            $stmt->bindParam(':gender', $user->gender);
            $stmt->bindParam(':user_id', $user->user_id);
            if($stmt->execute()) {
                $response = ['status' => 1, 'message' => 'Record updated successfully.'];
            } else {
                $response = ['status' => 0, 'message' => 'Failed to updated record.'];
            }
            echo json_encode($response);
            break;
        case 'DELETE users': 
            $sql = "DELETE FROM User WHERE user_id = :id";    
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $url_path[2]);
            if($stmt->execute()) {
                $response = ['status' => 1, 'message' => 'Record deleted successfully.'];
            } else {
                $response = ['status' => 0, 'message' => 'Failed to delete record.'];
            }
            echo json_encode($response);
            break;
        default:
            echo $url_matcher;
    }
?>

