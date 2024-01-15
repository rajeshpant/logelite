<?php
class Role extends DB
{

    public static function getRole(){ 
        $qry = DB::$connection->query('SELECT * FROM `roles`');  
        $results = [];
        while($row = $qry->fetch_all(MYSQLI_ASSOC)){
            $results = $row;
        }
        return $results;
    }

    public static function saveRole($data){
        if(!empty($data['id'])){
            $stmt = DB::$connection->prepare('UPDATE roles SET `name` = ?, modified= now() WHERE id = ?');
            $stmt->bind_param("si", $data['name'], $data['id']);           
        } else {
            $stmt = DB::$connection->prepare('INSERT INTO roles (`name`, `status`, `created`, `modified`) VALUES (?, 1, now(), now())');
            $stmt->bind_param("s", $data['name']);
        }
        $stmt->execute();
        $stmt->close();
    }

    public static function deleteRole($id){
        $stmt = DB::$connection->prepare('DELETE FROM roles WHERE id = ?');
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public static function assignAccess($data) {
        foreach($data['action'] as $key => $val){
            $id = self::checkAccess($data['role'], $val);
            $is_access = $data['action_value'][$key];
            if($id>0){
                $stmt = DB::$connection->prepare('UPDATE user_role_access SET `is_access` = ? WHERE id = ?');
                $stmt->bind_param("ii", $is_access, $id);  
            } else {
                $stmt = DB::$connection->prepare('INSERT INTO user_role_access (`action`, `role_id`, `is_access`) VALUES (?, ?, ?)');
                $stmt->bind_param("sii", $val, $data['role'], $is_access);
            }
            $stmt->execute();
            $stmt->close();
        }
    }
    public static function checkAccess($role_id, $action, $is_access =0){
        $stmt = DB::$connection->prepare('SELECT id, is_access FROM `user_role_access` WHERE role_id = ? AND `action` = ?');
        $stmt->bind_param("is", $role_id, $action);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if($is_access){
            return $row['is_access'] ?? 0;
        } else {
            return $row['user_id'] ?? 0;
        }
    }
    public static function getAccess($role_id){
        $stmt = DB::$connection->prepare('SELECT * FROM `user_role_access` WHERE role_id = ?');
        $stmt->bind_param("i", $role_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $results = [];
        while($row = $result->fetch_assoc()){
            $results[] = $row;
        }
        return $results;
    }
}