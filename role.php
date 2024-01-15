<?php 
$page_title = 'Role';
include('config.php');
if(!empty($_GET['action'])){
    echo json_encode(Role::getRole());
    die;
} else if(!empty($_POST['name'])){
    Role::saveRole($_POST);
    echo 1;
    die;
} else if(!empty($_POST['role_id'])){
    Role::deleteRole($_POST['role_id']);
    echo 1;
    die;
}
include('header.php');
include('header.inc'); 
include('left.inc');
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Roles</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Roles</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Role</h5>
                        <form class="row g-3">
                            <div class="col-12">
                                <label for="role_name" class="form-label">Role</label>
                                <input type="text" class="form-control" id="role_name" name="role_name" />
                                <input type="hidden" class="form-control" id="role_id" name="role_id" />
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-primary" id="btn_add_role" >Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Roles List</h5>
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="role_tbody">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    var btn_add_role =document.getElementById("btn_add_role");
    const update_role =(id, name) => {
        document.getElementById('role_id').value = id;
        document.getElementById('role_name').value = name;
    }
    const delte_delete_rolerole =(id) => {
        var formData = new FormData();
        formData.append('role_id', document.getElementById('role_id').value);
        const res = fetch("role.php", {
            method: "POST",
            body: formData
        });
        res.then(res => res.json()).then(data => {
            getRole();
        })
    }
    const getRole = () => {
        const fetchRes = fetch("role.php?action=result", {
            method: "GET",
            headers: {
                "Content-type": "application/json; charset=UTF-8"
            }
        });
        fetchRes.then(res =>
            res.json()).then(data => {
                let html = '';
                let i =1;
                for (val of data) {
                    html +=`<tr>
                        <td>${i}</td>
                        <td>${val.name}</td>
                        <td><a href="javascript:" onclick="update_role(${val.id}, '${val.name}')">Edit</a> | <a href="javascript:"  onclick="delete_role(${val.id})">Delete</a></td>
                    </tr>`;
                    i++;
                }
                document.getElementById('role_tbody').innerHTML = html;
            }
        )
    }
    getRole();
    btn_add_role.onclick= function(){
        var formData = new FormData();
        formData.append('name', document.getElementById('role_name').value);
        formData.append('id', document.getElementById('role_id').value);
        const res = fetch("role.php", {
            method: "POST",
            body: formData
        });
        res.then(res => res.json()).then(data => {
            getRole();
        })
    }    
</script>
