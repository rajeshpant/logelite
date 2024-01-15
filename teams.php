<?php 
$page_title = 'Team List';
include('config.php');
$results = Team::getTeam();
if(!empty($_POST['team_id'])){
    Team::deleteTeam($_POST['team_id']);
    echo 1;
    die;
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
                <td><a href="add_team.php?id=<?php echo $result['id'];?>">Edit</a> | <a href="javascript:" onclick="delete_team(<?php echo $result['id'];?>)">Delete</a></td>
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
<script>
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
</script>
 <?php include('footer.php');