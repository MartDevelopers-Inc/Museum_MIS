<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
checklogin();

/* Update Profile */
if (isset($_POST['Update_Account'])) {
    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_phone = $_POST['user_phone'];
    $user_idno = $_POST['user_idno'];

    $query = 'UPDATE  users SET user_name =?, user_email =?, user_phone =?, user_idno =? WHERE user_id =?';
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param(
        'sssss',
        $user_name,
        $user_email,
        $user_phone,
        $user_idno,
        $user_id
    );
    $stmt->execute();
    if ($stmt) {
        $success = $user_name . ' Account Updated';
    } else {
        $err = 'Please Try Again Or Try Later';
    }
}


/* Change Password */
if (isset($_POST['Update_Password'])) {
    $user_id = $_POST['user_id'];
    $new_password = sha1(md5($_POST['new_password']));
    $confirm_password = sha1(md5($_POST['confirm_password']));

    /* Check if passwords match */
    if ($new_password != $confirm_password) {
        $err = "Passwords Does Not Match";
    } else {
        $query = 'UPDATE  users SET user_password =? WHERE user_id =?';
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param(
            'ss',
            $confirm_password,
            $user_id
        );
        $stmt->execute();
        if ($stmt) {
            $success = 'Password Updated';
        } else {
            $err = 'Please Try Again Or Try Later';
        }
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
    <?php
    require_once('partials/sidebar.php');
    $view = $_GET['view'];
    $ret = "SELECT * FROM users s
     INNER JOIN user_membership_package  ump ON s.user_id = ump.user_membership_package_user_id
     INNER JOIN membership_packages mp ON mp.package_id = ump.user_membership_package_package_id
     WHERE s.user_id = '$view'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($hrm = $res->fetch_object()) {
        if ($hrm->user_profile_pic == '') {
            $url = "assets/images/no-profile.png";
        } else {
            $url = "assets/images/$hrm->user_profile_pic";
        }
    ?>


        <section class="content profile-page">
            <div class="container-fluid">
                <div class="block-header">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-7">
                            <h2><?php echo $hrm->user_name; ?> Profile</h2>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="modules_memberships_members">Memberships</a></li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="boxs-simple">
                            <div class="profile-header">
                                <div class="profile_info">
                                    <div class="profile-image"> <img src="<?php echo $url; ?>" alt=""> </div>
                                    <h4 class="mb-0"><strong><?php echo $hrm->user_name; ?></strong></h4>
                                    <span class="">Email: <?php echo $hrm->user_email;  ?></span><br>
                                    <span class="">Contacts: <?php echo $hrm->user_phone;  ?></span><br>
                                    <span class="">ID No: <?php echo $hrm->user_idno;  ?></span><br>
                                    <span class="">Membership Package: <?php echo $hrm->package_name;  ?></span><br>
                                    <span class="">Package Rate: Ksh <?php echo $hrm->package_pricing;  ?></span><br>
                                    <span class="">Member Since : <?php echo $hrm->user_created_on;  ?></span><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-1">
                        <div class="card">
                            <div class="body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#profile_settings">Profile Settings</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#change_password">Change Password</a></li>
                                    <?php
                                    $user_access_level = $_SESSION['user_access_level'];
                                    /* Only Show This If Access Level Is Admin */
                                    if ($user_access_level == 'Administrator') {
                                    ?>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#change_access_level">Update Membership Package</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#delete_account">Delete Account</a></li>
                                    <?php } ?>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="profile_settings">
                                        <div class="wrap-reset">
                                            <form method="POST">
                                                <div class="modal-body">
                                                    <div class="row clearfix">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Full Name</label>
                                                                <div class="form-line">
                                                                    <input type="text" name="user_name" value="<?php echo $hrm->user_name; ?>" required class="form-control" />
                                                                    <!-- Hide This -->
                                                                    <input type="hidden" name="user_id" value="<?php echo $hrm->user_id; ?>" required class="form-control" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Phone Number</label>
                                                                <div class="form-line">
                                                                    <input type="text" name="user_phone" value="<?php echo $hrm->user_phone; ?>" required class="form-control" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>National ID No</label>
                                                                <div class="form-line">
                                                                    <input type="text" name="user_idno" value="<?php echo $hrm->user_idno; ?>" required class="form-control" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <div class="form-line">
                                                                    <input type="text" name="user_email" value="<?php echo $hrm->user_email; ?>" required class="form-control" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="Update_Account" class="btn btn-link waves-effect">SAVE CHANGES</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="change_password">
                                        <form method="POST">
                                            <div class="modal-body">
                                                <div class="row clearfix">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>New Password</label>
                                                            <div class="form-line">
                                                                <input type="password" name="new_password" required class="form-control" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Confirm New Password</label>
                                                            <div class="form-line">
                                                                <input type="password" name="confirm_password" required class="form-control" />
                                                                <!-- Hide This -->
                                                                <input type="hidden" name="user_id" value="<?php echo $hrm->user_id; ?>" required class="form-control" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="Update_Password" class="btn btn-link waves-effect">SAVE CHANGES</button>
                                            </div>
                                        </form>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="change_access_level">
                                        <br>
                                        <h2 class="card-inside-title text-center">Update <?php echo $hrm->user_name; ?> Membership Package</h2>
                                        <form method="POST">
                                            <div class="modal-body">
                                                <div class="row clearfix">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label>Select Membership Package Name</label>
                                                            <div class="form-line">
                                                                <select name="user_membership_package_package_id" class="form-control show-tick">
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
                                                        <!-- Hide This -->
                                                        <input type="hidden" name="user_id" value="<?php echo $hrm->user_id; ?>" required class="form-control" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="Update_Membership" class="btn btn-link waves-effect">SAVE CHANGES</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="delete_account">
                                        <div class="row clearfix">
                                            <div class="modal-body">
                                                <div class="row clearfix">
                                                    <br>
                                                    <h2 class="card-inside-title  text-danger text-center">
                                                        Heads Up!, you are about to delete <?php echo $hrm->user_name; ?> Staff account.
                                                        This action is reversible, the system will permanently delete <?php echo $hrm->user_name; ?>
                                                        records and any other related records too.
                                                    </h2>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#delete_modal">Delete Account</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Delete Account Modal -->
        <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">CONFIRM</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center text-danger">
                        <h4>Delete <?php echo $hrm->user_name; ?> ?</h4>
                        <br>
                        <p>Heads Up, You are about to delete <?php echo $hrm->user_name; ?>. This action is irrevisble.</p>
                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                        <a href="modules_memberships_members?delete=<?php echo $hrm->user_id; ?>" class="text-center btn btn-danger"> Delete </a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php require_once('partials/scripts.php'); ?>
</body>

</html>