<?php 
$page_title = 'Team List';
include('config.php');
hasAccess('team_list');
$results = Team::getTeam();
$activeUsers =  User::getActiveUser();
if(!empty($_POST['team_id'])){
    Team::deleteTeam($_POST['team_id']);
    echo 1;
    die;
} else if(!empty($_POST['assign_team_id'])){
  echo json_encode(Team::getTeamUser($_POST['assign_team_id']));
  die;
} else if(!empty($_POST['id'])){
  Team::assignTeam($_POST);
 header('location: teams.php');
}
include('header.php');
include('header.inc'); 
include('left.inc');
?>
<main id="main" class="main">
<div class="pagetitle">
  <h1>Team List</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Home</a></li>
      <li class="breadcrumb-item active">Team List</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Team List</h5>
          <table class="table datatable">
            <thead>
              <tr>
                <th>Team Id</th>
                <th>Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                <?php 
                if(!empty($results)){ 
                    foreach($results as $result){    
                ?>
              <tr>
                <td><?php echo $result['id'];?></td>
                <td><?php echo $result['name'];?></td>
                <td>
                <?php if($_SESSION['user']['role_id'] ==1 || Role::checkAccess($_SESSION['user']['role_id'], 'assign_user_team', 1)) { ?>
                    <a href="javascript:" onclick="assign_team(<?php echo $result['id'];?>)">Assign Team Memeber</a> |
                  <?php } ?>  
                  <?php if($_SESSION['user']['role_id'] ==1 || Role::checkAccess($_SESSION['user']['role_id'], 'team_edit', 1)) { ?>
                <a href="add_team.php?id=<?php echo $result['id'];?>">Edit</a> | 
                <?php } if($_SESSION['user']['role_id'] ==1 || Role::checkAccess($_SESSION['user']['role_id'], 'delete_team', 1)) { ?>
                <a href="javascript:" onclick="delete_team(<?php echo $result['id'];?>)">Delete</a>
              <?php } ?>
              </td>
              </tr>
              <?php } } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
</main>
<div class="modal fade" id="assignTeam" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Assign Member</h5>
          <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" enctype="multipart/form-data" id="uploadFile" action="teams.php">
          <input type="hidden" id="assign_team_id" name="id" />
        <div class="modal-body">
        <div class="row">          <h5 class="modal-title">Manager</h5>
              <?php  
              $teammember = ''; 
              foreach($activeUsers as $key=>$val) {
                if($val['role_id'] == 2){
                ?>
                <div class="col-3">
                    <div class="form-check">
                        <input class="form-check-input accecc_chk" type="radio" name="user[]" id="<?php echo $val['id'] ?>" value="<?php echo $val['id'] ?>" />
                        <label class="form-check-label" for="<?php echo $val['id'] ?>">
                            <?php echo ucfirst($val['name']) ?>
                        </label>
                    </div>
                </div>
              <?php  } else if($val['role_id']==3) {
                $teammember .='<div class="col-3">
                <div class="form-check">
                    <input class="form-check-input accecc_chk" type="checkbox" name="user[]" id="'.$val['id'].'" value="'. $val['id'].'" />
                    <label class="form-check-label" for="'. $val['id'].'">
                        '. ucfirst($val['name']) .'
                    </label>
                </div>
            </div>';
              } } ?>
        </div>        
        <div class="row">          <h5 class="modal-title">Team Member</h5><?php  echo $teammember; ?></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary close_btn" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" onclick="add_comment()">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<script>
  var span = document.getElementsByClassName("close")[0];
  var close_btn =document.getElementsByClassName("close_btn")[0];
  var modal = document.getElementById("assignTeam");
  span.onclick = function() {
    modal.style.display = "none";
    modal.classList.remove("show");
  }
  close_btn.onclick= function(){
      modal.style.display = "none";
      modal.classList.remove("show");
  }

    const delete_team = (id) => {
        var formData = new FormData();
        formData.append('team_id', id);
        const res = fetch("teams.php", {
            method: "POST",
            body: formData
        });
        res.then(res => res.json()).then(data => {
            location.reload();
        })
    }
    
function assign_team(id){
    var inputs = document.querySelectorAll('.accecc_chk');
    for (var i = 0; i < inputs.length; i++) {
      inputs[i].checked = false;
    }

    var modal = document.getElementById("assignTeam");
    modal.style.display = "block";
    modal.classList.add("show");
    document.getElementById('assign_team_id').value=id;
    var formData = new FormData();
    formData.append('assign_team_id', id);
    const res = fetch("teams.php", {
        method: "POST",
        body: formData
    });
    res.then(res => res.json()).then(data => {
      for (val of data) {
          document.getElementById(val).checked =true;
      }
    })
}
</script>
 <?php include('footer.php');