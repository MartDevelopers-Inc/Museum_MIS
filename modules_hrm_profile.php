<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
checklogin();
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
                                <li class="breadcrumb-item"><a href="dashboard">HRM</a></li>
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
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#change_access_level">Update Access Level</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#delete_account">Delete Account</a></li>
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
                                        <div class="timeline-body">
                                            <div class="timeline m-border">
                                                <div class="timeline-item">
                                                    <div class="item-content">
                                                        <div class="text-small">Just now</div>
                                                        <p>Finished task #features 4.</p>
                                                    </div>
                                                </div>
                                                <div class="timeline-item border-info">
                                                    <div class="item-content">
                                                        <div class="text-small">11:30</div>
                                                        <p>@Jessi retwit your post</p>
                                                    </div>
                                                </div>
                                                <div class="timeline-item border-warning border-l">
                                                    <div class="item-content">
                                                        <div class="text-small">10:30</div>
                                                        <p>Call to customer #Jacob and discuss the detail.</p>
                                                    </div>
                                                </div>
                                                <div class="timeline-item border-warning">
                                                    <div class="item-content">
                                                        <div class="text-small">3 days ago</div>
                                                        <p>Jessi commented your post.</p>
                                                    </div>
                                                </div>
                                                <div class="timeline-item border-danger">
                                                    <div class="item-content">
                                                        <div class="text--muted">Thu, 10 Mar</div>
                                                        <p>Trip to the moon</p>
                                                    </div>
                                                </div>
                                                <div class="timeline-item border-info">
                                                    <div class="item-content">
                                                        <div class="text-small">Sat, 5 Mar</div>
                                                        <p>Prepare for presentation</p>
                                                    </div>
                                                </div>
                                                <div class="timeline-item border-danger">
                                                    <div class="item-content">
                                                        <div class="text-small">Sun, 11 Feb</div>
                                                        <p>Jessi assign you a task #Mockup Design.</p>
                                                    </div>
                                                </div>
                                                <div class="timeline-item border-info">
                                                    <div class="item-content">
                                                        <div class="text-small">Thu, 17 Jan</div>
                                                        <p>Follow up to close deal</p>
                                                    </div>
                                                </div>
                                                <div class="timeline-item">
                                                    <div class="item-content">
                                                        <div class="text-small">Just now</div>
                                                        <p>Finished task #features 4.</p>
                                                    </div>
                                                </div>
                                                <div class="timeline-item border-info">
                                                    <div class="item-content">
                                                        <div class="text-small">11:30</div>
                                                        <p>@Jessi retwit your post</p>
                                                    </div>
                                                </div>
                                                <div class="timeline-item border-warning border-l">
                                                    <div class="item-content">
                                                        <div class="text-small">10:30</div>
                                                        <p>Call to customer #Jacob and discuss the detail.</p>
                                                    </div>
                                                </div>
                                                <div class="timeline-item border-warning">
                                                    <div class="item-content">
                                                        <div class="text-small">3 days ago</div>
                                                        <p>Jessi commented your post.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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