<?php 
$page_title = 'Task List';
include('config.php');
$user_id = $_SESSION['user']['id'];
if($_SESSION['user']['role_id']==3){
  $results = Task::getTaskByUser($user_id);
} else {
  $results = Task::getTask();
}
if(isset($_FILES['files'])){
  $uploads_dir = "upload";
    $tmp_name = $_FILES["files"]["tmp_name"];
    $name = date('YmdHis').'_'.basename($_FILES["files"]["name"]);
    move_uploaded_file($tmp_name, "$uploads_dir/$name");
    Task::updateComment($_POST['task_id'], $_POST['comment'], $name);
  die('1');
} else if(!empty($_POST['task_id'])){
    Task::deleteTask($_POST['task_id']);
    echo 1;
    die;
} else if(isset($_POST['status'])){
    Task::updateStatus($_POST['id'], $_POST['status']);
    echo 1;
    die;
} 
include('header.php');
include('header.inc'); 
include('left.inc');
?>
<main id="main" class="main">
<div class="pagetitle">
  <h1>Task List</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Home</a></li>
      <li class="breadcrumb-item active">Task List</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Task List</h5>
          <table class="table datatable">
            <thead>
              <tr>
                <th>Task Id</th>
                <th>Title</th>
                <th>Priority</th>
                <th>Due Date</th>
                <th>Status</th>
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
                <td><?php echo $result['title'];?></td>
                <td><?php echo $result['priority'];?></td>
                <td><?php echo $result['due_date'];?></td>
                <td>
                  <?php if($result['status'] !=1) {
                     if($_SESSION['user']['role_id'] == 3) { ?>
                      <select id="status" name="status" class="form-select task_status" required data-id="<?php echo $result['id'];?>" onchange="update_status(<?php echo $result['id'];?>, this.value)">
                          <option>Choose Status...</option>
                          <?php foreach($task_status as $key => $val) { ?>
                          <option value="<?php echo $key; ?>"  <?php echo (isset($result['status']) && $result['status'] == $key) ? 'selected' :'' ?>><?php echo $val; ?></option>
                          <?php } ?>
                      </select>
                  <?php }  else { ?>
                    <?php echo $task_status[$result['status']]; ?> <a href="javascript:" onclick="update_status(<?php echo $result['id'];?>, 1, 0)">Complete Task</a>
                    <?php } } else { ?>
                      Completed
                      <?php } ?>
                  
                </td>
                <td>
                  <?php if(Role::checkAccess($_SESSION['user']['role_id'], 'task_edit', 1)) { ?>
                    <a href="add_task.php?id=<?php echo $result['id'];?>">Edit</a> |
                  <?php } ?>
                  <?php if(Role::checkAccess($_SESSION['user']['role_id'], 'delete_task', 1)) { ?>
                    <a href="javascript:" onclick="delete_task(<?php echo $result['id'];?>)">Delete</a>
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
<div class="modal fade" id="completeTask" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Complete Task</h5>
          <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" enctype="multipart/form-data" id="uploadFile" action="tasks.php">
        <div class="modal-body">
            <div class="col-12">
                <label for="comment" class="form-label">Comment</label>
                <textarea class="form-control" placeholder="Remark" id="comment" style="height: 100px;" name="comment" require></textarea>
                <input type="hidden" class="form-control" id="task_id" name="task_id" />
            </div>
            <div class="col-12">
                <label for="files" class="col-sm-2 col-form-label">File Upload</label>
                <input class="form-control" type="file" id="files" name="files" require />
            </div>
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
    const delete_task = (id) => {
        var formData = new FormData();
        formData.append('task_id', id);
        const res = fetch("tasks.php", {
            method: "POST",
            body: formData
        });
        res.then(res => res.json()).then(data => {
            location.reload();
        })
    }
    
var span = document.getElementsByClassName("close")[0];
var close_btn =document.getElementsByClassName("close_btn")[0];
var modal = document.getElementById("completeTask");
span.onclick = function() {
  modal.style.display = "none";
  modal.classList.remove("show");
}
close_btn.onclick= function(){
    modal.style.display = "none";
    modal.classList.remove("show");
}
    function update_status(id, status, is_popup = 1){
      if(status == 1 && is_popup ==1){
        var modal = document.getElementById("completeTask");
        modal.style.display = "block";
        modal.classList.add("show");
        document.getElementById('task_id').value=id;
      } else {
          var formData = new FormData();
          formData.append('status', status);
          formData.append('id', id);
          const res = fetch("tasks.php", {
              method: "POST",
              body: formData
          });
          res.then(res => res.json()).then(data => {
              alert('Task Status changed successfully');
              location.reload();
          })
      }
    }
function add_comment(){
  if(document.getElementById('comment')==''){
    alert('Please enter comment');
    return false;
  }
  if(document.getElementById('files')==''){
    alert('Please upload a file');
    return false;
  }
  let form = document.getElementById('uploadFile');
  form.addEventListener('submit', handleSubmit); 
} 
function handleSubmit(event) {
  const form = event.currentTarget;
  const url = new URL(form.action);
  const formData = new FormData(form);
  const searchParams = new URLSearchParams(formData);
  const fetchOptions = {
    method: form.method,
  };

  if (form.method.toLowerCase() === 'post') {
    if (form.enctype === 'multipart/form-data') {
      fetchOptions.body = formData;
    } else {
      fetchOptions.body = searchParams;
    }
  } else {
    url.search = searchParams;
  }

  fetch(url, fetchOptions);

  event.preventDefault();
  location.reload();
}
</script>
 <?php include('footer.php');