<?php 
$page_title = 'User List';
include('config.php');
$results = User::getUser();
if(!empty($_POST['user_id'])){
    User::deleteUser($_POST['user_id']);
    echo 1;
    die;
}
include('header.php');
include('header.inc'); 
include('left.inc');
?>
<main id="main" class="main">
<div class="pagetitle">
  <h1>User List</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Home</a></li>
      <li class="breadcrumb-item active">User List</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">User List</h5>
          <table class="table datatable">
            <thead>
              <tr>
                <th>User Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Role</th>
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
                <td><?php echo $result['email'];?></td>
                <td><?php echo $result['gender'];?></td>
                <td><?php echo $result['role'];?></td>
                <td><a href="add_user.php?id=<?php echo $result['id'];?>">Edit</a> | <a href="javascript:" onclick="delete_user(<?php echo $result['id'];?>)">Delete</a></td>
              </tr>
              <?php } } ?>
            </tbody>
          </table>
          <!-- End Table with stripped rows -->
        </div>
      </div>
    </div>
  </div>
</section>
</main>
<script>
    const delete_user = (id) => {
        var formData = new FormData();
        formData.append('user_id', id);
        const res = fetch("users.php", {
            method: "POST",
            body: formData
        });
        res.then(res => res.json()).then(data => {
            location.reload();
        })
    }
</script>
 <?php include('footer.php');