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

/* Delete Account */

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
    $ret = "SELECT * FROM users WHERE user_id = '$view'";
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
                                <li class="breadcrumb-item"><a href="modules_hrm">HRM</a></li>
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
                                    <span class="">Access Level: <?php echo $hrm->user_access_level;  ?></span><br>
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
                                    <?php
                                    $user_access_level = $_SESSION['user_access_level'];
                                    /* Only Show This If Access Level Is Admin */
                                    if ($user_access_level == 'Administrator') {
                                    ?>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#change_password">Change Password</a></li>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#change_access_level">Update Access Level</a></li>
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
                                    <div role="tabpanel" class="tab-pane" id="delete_account">
                                        <h2 class="card-inside-title">Security Settings</h2>
                                        <div class="row clearfix">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="Username">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" placeholder="Current Password">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" placeholder="New Password">
                                                    </div>
                                                </div>
                                                <button class="btn btn-raised btn-success btn-sm">Save Changes</button>
                                            </div>
                                        </div>
                                        <h2 class="card-inside-title">Account Settings</h2>
                                        <div class="row clearfix">
                                            <div class="col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="First Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="Last Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea rows="4" class="form-control no-resize" placeholder="Address Line 1"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="City">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="E-mail">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" placeholder="Country">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group checkbox">
                                                    <label>
                                                        <input name="optionsCheckboxes" type="checkbox">
                                                        <span class="checkbox-material"><span class="check"></span></span> Profile Visibility For Everyone </label>
                                                </div>
                                                <div class="form-group checkbox m-t-0">
                                                    <label>
                                                        <input name="optionsCheckboxes" checked="" type="checkbox">
                                                        <span class="checkbox-material"><span class="check"></span></span> New task notifications </label>
                                                </div>
                                                <div class="form-group checkbox m-t-0">
                                                    <label>
                                                        <input name="optionsCheckboxes" type="checkbox">
                                                        <span class="checkbox-material"><span class="check"></span></span> New friend request notifications </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <button class="btn btn-raised btn-success">Save Changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>
    <?php require_once('partials/scripts.php'); ?>
</body>

</html>