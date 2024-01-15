 <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link " href="dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <?php if($_SESSION['user']['role_id'] == 1 || Role::checkAccess($_SESSION['user']['role_id'], 'user_list', 1)) { ?>
      <li class="nav-item collapsed">
        <a class="nav-link collapsed" href="users.php">
          <i class="bi bi-menu-button-wide"></i><span>User</span>
        </a>
      </li>
      <?php } if($_SESSION['user']['role_id'] == 1 || Role::checkAccess($_SESSION['user']['role_id'], 'add_user', 1)) { ?>
      <li class="nav-item collapsed">
        <a class="nav-link collapsed" href="add_user.php">
          <i class="bi bi-menu-button-wide"></i><span>Add User</span>
        </a>
      </li>
      <?php } if($_SESSION['user']['role_id'] == 1 || Role::checkAccess($_SESSION['user']['role_id'], 'role_access', 1)) { ?>
      <li class="nav-item collapsed">
        <a class="nav-link collapsed" href="role_access.php">
          <i class="bi bi-menu-button-wide"></i><span>Role Access</span>
        </a>
      </li>
      <?php }  if($_SESSION['user']['role_id'] == 1 || Role::checkAccess($_SESSION['user']['role_id'], 'team_list', 1)) { ?>
      <li class="nav-item collapsed">
        <a class="nav-link collapsed" href="teams.php">
          <i class="bi bi-journal-text"></i><span>Team</span>
        </a>
      </li>
      <?php } if($_SESSION['user']['role_id'] == 1 || Role::checkAccess($_SESSION['user']['role_id'], 'add_team', 1)) { ?>
      <li class="nav-item collapsed">
        <a class="nav-link collapsed" href="add_team.php">
          <i class="bi bi-journal-text"></i><span>Add Team</span>
        </a>
      </li>
      <?php } if($_SESSION['user']['role_id'] == 1 || Role::checkAccess($_SESSION['user']['role_id'], 'task_list', 1)) { ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="tasks.php">
          <i class="bi bi-person"></i>
          <span>Task</span>
        </a>
      </li>
      <?php  } if($_SESSION['user']['role_id'] == 1 || Role::checkAccess($_SESSION['user']['role_id'], 'add_task', 1)) { ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="add_task.php">
          <i class="bi bi-person"></i>
          <span>Add Task</span>
        </a>
      </li>
      <?php } ?>
       <li class="nav-item">
        <a class="nav-link " href="logout.php">
          <i class="bi bi-grid"></i>
          <span>Logout</span>
        </a>
      </li>
    </ul>
  </aside>