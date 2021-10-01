<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
require_once('config/codeGen.php');
checklogin();

/* Add Member */
if (isset($_POST['Add_Member'])) {
    $user_id = $sys_gen_id;
    $user_name = $_POST['user_name'];
    $user_phone = $_POST['user_phone'];
    $user_password = sha1(md5($_POST['user_password']));
    $user_email = $_POST['user_email'];
    $user_idno = $_POST['user_idno'];
    $user_access_level = 'Member';
    $user_created_on = date('d, M Y');

    /* Prevent Double Entries */
    $sql = "SELECT * FROM  users WHERE user_email = '$user_email' || user_phone = '$user_phone'   ";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($user_email == $row['user_email'] || $user_phone == $row['user_phone']) {
            $err =  "Email Or Phone Number Already Exists";
        }
    } else {
        $query = "INSERT INTO users(user_id, user_name, user_phone, user_password, user_email, user_idno, user_access_level, user_created_on) VALUES(?,?,?,?,?,?,?,?)";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('ssssssss', $user_id, $user_name, $user_phone, $user_password, $user_email, $user_idno, $user_access_level, $user_created_on);
        $stmt->execute();
        if ($stmt) {
            $success = "$user_name Added";
        } else {
            $info = "Please Try Again Or Try Later";
        }
    }
}

/* Delete Staff */
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $adn = "DELETE FROM users WHERE user_id=?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $delete);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Deleted" && header("refresh:1; url=modules_memberships_members");
    } else {
        $err = "Please Try Again Later";
    }
}
require_once('partials/head.php');
?>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <?php require_once('partials/loader.php'); ?>
    </div>

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>

    <!-- Top Bar -->
    <?php require_once('partials/navigation.php'); ?>

    <!-- Left Sidebar -->
    <?php require_once('partials/sidebar.php'); ?>

    <!-- Add Staff Modal -->
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-7">
                        <h2>Members</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="">Memberships</a></li>
                            <li class="breadcrumb-item active">Members</li>
                        </ul>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Register New Member</button>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone Number</th>
                                    <th>Email Adr</th>
                                    <th>ID Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ret = "SELECT * FROM users WHERE user_access_level = 'Member'";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($members = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td>
                                            <a href="modules_memberships_member?view=<?php echo $members->user_id; ?>">
                                                <?php echo $members->user_name; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $members->user_phone; ?></td>
                                        <td><?php echo $members->user_email; ?></td>
                                        <td><?php echo $members->user_idno; ?></td>
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Add Modal -->
    <div class="modal fade" id="add_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="largeModalLabel">Register New Member</h4>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <fieldset class="border border-primary p-2">
                            <legend class="w-auto text-primary"><small> Member Personal Information </small></legend>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <div class="form-line">
                                            <input type="text" name="user_name" required class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <div class="form-line">
                                            <input type="text" name="user_phone" required class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>National ID No</label>
                                        <div class="form-line">
                                            <input type="text" name="user_idno" required class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="form-line">
                                            <input type="text" name="user_email" required class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="form-line">
                                            <input type="password" name="user_password" required class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border border-primary p-2">
                            <legend class="w-auto text-primary"><small> Membership Package </small></legend>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Select Package Name</label>
                                        <div class="form-line">
                                            <select name="user_membership_package_package_id" class="form control">
                                                <?php
                                                $ret = "SELECT * FROM membership_packages  ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($package = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $package->package_id; ?>"><?php echo $package->package_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="Add_Member" class="btn btn-link waves-effect">SAVE CHANGES</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <?php require_once('partials/scripts.php'); ?>
</body>

</html>