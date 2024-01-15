<?php 
$page_title = !empty($_GET['id']) ? 'Edit User' : 'Add User';
include('config.php');
hasAccess('add_user');
if(!empty($_POST)){
    User::saveUser($_POST);
    header('location: users.php');
} elseif (!empty($_GET['id'])){
    $user = User::getUserById($_GET['id']);
}
include('header.php');
include('header.inc'); 
include('left.inc');
$roles = Role::getRole();
?>
<main id="main" class="main">
    <div class="pagetitle">
    <h1><?php echo $page_title; ?></h1>
    <nav>
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="users.php">User List</a></li>
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
                                <input type="hidden" value="<?php echo !empty($user['id']) ? $user['id'] :'' ?>" name="id" id="id" />
                                <input type="text" class="form-control" id="name" name="name" required value = "<?php echo !empty($user['name']) ? $user['name'] :'' ?>" />
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required value = "<?php echo !empty($user['email']) ? $user['email'] :'' ?>" />
                            </div>
                            <div class="col-12">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" autocomplete="new-password" name="password" <?php echo empty($user['id']) ? 'required' :'' ?> />
                            </div>
                            <div class="col-12">
                                <label for="gender" class="form-label">Gender</label>
                                <select id="gender" name="gender" class="form-select" required>
                                    <option selected="">Choose Gender...</option>
                                    <option value="Male"  <?php echo (!empty($user['gender']) && $user['gender'] == 'Male') ? 'selected' :'' ?>>Male</option>
                                    <option value="Female"  <?php echo (!empty($user['gender']) && $user['gender'] == 'Female') ? 'selected' :'' ?>>Female</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="role" class="form-label">Role</label>
                                <select id="role" name="role" class="form-select" required>
                                    <option selected="">Choose Role...</option>
                                    <?php foreach($roles as $role) { ?>
                                    <option value="<?php echo $role['id'];?>"  <?php echo (!empty($user['role_id']) && $user['role_id'] == $role['id']) ? 'selected' :'' ?>><?php echo $role['name'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="btn_user_add">Submit</button>
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
    var btn_user_add =document.getElementById("btn_user_add");
    btn_user_add.onclick= function(){
        var formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('id', document.getElementById('id').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('password', document.getElementById('password').value);
        formData.append('role', document.getElementById('role').value);
        const res = fetch("add_user.php", {
            method: "POST",
            body: formData
        });
        res.then(res => res.json()).then(data => {
        })
    }    
</script>
 <? include('footer.inc');