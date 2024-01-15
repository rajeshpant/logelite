<?php
class User extends DB
{

    public static function getUser(){ 
        $qry = DB::$connection->query('SELECT u.*, r.name as role FROM `users` u inner join roles r on r.id=u.role_id');  
        $results = [];
        while($row = $qry->fetch_all(MYSQLI_ASSOC)){
            $results = $row;
        }
        return $results;
    }
    public static function getUserById($id){ 
        $stmt = DB::$connection->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row;
    }
    public static function getUserByEmail($email){ 
        $stmt = DB::$connection->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row;
    }
    public static function saveUser($data){
        try {
            if(!empty($data['id'])){
                $stmt = DB::$connection->prepare('UPDATE users SET `name` = ?, `gender` = ?, `role_id` = ?, modified= now() WHERE id = ?');
                $stmt->bind_param("ssii", $data['name'], $data['gender'], $data['role'], $data['id']);  
                $stmt->execute();
                if(!empty($data['password'])){
                    $stmt = DB::$connection->prepare('UPDATE users SET `password` = ? WHERE id = ?');
                    $stmt->bind_param("si", md5($data['password']), $data['id']); 
                    $stmt->execute();
                }  
                $id = $data['id'];       
            } else {
                $stmt = DB::$connection->prepare('INSERT INTO users (`name`, email, `password`, `gender`,  `role_id`, `status`, `created`, `modified`) VALUES (?, ?, ?, ?, ?, 1, now(), now())');
                $stmt->bind_param("ssssi", $data['name'], $data['email'], md5($data['password']), $data['gender'], $data['role']);
                $stmt->execute();
                $id = DB::$connection->insert_id;
            }
            $stmt->close();
            return $id;
        } catch(Exception $e) {
            if(DB::$connection->errno === 1062) return 'Email alredy used';
        }
    }

    public static function deleteUser($id){
        $stmt = DB::$connection->prepare('DELETE FROM users WHERE id = ?');
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public static function updateUserStaus($id, $status){
        $stmt = DB::$connection->prepare('UPDATE users SET `status` = ?, modified= now() WHERE id = ?');
        $stmt->bind_param("ii", $status, $id);  
        $stmt->execute();
    }

    public static function getActiveUser(){ 
        $stmt = DB::$connection->prepare('SELECT * FROM users WHERE `status` = 1');
        $stmt->execute();
        $result = $stmt->get_result();
        $results = [];
        while($row = $result->fetch_assoc()){
            $results[] = $row;
        }
        return $results;
    }
}