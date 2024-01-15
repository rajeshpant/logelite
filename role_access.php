<?php 
$page_title = 'Role Access';
include('config.php');
if(!empty($_POST)){
    Role::assignAccess($_POST);
} else if(!empty($_GET['role'])){
    echo json_encode(Role::getAccess($_GET['role']));
    die;
}
include('header.php');
include('header.inc'); 
include('left.inc');
$roles = Role::getRole();
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Roles Access</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Roles Access</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Role Access</h5>
                        <form class="row g-3" method="post">
                            <div class="col-12">
                                <label for="role" class="form-label">Role</label>
                                <select id="role" name="role" class="form-select" required>
                                    <option value="">Choose Role...</option>
                                    <?php foreach($roles as $role) { ?>
                                    <option value="<?php echo $role['id'];?>"  <?php echo (!empty($user['role_id']) && $user['role_id'] == $role['id']) ? 'selected' :'' ?>><?php echo $role['name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <?php foreach($action_arr as $key=>$val) { ?>
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input accecc_chk" type="checkbox" name="access_chk[]" id="<?php echo $key ?>" value="<?php echo $key ?>" />
                                    <input type="hidden" name="action_value[]" id="act_<?php echo $key ?>" value="0" />
                                    <input type="hidden" name="action[]" id="acts_<?php echo $key ?>" value="<?php echo $key ?>" />
                                    <label class="form-check-label" for="<?php echo $key ?>">
                                        <?php echo $val ?>
                                    </label>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="btn_add_role" >Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    const chkList = document.querySelectorAll(".accecc_chk");
    chkList.forEach(access => { 
        access.addEventListener("click", () => { 
            if(access.checked){
                document.getElementById('act_'+access.getAttribute('id')).value =1;
            } else {
                document.getElementById('act_'+access.getAttribute('id')).value =0;
            }
        });
    });
    document.getElementById('role').addEventListener('change', function() {
        const fetchRes = fetch("role_access.php?role="+this.value, {
            method: "GET"
        });
        fetchRes.then(res =>
            res.json()).then(data => {
                for (val of data) {
                    if(val.is_access==1){
                        document.getElementById('act_'+val.action).value =1;
                        document.getElementById(val.action).checked =true;
                    } else {
                        document.getElementById('act_'+val.action).value =0;
                        document.getElementById(val.action).checked =false;
                    }
                }
            }
        )
    });
</script>
