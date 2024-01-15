 <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link " href="dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <?php if($_SESSION['user']['role_id'] ==1) { ?>
      <li class="nav-item collapsed">
        <a class="nav-link collapsed" href="users.php">
          <i class="bi bi-menu-button-wide"></i><span>User</span>
        </a>
      </li>
      <li class="nav-item collapsed">
        <a class="nav-link collapsed" href="add_user.php">
          <i class="bi bi-menu-button-wide"></i><span>AddUser</span>
        </a>
      </li>
      <?php }  if(in_array($_SESSION['user']['role_id'],[1,2])) { ?>
      <li class="nav-item collapsed">
        <a class="nav-link collapsed" href="teams.php">
          <i class="bi bi-journal-text"></i><span>Team</span>
        </a>
      </li>
      <?php } if($_SESSION['user']['role_id'] ==1) { ?>
      <li class="nav-item collapsed">
        <a class="nav-link collapsed" href="teams.php">
          <i class="bi bi-journal-text"></i><span>Add Team</span>
        </a>
      </li>
      <?php } ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="tasks.php">
          <i class="bi bi-person"></i>
          <span>Task</span>
        </a>
      </li>
    </ul>
  </aside>