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
                        <h2>Reports - HRM Reports</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="">Reports</a></li>
                            <li class="breadcrumb-item active">HRM</li>
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
                                    <th>Access Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ret = "SELECT * FROM users WHERE user_access_level != 'Member'  ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($users = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td>
                                            <a href="modules_hrm_profile?view=<?php echo $users->user_id; ?>">
                                                <?php echo $users->user_name; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $users->user_phone; ?></td>
                                        <td><?php echo $users->user_email; ?></td>
                                        <td><?php echo $users->user_idno; ?></td>
                                        <td><?php echo $users->user_access_level; ?></td>
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