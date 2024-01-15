<?php
class Task extends DB
{

    public static function getTask(){ 
        $qry = DB::$connection->query('SELECT * FROM `tasks`');  
        $results = [];
        while($row = $qry->fetch_all(MYSQLI_ASSOC)){
            $results = $row;
        }
        return $results;
    }
    public static function getTaskByUser($user_id){ 
        $stmt = DB::$connection->prepare('SELECT t.* FROM tasks t INNER JOIN team_tasks tt ON tt.task_id = t.id INNER JOIN team_members tm on tm.team_id = tt.team_id WHERE tm.user_id = ? GROUP BY t.id ');
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $results = [];
        while($row = $result->fetch_assoc()){
            $results[] = $row;
        }
        return $results;
    }
    public static function getTaskById($id){ 
        $stmt = DB::$connection->prepare('SELECT t.*, group_concat(tt.team_id) team_id FROM tasks t LEFT JOIN team_tasks tt ON tt.task_id = t.id WHERE t.id = ? GROUP BY t.id ');
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row;
    }
    public static function saveTask($data){
        if(!empty($data['id'])){
            $stmt = DB::$connection->prepare('UPDATE tasks SET `title` = ?, `description` = ?, `priority` = ?, `due_date` = ?, `status` = ?, modified= now() WHERE id = ?');
            $stmt->bind_param("ssisii", $data['title'], $data['description'], $data['priority'], $data['due_date'], $data['status'], $data['id']);
            $stmt->execute();   
            $id = $data['id'];        
        } else {
            $stmt = DB::$connection->prepare('INSERT INTO tasks (`title`, `description`, `priority`, `due_date`,   `created`, `modified`) VALUES (?, ?, ?, ?, now(), now())');
            $stmt->bind_param("ssis", $data['title'], $data['description'], $data['priority'], $data['due_date']);
            $stmt->execute();
            $id = DB::$connection->insert_id;
        }
        $stmt->close();
        if(!empty($data['team'])){
            $team_id = self::getTaskTeam($id);
            $del_team = array_diff($team_id, $data['team']);
            $add_team = array_diff($data['team'], $team_id);
            if(!empty($add_team)){
                foreach($add_team as $team){
                    $stmt = DB::$connection->prepare('INSERT INTO team_tasks (`team_id`, `task_id`) VALUES (?, ?)');
                    $stmt->bind_param("ii", $team, $id);
                    $stmt->execute();
                    $stmt->close();
                }
            }
            if(!empty($del_team)){
                foreach($del_team as $team){
                    $stmt = DB::$connection->prepare('DELETE FROM team_tasks WHERE  `team_id` = ?  AND `task_id` =?');
                    $stmt->bind_param("ii", $team, $id);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }
        return $id;
    }

    public static function deleteTask($id){
        $stmt = DB::$connection->prepare('DELETE FROM tasks WHERE id = ?');
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $stmt = DB::$connection->prepare('DELETE FROM team_tasks WHERE  `task_id` =?');
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    public static function getTaskTeam($task_id){ 
        $stmt = DB::$connection->prepare('SELECT team_id FROM `team_tasks` WHERE task_id = ?');
        $stmt->bind_param("i", $task_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $results = [];
        while($row = $result->fetch_assoc()){
            $results[] = $row['team_id'];
        }
        return $results;
    }

    public static function updateStatus($id, $status){
        $stmt = DB::$connection->prepare('UPDATE tasks SET `status` = ?, modified= now() WHERE id = ?');
        $stmt->bind_param("si", $status, $id); 
        $stmt->execute();
    }
    public static function updateComment($id, $comment, $files){
        $stmt = DB::$connection->prepare('UPDATE tasks SET  `status` = 1, `comment` = ?, file = ?, modified= now() WHERE id = ?');
        $stmt->bind_param("ssi", $comment, $files, $id); 
        $stmt->execute();
    }
}