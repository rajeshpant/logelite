<?php 
if(empty($_SESSION['user'])){
    header('location:index.php');
    die;
}
?>
<header id="header" class="header fixed-top d-flex align-items-center">
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="javascript:" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-2">
                <?php echo ucfirst($_SESSION['user']['name']); ?>
            </span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
</header>