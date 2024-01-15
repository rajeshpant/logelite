<?php 
$page_title = !empty($_GET['id']) ? 'Edit Task' : 'Add Task';
include('config.php');
if(!empty($_POST)){
    Task::saveTask($_POST);
    header('location: tasks.php');
} elseif (!empty($_GET['id'])){
    $task = Task::getTaskById($_GET['id']);
    $team_arr = explode(',', $task['team_id']);
}
include('header.php');
include('header.inc'); 
include('left.inc');
$teams = Team::getTeam();
?>
<main id="main" class="main">
    <div class="pagetitle">
    <h1><?php echo $page_title; ?></h1>
    <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="Tasks.php">Task List</a></li>
        <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
        </ol>
    </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $page_title; ?></h5>
                        <form class="row g-3" method="post">
                            <div class="col-12">
                                <label for="title" class="form-label">Title</label>
                                <input type="hidden" value="<?php echo !empty($task['id']) ? $task['id'] :'' ?>" name="id" id="id" />
                                <input type="text" class="form-control" id="title" name="title" required value = "<?php echo !empty($task['title']) ? $task['title'] :'' ?>" />
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" placeholder="Description" id="description" style="height: 100px;" name="description"><?php echo !empty($task['description']) ? $task['description'] :'' ?></textarea>
                            </div>
                            <div class="col-12">
                                <label for="due_date" class="col-sm-2 col-form-label">Due Date</label>
                                <input type="date" class="form-control" id="due_date" name="due_date" value="<?php echo !empty($task['due_date']) ? $task['due_date'] :'' ?>">
                            </div>
                            <div class="col-12">
                                <label for="priority" class="form-label">Priority</label>
                                <select id="priority" name="priority" class="form-select" required>
                                    <option selected="">Choose Priority...</option>
                                    <option value="1"  <?php echo (!empty($task['priority']) && $task['priority'] == 1) ? 'selected' :'' ?>>High</option>
                                    <option value="2"  <?php echo (!empty($task['priority']) && $task['priority'] == 2) ? 'selected' :'' ?>>Normal</option>
                                    <option value="3"  <?php echo (!empty($task['priority']) && $task['priority'] == 3) ? 'selected' :'' ?>>Low</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status" class="form-select" required>
                                    <option selected="">Choose Status...</option>
                                    <?php foreach($task_status as $key => $val) { ?>
                                    <option value="<?php echo $key; ?>"  <?php echo (isset($task['status']) && $task['status'] == $key) ? 'selected' :'' ?>><?php echo $val; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="team" class="form-label">Team</label>
                                <select id="team" name="team[]" class="form-select" multiple="" aria-label="multiple select example" required>
                                    <option>Choose Team...</option>
                                    <?php foreach($teams as $team) { ?>
                                    <option value="<?php echo $team['id'];?>"  <?php echo (!empty($team_arr) && in_array( $team['id'], $team_arr)) ? 'selected' :'' ?>><?php echo $team['name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="btn_Task_add">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
 <? include('footer.php');