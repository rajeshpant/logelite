<?php 
$page_title = !empty($_GET['id']) ? 'Edit Team' : 'Add Team';
include('config.php');
hasAccess('add_team');
if(!empty($_POST)){
    Team::saveTeam($_POST);
    header('location: teams.php');
} elseif (!empty($_GET['id'])){
    $team = Team::getTeamById($_GET['id']);
    $user_arr = explode(',', $team['user_id']);
}
include('header.php');
include('header.inc'); 
include('left.inc');
$users = User::getActiveUser();
?>
<main id="main" class="main">
    <div class="pagetitle">
    <h1><?php echo $page_title; ?></h1>
    <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="team.php">Team List</a></li>
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
                                <label for="name" class="form-label">Name</label>
                                <input type="hidden" value="<?php echo !empty($team['id']) ? $team['id'] :'' ?>" name="id" id="id" />
                                <input type="text" class="form-control" id="name" name="name" required value = "<?php echo !empty($team['name']) ? $team['name'] :'' ?>" />
                            </div>
                            <div class="col-12">
                                <label for="manager" class="form-label">Manager</label>
                                <select id="manager" name="user[]" class="form-select" aria-label="multiple select example" required>
                                    <option>Choose Manager...</option>
                                    <?php $memeber = '';
                                     foreach($users as $val) { 
                                        if($val['role_id'] == 2) {    
                                    ?>
                                        <option value="<?php echo $val['id'];?>"  <?php echo (!empty($user_arr) && in_array( $val['id'], $user_arr)) ? 'selected' :'' ?>><?php echo $val['name'];?></option>
                                    <?php } else if($val['role_id'] == 3) {  
                                        $memeber .= '<option value="'. $val['id'].'"  '. ((!empty($user_arr) && in_array( $val['id'], $user_arr)) ? 'selected' :'') .'>'. $val['name'].'</option>';
                                    } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="team" class="form-label">Team Member</label>
                                <select id="team" name="user[]" class="form-select" multiple="" aria-label="multiple select example" required>
                                    <option>Choose Team...</option>
                                    <?php echo $memeber;?>
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