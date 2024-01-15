<?php 
$page_title = 'View Task';
include('config.php');
hasAccess('task_list');
$results = Task::getTaskById($_GET['id']);
include('header.php');
include('header.inc'); 
include('left.inc');
?>
<main id="main" class="main">
<div class="pagetitle">
  <h1>View Task</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/">Home</a></li>
      <li class="breadcrumb-item"><a href="tasks.php">Task</a></li>
      <li class="breadcrumb-item active">View Task</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="row">
    <div class="col-lg-3">Task Name</div>
    <div class="col-lg-3"><?php echo $results['name'] ?></div>
    </div>
    <div class="row">
    <div class="col-lg-3">Comment</div>
    <div class="col-lg-3"><?php echo $results['comment'] ?></div>
    </div>
    <div class="row">
    <div class="col-lg-3">File</div>
    <div class="col-lg-3"><a href="upload/<?php echo $results['file'] ?>" download=""><?php echo $results['file'] ?></a></div>
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

  <div class="modal fade" id="assignTeam" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Assign Member</h5>
          <button type="button" class="btn-close assign_close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" enctype="multipart/form-data" id="uploadFile" action="tasks.php">
          <input type="hidden" id="assign_task_id" name="id" />
        <div class="modal-body">
          <div class="row">          <h5 class="modal-title">Teams</h5>
            <?php foreach($teams as $key=>$val) { ?>
              <div class="col-3">
                  <div class="form-check">
                      <input class="form-check-input accecc_chk" type="checkbox" name="team[]" id="<?php echo $val['id'] ?>" value="<?php echo $val['id'] ?>" />
                      <label class="form-check-label" for="<?php echo $val['id'] ?>">
                          <?php echo ucfirst($val['name']) ?>
                      </label>
                  </div>
              </div>  
            <?php } ?>
          </div>        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary assign_close_btn" data-bs-dismiss="modal">Close</button>
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
var assign_span = document.getElementsByClassName("assign_close")[0];
var assign_close_btn =document.getElementsByClassName("assign_close_btn")[0];
var modal = document.getElementById("completeTask");
var assign_modal = document.getElementById("assignTeam");
span.onclick = function() {
  modal.style.display = "none";
  modal.classList.remove("show");
}
close_btn.onclick= function(){
    modal.style.display = "none";
    modal.classList.remove("show");
}
assign_span.onclick = function() {
  assign_modal.style.display = "none";
  assign_modal.classList.remove("show");
}
assign_close_btn.onclick= function(){
  assign_modal.style.display = "none";
  assign_modal.classList.remove("show");
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
function assign_team(id){
    var modal = document.getElementById("assignTeam");
    modal.style.display = "block";
    modal.classList.add("show");
    document.getElementById('assign_task_id').value=id;
    var formData = new FormData();
    formData.append('assign_task_id', id);
    const res = fetch("tasks.php", {
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