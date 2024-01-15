<?php
class Team extends DB
{

    public static function getTeam(){ 
        $qry = DB::$connection->query('SELECT * FROM `teams`');  
        $results = [];
        while($row = $qry->fetch_all(MYSQLI_ASSOC)){
            $results = $row;
        }
        return $results;
    }
    public static function getTeamById($id){ 
        $stmt = DB::$connection->prepare('SELECT t.*, group_concat(tm.user_id) user_id FROM teams t LEFT JOIN team_members tm ON tm.team_id = t.id WHERE t.id = ? GROUP BY t.id ');
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row;
    }
    public static function saveTeam($data){
        if(!empty($data['id'])){
            $stmt = DB::$connection->prepare('UPDATE teams SET `name` = ?, modified= now() WHERE id = ?');
            $stmt->bind_param("si", $data['name'], $data['id']);  
            $stmt->execute();  
            $id = $data['id'];       
        } else {
            $stmt = DB::$connection->prepare('INSERT INTO teams (`name`, `status`, `created`, `modified`) VALUES (?, 1, now(), now())');
            $stmt->bind_param("s", $data['name']);
            $stmt->execute();
            $id = DB::$connection->insert_id;
        }
        $stmt->close();
        if(!empty($data['user'])){
            $user_id = self::getTeamUser($id);
            $del_user = array_diff($user_id, $data['user']);
            $add_user = array_diff($data['user'], $user_id);
            if(!empty($add_user)){
                foreach($add_user as $user){
                    $stmt = DB::$connection->prepare('INSERT INTO team_members (`user_id`, `team_id`) VALUES (?, ?)');
                    $stmt->bind_param("ii", $user, $id);
                    $stmt->execute();
                    $stmt->close();
                }
            }
            if(!empty($del_user)){
                foreach($del_user as $user){
                    $stmt = DB::$connection->prepare('DELETE FROM team_members WHERE  `user_id` = ?  AND `team_id` =?');
                    $stmt->bind_param("ii", $user, $id);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }
    }

    public static function deleteTeam($id){
        $stmt = DB::$connection->prepare('DELETE FROM teams WHERE id = ?');
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $stmt = DB::$connection->prepare('DELETE FROM team_members WHERE team_id = ?');
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    public static function getTeamUser($team_id){ 
        $stmt = DB::$connection->prepare('SELECT user_id FROM `team_members` WHERE team_id = ?');
        $stmt->bind_param("i", $team_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $results = [];
        while($row = $result->fetch_assoc()){
            $results[] = $row['user_id'];
        }
        return $results;
    }
}