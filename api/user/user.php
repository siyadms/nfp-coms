<?php

    class User {
        var $db;
        function __construct($db) {
            $this->db = $db;
         }

        public function getUsers() {
            $sql = "SELECT * FROM User";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            echo json_encode($users);  
        }

        public function getUserDetails($id) {
            $sql = "SELECT * FROM User WHERE user_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $user = $stmt->fetch();
            echo json_encode($user);
        }

        public function createUser() {
            $user = json_decode(file_get_contents('php://input'));
            $sql = "INSERT INTO User(user_id, first_name, last_name, email, phone, gender, user_role) values(:user_id, :first_name, :last_name, :email, :phone, :gender, null)";
            $stmt = $this->db->prepare($sql);
            $user_id = ($this->db->query('CALL GetNextUserId()'))->fetch();
            $stmt->bindParam(':user_id', $user_id['user_id']);
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
        }

        public function updateUser() {
            $user = json_decode(file_get_contents('php://input'));
            $sql = "UPDATE User set first_name=:first_name, last_name=:last_name, email=:email, phone=:phone, gender=:gender WHERE user_id = :user_id";    
            $stmt = $this->db->prepare($sql);
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
        }

        public function deleteUser($id) {
            $sql = "DELETE FROM User WHERE user_id = :id";    
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            if($stmt->execute()) {
                $response = ['status' => 1, 'message' => 'Record deleted successfully.'];
            } else {
                $response = ['status' => 0, 'message' => 'Failed to delete record.'];
            }
            echo json_encode($response);
        }
    }

?>