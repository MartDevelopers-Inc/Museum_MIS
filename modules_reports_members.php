<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
require_once('config/codeGen.php');
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
    <?php require_once('partials/sidebar.php'); ?>

    <!-- Add Staff Modal -->
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-7">
                        <h2>Reports - Members</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="">Reports</a></li>
                            <li class="breadcrumb-item active">Members</li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone Number</th>
                                    <th>Email Adr</th>
                                    <th>ID Number</th>
                                    <th>Member Package Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ret = "SELECT * FROM users u
                                INNER JOIN user_membership_package ump
                                ON ump.user_membership_package_user_id = u.user_id
                                INNER JOIN membership_packages mp ON mp.package_id = ump.user_membership_package_package_id
                                 WHERE user_access_level = 'Member'";
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
                                        <td>
                                            Package : <?php echo $members->package_name; ?><br>
                                            Rate : <?php echo $members->package_pricing; ?>
                                        </td>
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

    <!-- Scripts -->
    <?php require_once('partials/scripts.php'); ?>
</body>

</html>