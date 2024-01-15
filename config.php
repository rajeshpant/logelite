<?php 
    error_reporting(1);
    session_start();
    $host ='localhost';
    $user = 'root';
    $pass = '';
    $dbName = 'logelite';
	spl_autoload_register(function ($class_name) { 
	    include 'classes/'.$class_name . '.php'; 
	}); 
	$dbObj = DB:: getInstance(); 
    $dbObj->connect($host, $user, $pass, $dbName);
    $task_status = [0=> 'Pending', 1 => 'Complete', 2=> 'In Progress', 3 => 'Hold', 4 => 'Closed'];
    $action_arr = ['user_list' => 'User List', 'user_add' => 'Add User', 'edit_user' => 'Edit User', 'User_status' => 'User Status', 'user_delete' => 'User Delete', 'add_team' => 'Add Team', 'team_list' => 'Team List', 'team_edit' => 'Edit Team', 'delete_team' => 'Team Delete', 'add_task' => 'Add Task', 'task_list' => 'Task List', 'task_edit' => 'Edit Task', 'delete_task' => 'Task Delete', 'assign_user_team' => 'Assign User To Team', 'assign_team_task' => 'Assign Team To Task', 'role' => 'Role', 'role_access' => 'Role Access'];

    function hasAccess($action) {
        if($_SESSION['user']['role_id'] != 1 && !Role::checkAccess($_SESSION['user']['role_id'], $action, 1)) {
            header('location: dashboard.php');
        }
    }