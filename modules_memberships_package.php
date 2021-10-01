<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
require_once('config/codeGen.php');
checklogin();

/* Membership Package */
if (isset($_POST['Add_Package'])) {
    $package_id = $sys_gen_id;
    $package_name = $_POST['package_name'];
    $package_details = $_POST['package_details'];
    $package_pricing = $_POST['package_pricing'];

    /* Prevent Double Entries */
    $sql = "SELECT * FROM  membership_packages WHERE package_name = '$package_name'";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($package_name == $row['package_name']) {
            $err =  "Package Name Already Exists";
        }
    } else {
        $query = "INSERT INTO membership_packages (package_id, package_pricing,  package_name, package_details) VALUES(?,?,?,?)";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('ssss', $package_id, $package_pricing, $package_name, $package_details);
        $stmt->execute();
        if ($stmt) {
            $success = "$package_name Added";
        } else {
            $info = "Please Try Again Or Try Later";
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
    $ret = "SELECT * FROM membership_packages WHERE package_id = '$view' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($packages = $res->fetch_object()) {
    ?>
        <section class="content profile-page">
            <div class="container-fluid">
                <div class="block-header">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-7">
                            <h2><?php echo $packages->package_name; ?> Membership Packages</h2>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="modules_hrm">Membership Packages</a></li>
                                <li class="breadcrumb-item active"><?php echo $packages->package_name; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="boxs-simple">
                            <div class="profile-header">
                                <div class="profile_info">
                                    <div class="profile-image"> <img src="assets/images/Membership_Package.png" alt=""> </div>
                                    <h4 class="mb-0"><strong><?php echo $packages->package_name; ?></strong></h4>
                                    <span class="">Subscription Fee: Ksh <?php echo $packages->package_pricing;  ?></span><br>
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
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#package_settings">Update Membership Package</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#subscribed_members">Subscribed Members</a></li>

                                    <?php
                                    $user_access_level = $_SESSION['user_access_level'];
                                    /* Only Show This If Access Level Is Admin */
                                    if ($user_access_level == 'Administrator') {
                                    ?>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#delete_package">Delete Package</a></li>
                                    <?php } ?>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="subscribed_members">
                                        <div class="wrap-reset">

                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="delete_package">
                                        <div class="row clearfix">
                                            <div class="modal-body">
                                                <div class="row clearfix">
                                                    <br>
                                                    <h2 class="card-inside-title  text-danger text-center">
                                                        Heads Up!, you are about to delete <?php echo $packages->package_name; ?> membership package
                                                    </h2>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#delete_modal">Delete Package</button>
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
                        <h4>Delete <?php echo $packages->package_name; ?> ?</h4>
                        <br>
                        <p>Heads Up, You are about to delete <?php echo $package->package_name; ?>. This action is irrevisble.</p>
                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                        <a href="modules_memberships_packages?delete=<?php echo $packages->package_id; ?>" class="text-center btn btn-danger"> Delete </a>
                    </div>
                </div>
            </div>
        </div>
    <?php }
    require_once('partials/scripts.php');
    ?>
</body>

</html>